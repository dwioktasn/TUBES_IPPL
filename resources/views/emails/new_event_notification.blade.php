<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Baru Membutuhkan Verifikasi</title>
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
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .email-header {
            background-color: #dc2626;
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
            display: flex;
            margin-bottom: 12px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            width: 140px;
            color: #4b5563;
        }
        .detail-value {
            color: #111827;
            flex: 1;
        }
        .btn {
            display: inline-block;
            background-color: #dc2626;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
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
            <h1>Notifikasi Event Baru</h1>
        </div>
        <div class="email-body">
            <p>Halo Admin,</p>
            <p>Seseorang baru saja mengirimkan pengajuan event baru di sistem TelU Events. Event ini sekarang berstatus <strong>Pending</strong> dan membutuhkan verifikasi Anda.</p>
            
            <div class="event-details">
                <div class="detail-row">
                    <div class="detail-label">Judul Event</div>
                    <div class="detail-value">{{ $event->title }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Penyelenggara</div>
                    <div class="detail-value">{{ $event->organizer_name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value">{{ ucfirst($event->category) }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Pelaksanaan</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('d F Y - H:i') }} WIB</div>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('admin.login') }}" class="btn">Buka Dashboard Admin</a>
            </div>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} TelU Events. All rights reserved.</p>
            <p>Ini adalah email otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
