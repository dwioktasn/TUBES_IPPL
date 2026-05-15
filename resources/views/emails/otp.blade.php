<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OTP Login</title>
</head>

<body style="font-family: Arial, sans-serif; background: #F3F4F6; padding: 40px;">

    <div style="
        max-width: 500px;
        margin: auto;
        background: white;
        padding: 40px;
        border-radius: 16px;
        text-align: center;
    ">

        <h1 style="color: #C02428;">
            TelU Events
        </h1>

        <p>Kode OTP login admin kamu:</p>

        <div style="
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 8px;
            margin: 30px 0;
            color: #111827;
        ">
            {{ $otp }}
        </div>

        <p>
            OTP berlaku selama <b>5 menit</b>.
        </p>

    </div>

</body>

</html>