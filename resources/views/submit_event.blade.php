<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Event - TelU Events</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>

<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- CONTENT -->
    <main class="container" style="max-width: 700px; padding-top: 40px; padding-bottom: 80px;">

        <div style="margin-bottom: 32px;">

            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 8px;">
                Submit Event Baru
            </h1>

            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">
                Isi formulir untuk mengajukan event kamu.
                Event akan ditampilkan setelah diverifikasi admin.
            </p>

        </div>

        <!-- FORM -->
        @if (session('error'))
            <div style="background: #FEE2E2; color: #991B1B; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label class="form-label">
                    Judul Event
                </label>

                <input type="text" name="title" class="form-control" placeholder="Nama event kamu" required>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="description" class="form-control" placeholder="Jelaskan detail event kamu..." required></textarea>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="category" class="form-control" required>

                        <option value="" disabled selected hidden>
                            Pilih Kategori
                        </option>

                        <option value="seminar">
                            Seminar
                        </option>

                        <option value="workshop">
                            Workshop
                        </option>

                        <option value="kompetisi">
                            Kompetisi
                        </option>

                        <option value="lainnya">
                            Lainnya
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Tipe Event
                    </label>

                    <select name="event_type" class="form-control" required>

                        <option value="" disabled selected hidden>
                            Pilih Tipe
                        </option>

                        <option value="online">
                            Online
                        </option>

                        <option value="offline">
                            Offline
                        </option>

                        <option value="hybrid">
                            Hybrid
                        </option>

                    </select>

                </div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Khusus Prodi (Opsional)
                </label>

                <select name="prodi" class="form-control">
                    <option value="">Tidak ada (Untuk Umum/Semua Prodi)</option>
                    <option value="S1 Teknik Telekomunikasi">S1 Teknik Telekomunikasi</option>
                    <option value="S1 Teknik Elektro">S1 Teknik Elektro</option>
                    <option value="S1 Teknik Biomedis">S1 Teknik Biomedis</option>
                    <option value="S1 Teknik Informatika">S1 Teknik Informatika</option>
                    <option value="S1 Rekayasa Perangkat Lunak (Software Engineering)">S1 Rekayasa Perangkat Lunak</option>
                    <option value="S1 Sains Data">S1 Sains Data</option>
                    <option value="S1 Teknik Industri">S1 Teknik Industri</option>
                    <option value="S1 Sistem Informasi">S1 Sistem Informasi</option>
                    <option value="S1 Teknik Logistik">S1 Teknik Logistik</option>
                    <option value="S1 Teknologi Pangan">S1 Teknologi Pangan</option>
                    <option value="S1 Desain Komunikasi Visual">S1 Desain Komunikasi Visual</option>
                    <option value="S1 Desain Produk">S1 Desain Produk</option>
                    <option value="S1 Bisnis Digital">S1 Bisnis Digital</option>
                    <option value="D3 Teknik Telekomunikasi">D3 Teknik Telekomunikasi</option>
                </select>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Tanggal & Waktu
                    </label>

                    <input type="datetime-local" name="event_date" class="form-control"
                        min="{{ now()->format('Y-m-d\TH:i') }}" required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Lokasi
                    </label>

                    <input type="text" name="location" class="form-control" placeholder="Lokasi event" required>

                </div>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Harga
                    </label>

                    <input type="text" name="price" class="form-control" placeholder="GRATIS / Rp 5.000" required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Target Peserta
                    </label>

                    <input type="text" name="target_participants" class="form-control"
                        placeholder="Mahasiswa, Umum, dll" required>

                </div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Link Pendaftaran
                </label>

                <input type="url" name="registration_link" class="form-control" placeholder="https://..." required>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Nama Penyelenggara
                    </label>

                    <input type="text" name="organizer_name" class="form-control" placeholder="Nama UKM / organisasi"
                        required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Kontak
                    </label>

                    <input type="text" name="contact_person" class="form-control" placeholder="WA / Email" required>

                </div>

            </div>

            <div class="form-group" style="margin-top: 24px;">

                <label class="form-label">
                    Poster Event
                </label>

                <div class="upload-area" onclick="document.getElementById('poster').click()"
                    style="padding: 24px; cursor: pointer;">

                    <div
                        style="display: flex;
                               align-items: center;
                               justify-content: center;
                               gap: 16px;">

                        <div
                            style="width: 40px;
                                   height: 40px;
                                   display: flex;
                                   align-items: center;
                                   justify-content: center;
                                   background: #F3F4F6;
                                   border-radius: 8px;">

                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="var(--text-muted)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">

                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>

                                <polyline points="17 8 12 3 7 8"></polyline>

                                <line x1="12" y1="3" x2="12" y2="15"></line>

                            </svg>

                        </div>

                        <div style="text-align: left;">

                            <p id="fileName"
                                style="font-weight: 500;
                                       color: var(--text-dark);
                                       margin-bottom: 2px;">

                                Klik untuk upload poster

                            </p>

                            <p
                                style="font-size: 0.85rem;
                                       color: var(--text-muted);
                                       margin: 0;">

                                PNG, JPG, JPEG, max 5MB

                            </p>

                        </div>

                    </div>

                    <input type="file" id="poster" name="poster" accept="image/png, image/jpeg, image/jpg"
                        style="display: none;" onchange="showFileName(this)">

                </div>

            </div>

            <div class="toggle-container"
                style="padding: 20px 24px;
                       border-radius: 8px;
                       margin-bottom: 32px;
                       justify-content: flex-start;
                       gap: 16px;
                       border: 1px solid var(--border-color);
                       background-color: var(--white);">

                <div class="toggle-switch" id="takToggle" style="margin-right: 8px; cursor: pointer;">

                    <div class="toggle-slider"></div>

                </div>

                <div>

                    <div
                        style="font-weight: 600;
                               font-size: 0.95rem;
                               margin-bottom: 2px;
                               color: var(--text-dark);">

                        Event ini termasuk TAK

                    </div>

                    <div style="font-size: 0.85rem;
                               color: var(--text-muted);">

                        Transkrip Aktivitas Kemahasiswaan

                    </div>

                </div>

                <input type="checkbox" id="includeTak" name="is_tak" style="display:none;">

            </div>

            <button type="submit" class="btn btn-primary" style="padding: 14px; font-weight: 600;">

                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                    <line x1="22" y1="2" x2="11" y2="13"></line>

                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>

                </svg>

                Submit Event

            </button>

        </form>

    </main>

    <!-- FOOTER -->
    @include('components.footer')

    <script>
        function showFileName(input) {

            if (input.files.length > 0) {

                document.getElementById('fileName').innerText =
                    input.files[0].name;

            }

        }

        const takToggle = document.getElementById('takToggle');
        const includeTak = document.getElementById('includeTak');

        takToggle.addEventListener('click', () => {

            includeTak.checked = !includeTak.checked;

            if (includeTak.checked) {

                takToggle.classList.add('active');

            } else {

                takToggle.classList.remove('active');

            }

        });
    </script>

</body>

</html>
