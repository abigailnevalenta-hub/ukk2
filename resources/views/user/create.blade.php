@extends('layouts.app')

@section('title', 'Tambah User - PSS')

@section('header_title', 'Tambah User')
@section('header_subtitle', 'Halaman tambah user baru.')

@section('content')
    <div class="table-section">
        <div class="table-header">
            <h3>Form Tambah User</h3>
            <div class="header-controls">
                <a href="{{ route('user.index') }}" class="filter-btn">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="table-body">
            <form action="{{ route('user.store') }}" method="POST" class="form-container">
                @csrf

                <div class="filter-container">
                    {{-- ROLE --}}
                    <div class="filter-item">
                        <label>Role</label>
                        <select class="filter-input" id="role" name="role" required>
                            <option value="user" {{ old('role') == 'user' || old('role') === null ? 'selected' : '' }}>
                                User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    {{-- NAMA --}}
                    <div class="filter-item">
                        <label>Nama Lengkap</label>
                        <input type="text" class="filter-input" id="name" name="name" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="filter-item" id="emailField">
                        <label>Email</label>
                        <input type="email" class="filter-input" id="email" name="email"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="filter-item" id="passwordField">
                        <label>Password</label>
                        <input type="password" class="filter-input" id="password" name="password">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror

                        <label>Konfirmasi Password</label>
                        <input type="password" class="filter-input" id="password_confirmation" name="password_confirmation">
                    </div>

                    {{-- NISN --}}
                    <div class="filter-item" id="nisnField">
                        <label>NISN</label>
                        <input type="number" class="filter-input" id="nisn" name="nisn"
                            value="{{ old('nisn') }}">
                        @error('nisn')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="filter-action">
                        <button type="submit" class="filter-btn">Simpan User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .filter-container {
            display: flex;
            flex-direction: column;
            gap: 18px;
            width: 100%;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: 100%;
        }

        .filter-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdcdc;
            border-radius: 6px;
            font-size: 14px;
        }

        .filter-input:focus {
            outline: none;
            border-color: #ff7a00;
        }

        .filter-action {
            grid-column: span 2;
            /* tombol full */
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .filter-btn {
            background: #ff7a00;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .table-section {
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
            /* supaya di tengah */
        }

        .table-body {
            width: 100%;
            max-width: 820px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const role = document.getElementById("role")
            const emailField = document.getElementById("emailField")
            const passwordField = document.getElementById("passwordField")
            const nisnField = document.getElementById("nisnField")

            function toggleField() {
                if (role.value === "user") {
                    emailField.style.display = "none"
                    passwordField.style.display = "none"
                    nisnField.style.display = "flex"
                } else {
                    emailField.style.display = "flex"
                    passwordField.style.display = "flex"
                    nisnField.style.display = "none"
                }
            }

            toggleField() // 🔥 langsung jalan saat halaman dibuka
            role.addEventListener("change", toggleField)
        })
    </script>
@endsection
