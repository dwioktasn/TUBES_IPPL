<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - TelU Events</title>

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
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-title">
            <h1>TelU <span>Events</span></h1>
            <p>Admin Dashboard</p>
        </div>

        @if (session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

    </div>

</body>

</html>
