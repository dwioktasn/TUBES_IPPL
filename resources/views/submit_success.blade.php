<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Berhasil - TelU Events</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- CONTENT -->
    <main class="container" style="max-width: 600px; padding-top: 60px; padding-bottom: 80px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; flex: 1;">
        
        <!-- Animated Success Card -->
        <div class="card" style="box-shadow: var(--shadow-lg); padding: 48px 40px; border-radius: 16px; background: var(--white); border: 1px solid var(--border-color); width: 100%; display: flex; flex-direction: column; align-items: center; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
            
            <!-- Beautiful animated checkmark -->
            <div class="success-checkmark-circle" style="width: 80px; height: 80px; border-radius: 50%; background: #ECFDF5; border: 2px solid #10B981; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; color: #10B981; animation: scaleUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 12px; color: var(--text-dark);">
                Pengajuan Berhasil Dikirim!
            </h1>

            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 32px; max-width: 440px;">
                Terima kasih! Event Anda berhasil diajukan ke sistem **TelU Events**. Pengajuan ini akan segera ditinjau dan diverifikasi oleh tim Admin dalam waktu maksimal **1x24 jam** sebelum dipublikasikan.
            </p>

            <!-- Countdown Text -->
            <p id="countdown-text" style="color: var(--text-muted); font-size: 0.85rem; margin-top: -16px; margin-bottom: 28px;">
                Mengarahkan ke halaman Beranda dalam <span id="countdown-number" style="font-weight: 700; color: var(--primary-red);">5</span> detik...
            </p>

            <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 14px; font-weight: 600; width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Kembali ke Beranda
                </a>
                
                <a href="{{ route('submit-event') }}" class="btn" style="padding: 14px; font-weight: 600; width: 100%; border: 1px solid var(--border-color); background: var(--bg-light); color: var(--text-dark);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Ajukan Event Lainnya
                </a>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let timeLeft = 5;
            const countdownNumber = document.getElementById('countdown-number');
            const homeUrl = "{{ route('home') }}";

            const interval = setInterval(() => {
                timeLeft--;
                if (countdownNumber) {
                    countdownNumber.textContent = timeLeft;
                }

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    window.location.href = homeUrl;
                }
            }, 1000);

            // Cancel countdown timer if user clicks any link
            const actionButtons = document.querySelectorAll('a');
            actionButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    clearInterval(interval);
                });
            });
        });
    </script>

    <style>
        @keyframes scaleUp {
            0% { transform: scale(0.6); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes slideUpFade {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>

</body>

</html>
