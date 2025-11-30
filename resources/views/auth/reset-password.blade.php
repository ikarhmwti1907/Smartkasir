<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SmartKasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #ffffff;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, Helvetica, sans-serif;
    }

    .login-card {
        background-color: #1b3b63;
        color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 370px;
        padding: 35px 35px;
        text-align: center;
    }

    .login-card img {
        width: 75px;
        height: 75px;
        display: block;
        margin: 0 auto 25px auto;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #f57c00;
        box-shadow: 0 0 5px rgba(245, 124, 0, 0.6);
    }

    .btn-login {
        background-color: #f57c00;
        color: #fff;
        font-weight: bold;
        border: none;
        transition: 0.2s ease-in-out;
    }

    .btn-login:hover {
        background-color: #e96f00;
    }

    .alert {
        font-size: 14px;
        padding: 8px;
        border-radius: 4px;
        text-align: center;
        color: #000;
    }

    .back-to-login {
        display: block;
        margin-top: 15px;
        color: #ffb74d;
        font-size: 14px;
        text-decoration: none;
        transition: 0.2s;
    }

    .back-to-login:hover {
        color: #ffc107;
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="login-card">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">

        <h4 class="mb-3">Reset Password</h4>

        @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger mb-3">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-login w-100">Reset Password</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">Kembali ke Login</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>