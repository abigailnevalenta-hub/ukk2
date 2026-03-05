<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 550px;
            background: #ffffff;
            padding: 48px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #242424;
        }

        .subtitle {
            font-size: 16px;
            color: #919191;
            margin-top: 8px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #242424;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #ee5307;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        #togglePassword {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #919191;
            font-size: 16px;
        }

        #togglePassword:hover {
            color: #ee5307;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #f97534, #ee5307);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        /* .divider {
  display: flex;
  align-items: center;
  margin: 28px 0;
  color: #919191;
  font-size: 14px;
}

.divider::before,
.divider::after {
  content: "";
  flex: 1;
  height: 1px;
  background: #e9e9e9;
}

.divider span {
  margin: 0 12px;
}

.google-btn {
  width: 100%;
  padding: 14px;
  border-radius: 12px;
  border: 1px solid #e5e5e5;
  background: #fff;
  font-size: 15px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.signup {
  text-align: center;
  margin-top: 24px;
  font-size: 14px;
  color: #919191;
}

.signup a {
  color: #ee5307;
  text-decoration: none;
  font-weight: 500;
} */
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome back!</h1>
        <p class="subtitle">Please Login to Continue</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email / NISN</label>
                <input type="text" name="email" placeholder="Enter your email / NISN" required>
            </div>

            <div class="form-group password-group">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    {{-- <div class="divider"><span>or</span></div>

  <button class="google-btn"><i class="fab fa-google"></i>Sign Up with Google</button>

  <div class="signup">
    Have an account? <a href="#">Sign Up</a>
  </div> --}}
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            if (password.type === "password") {
                password.type = "text";
                this.classList.remove("fa-eye-slash");
                this.classList.add("fa-eye");
            } else {
                password.type = "password";
                this.classList.remove("fa-eye");
                this.classList.add("fa-eye-slash");
            }
        });
    </script>

</body>

</html>
