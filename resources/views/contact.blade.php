<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - TelU Events</title>
    <!-- We assume you will serve static files correctly in Spring Boot, for now we use relative paths -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>
<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- HERO SECTION -->
    <header class="hero hero-short">
        <div class="hero-content">
            <h1>Hubungi Kami</h1>
            <p>Punya pertanyaan atau saran? Kami siap membantu!</p>
        </div>
    </header>

    <!-- CONTACT CONTAINER -->
    <main class="container page-grid">
        <!-- LEFT: FORM -->
        <div class="form-section">
            <h2 class="page-title">Kirim Pesan</h2>

            @if(session('success'))
            <div style="background-color: #ECFDF5; color: #065F46; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #A7F3D0; display: flex; align-items: center; gap: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="email@student.telkomuniversity.ac.id" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="message">Pesan</label>
                    <textarea id="message" name="message" class="form-control" placeholder="Tulis pesan Anda..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Kirim Pesan
                </button>
            </form>
        </div>

        <!-- RIGHT: INFO -->
        <div class="info-section">
            <h2 class="page-title">Informasi Kontak</h2>
            
            <div class="contact-info-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <span>teluevents@telkomuniversity.ac.id</span>
            </div>



            <div class="card contact-info-item" style="margin-top: auto; align-items: flex-start; border: 1px solid var(--border-color); padding: 24px; background-color: var(--bg-light);">
                <div>
                    <h3 style="margin-bottom: 12px; font-size: 1.1rem; color: #1A1A1A;">Lokasi</h3>
                    <p style="margin:0;">Telkom University Purwokerto</p>
                    <p style="margin:0;">Jl. DI Panjaitan No.128, Karangreja,</p>
                    <p style="margin:0;">Purwokerto Kidul, Kec. Purwokerto Sel.,</p>
                    <p style="margin:0;">Kabupaten Banyumas, Jawa Tengah</p>
                    <p style="margin:0;">53147</p>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    @include('components.footer')

</body>
</html>
