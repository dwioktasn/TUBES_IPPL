<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TelU Events</title>
    <!-- We assume you will serve static files correctly in Spring Boot, for now we use relative paths -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>

<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- HERO SECTION (SHORT) -->
    <header class="hero hero-short">
        <div class="hero-content">
            <h1>Tentang TelU Events</h1>
            <p>Platform manajemen event kampus untuk mahasiswa Telkom University Purwokerto</p>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main style="padding-bottom: 100px; background-color: var(--white);">
        <!-- APA ITU TELU EVENTS -->
        <section class="container" style="max-width: 800px; padding-top: 80px; padding-bottom: 80px;">
            <div class="about-header" style="justify-content: flex-start;">
                <div class="about-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18h6"></path>
                        <path d="M10 22h4"></path>
                        <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path>
                    </svg>
                </div>
                <h2>Apa itu TelU Events?</h2>
            </div>
            <p style="color: var(--text-muted); line-height: 1.8; font-size: 1.1rem;">
                TelU Events adalah platform terpusat yang menghubungkan mahasiswa Telkom University Purwokerto dengan berbagai
                event kampus. Dari seminar, workshop, kompetisi, hingga kegiatan UKM — semua informasi event tersedia dalam satu
                tempat yang mudah diakses. Platform ini memungkinkan penyelenggara event untuk mempublikasikan kegiatan mereka dan mahasiswa dapat menemukan event yang sesuai dengan minat mereka.
            </p>
        </section>

        <!-- MENGAPA MENGGUNAKAN TELU EVENTS -->
        <div style="background-color: var(--bg-light); padding: 80px 0;">
            <section class="container">
                <div class="about-header" style="justify-content: center; margin-bottom: 40px;">
                    <div class="about-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h2>Mengapa Menggunakan TelU Events?</h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <!-- Feature 1 -->
                    <div class="card" style="text-align: center; padding: 40px 24px; border: none; box-shadow: var(--shadow-sm); background-color: var(--white); border-radius: var(--radius-lg);">
                        <div class="about-icon" style="margin: 0 auto 20px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <h3 style="margin-bottom: 16px; font-size: 1.15rem; color: var(--text-dark);">Event Terverifikasi</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">Semua event telah melalui proses verifikasi admin sehingga informasi yang ditampilkan terpercaya dan akurat.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card" style="text-align: center; padding: 40px 24px; border: none; box-shadow: var(--shadow-sm); background-color: var(--white); border-radius: var(--radius-lg);">
                        <div class="about-icon" style="margin: 0 auto 20px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                        <h3 style="margin-bottom: 16px; font-size: 1.15rem; color: var(--text-dark);">Info TAK Terintegrasi</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">Event yang memberikan poin TAK ditandai dengan jelas, memudahkan mahasiswa dalam memenuhi kewajiban TAK.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card" style="text-align: center; padding: 40px 24px; border: none; box-shadow: var(--shadow-sm); background-color: var(--white); border-radius: var(--radius-lg);">
                        <div class="about-icon" style="margin: 0 auto 20px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 style="margin-bottom: 16px; font-size: 1.15rem; color: var(--text-dark);">Akses Mudah untuk UKM</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">UKM dan organisasi kampus dapat dengan mudah mempublikasikan event mereka melalui formulir yang sederhana.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- MISI KAMI -->
        <section class="container" style="max-width: 800px; padding-top: 80px;">
            <div class="about-header" style="justify-content: center; margin-bottom: 24px;">
                <div class="about-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="6"></circle>
                        <circle cx="12" cy="12" r="2"></circle>
                    </svg>
                </div>
                <h2>Misi Kami</h2>
            </div>
            <p style="color: var(--text-muted); line-height: 1.8; font-size: 1.1rem; text-align: center;">
                Misi kami adalah mempermudah akses informasi event kampus bagi seluruh mahasiswa Telkom University Purwokerto.
                Kami percaya bahwa keterlibatan aktif dalam kegiatan kampus merupakan bagian penting dari pengalaman kuliah,
                dan setiap mahasiswa berhak mendapatkan akses yang mudah terhadap informasi event yang relevan dan berkualitas.
            </p>
        </section>
    </main>

    <!-- FOOTER -->
    @include('components.footer')
</body>

</html>