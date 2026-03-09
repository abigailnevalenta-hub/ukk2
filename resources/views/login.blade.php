<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin & Siswa</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
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
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 550px;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .tabs {
            display: flex;
            margin-bottom: 32px;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .tab {
            flex: 1;
            padding: 14px;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            background: #f0f0f0;
            color: #555;
        }

        .tab.active {
            background: linear-gradient(90deg, #f97534, #ee5307);
            color: white;
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #242424;
            text-align: center;
        }

        .subtitle {
            font-size: 16px;
            color: #919191;
            text-align: center;
            margin: 8px 0 32px;
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
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #919191;
            font-size: 16px;
        }

        .toggle-password:hover {
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
            margin-top: 12px;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        @media (max-width: 480px) {
            .container {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome Back!</h1>
        <p class="subtitle">Please Login to Continue</p>

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active" data-tab="siswa">Siswa</div>
            <div class="tab" data-tab="admin">Admin</div>
        </div>

        <!-- Form Siswa (NISN) -->
        <form id="form-siswa" class="form active" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nisn">NISN</label>
                <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN Anda" pattern="\d{10}" title="NISN terdiri dari 10 angka">
            </div>
            <button type="submit" class="login-btn">Login sebagai Siswa</button>
        </form>

        <!-- Form Admin (Email) -->
        <form id="form-admin" class="form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda">
            </div>

            <div class="form-group">
                <label for="password-admin">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password-admin" name="password" placeholder="Masukkan password">
                    <i class="fa-solid fa-eye toggle-password" id="toggle-admin"></i>
                </div>
            </div>

            <button type="submit" class="login-btn">Login sebagai Admin</button>
        </form> 
    </div>

    <script>
        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const forms = document.querySelectorAll('.form');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.getAttribute('data-tab');
                forms.forEach(form => {
                    form.classList.remove('active');
                    if (form.id === `form-${target}`) {
                        form.classList.add('active');
                    }
                });
            });
        });

        // Toggle password visibility
      function setupToggle(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    // Cek apakah elemen ada, biar tidak error
    if (!input || !icon) return;

    icon.addEventListener('click', () => {
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
}

        setupToggle('password-siswa', 'toggle-siswa');
        setupToggle('password-admin', 'toggle-admin');
    </script>

</body>
</html>