<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - TelU Events</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --telu-red: #c02428;
            --telu-red-hover: #a11e21;
            --slate-50: #F8FAFC;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-400: #94A3B8;
            --slate-600: #475569;
            --slate-800: #1E293B;
            --slate-900: #0F172A;
        }

        body {
            background: #F8FAFC;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--slate-900);
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 380px;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--slate-200);
            box-sizing: border-box;
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-brand {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: var(--telu-red);
            color: white;
            border-radius: 10px;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            box-shadow: 0 4px 6px -1px rgba(192, 36, 40, 0.2);
        }

        .login-header h1 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            color: var(--slate-800);
        }

        .login-header p {
            font-size: 0.8rem;
            color: var(--slate-600);
            margin: 4px 0 0 0;
        }

        .form-group {
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--slate-600);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            box-sizing: border-box;
            background: var(--slate-50);
            color: var(--slate-800);
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--slate-400);
            background: white;
            box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
        }

        .btn-login {
            width: 100%;
            background: var(--telu-red);
            color: white;
            border: none;
            padding: 11px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 8px;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--telu-red-hover);
        }

        .error-box {
            background: #FEE2E2;
            color: #B91C1C;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.78rem;
            font-weight: 500;
            border: 1px solid #FCA5A5;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-brand">T</div>
            <h1>TelU Events Admin</h1>
            <p>Masukkan email untuk mendapatkan kode OTP</p>
        </div>

        @if (session('error'))
            <div class="error-box">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/send-otp" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Admin</label>
                <input 
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="nama@email.com"
                    required
                >
            </div>

            <button type="submit" class="btn-login">
                Kirim Kode OTP <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>

</body>

</html>
