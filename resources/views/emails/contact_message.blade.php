<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #1f2937;
            padding: 32px 40px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px;
            color: #374151;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .event-details {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 32px;
        }
        .detail-row {
            margin-bottom: 16px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 4px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .detail-value {
            color: #111827;
            font-size: 1.05rem;
            white-space: pre-wrap;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            margin: 0;
            color: #9ca3af;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Pesan Kontak Baru</h1>
        </div>
        <div class="email-body">
            <p>Halo Admin,</p>
            <p>Ada pesan baru dari halaman <strong>Contact Us</strong> TelU Events. Berikut adalah detail pesannya:</p>
            
            <div class="event-details">
                <div class="detail-row">
                    <div class="detail-label">Nama Pengirim</div>
                    <div class="detail-value">{{ $data['name'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email Pengirim</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $data['email'] }}" style="color: #c02428;">{{ $data['email'] }}</a>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Isi Pesan</div>
                    <div class="detail-value" style="background: white; padding: 16px; border: 1px solid #e5e7eb; border-radius: 6px; margin-top: 8px;">{{ $data['message'] }}</div>
                </div>
            </div>
            
            <p style="font-size: 14px; color: #6b7280; text-align: center;">Anda dapat langsung membalas email ini untuk terhubung dengan pengirim (Reply-To telah diatur).</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} TelU Events. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
