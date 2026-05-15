<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - TelU Events</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <style>
        body {
            background: #F3F4F6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background: white;
            width: 400px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .08);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h1 {
            font-size: 2rem;
        }

        .login-title span {
            color: #C02428;
        }

        .btn-login {
            width: 100%;
            background: #C02428;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .error-box {
            background: #FEE2E2;
            color: #991B1B;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .otp-input {
            text-align: center;
            font-size: 1.5rem;
            letter-spacing: 10px;
            font-weight: bold;
        }

        .otp-info {
            text-align: center;
            margin-bottom: 20px;
            color: #6B7280;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-title">
            <h1>Verifikasi <span>OTP</span></h1>
            <p>Masukkan kode OTP yang dikirim ke email</p>
        </div>

        <div class="otp-info">
            OTP dikirim ke: <b>{{ $email }}</b>
        </div>

        @if (session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/verify-otp" method="POST">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label class="form-label">Kode OTP</label>

                <input 
                    type="text"
                    name="otp"
                    class="form-control otp-input"
                    maxlength="6"
                    required
                >
            </div>

            <button type="submit" class="btn-login">
                Verifikasi OTP
            </button>
        </form>

    </div>

</body>

</html>