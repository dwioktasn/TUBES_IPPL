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
    <main class="container" style="max-width: 760px; padding-top: 40px; padding-bottom: 80px;">

        <div style="margin-bottom: 28px;">

            <h1 style="font-size: 1.85rem; font-weight: 800; margin-bottom: 8px; color: var(--text-dark);">
                Submit Event Baru
            </h1>

            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">
                Isi formulir di bawah ini untuk mengajukan event kamu.
                Event akan dipublikasikan setelah melalui proses verifikasi oleh admin.
            </p>

        </div>

        <!-- FORM CARD -->
        @if (session('error'))
            <div style="background: #FEE2E2; color: #991B1B; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #FCA5A5;">
                {{ session('error') }}
            </div>
        @endif

        <div class="card" style="box-shadow: var(--shadow-md); padding: 40px; border-radius: 12px; background: var(--white); border: 1px solid var(--border-color);">
            <form id="submitEventForm" action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- SECTION 1: DETAIL EVENT -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Detail Informasi Event
                </div>

                <!-- POSTER AT THE START OF FORM WITH AI AUTOFILL -->
                <div class="form-group" style="margin-top: 16px; margin-bottom: 24px;">
                    <label class="form-label" style="margin-bottom: 4px;">Poster Event & AI Autofill</label>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 12px; line-height: 1.4;">
                        Pilih poster event kamu. AI akan secara pintar memindai data dan mengisi formulir di bawah ini secara otomatis!
                    </p>
                    
                    <div class="upload-area" id="posterUploadArea" data-input-id="poster" style="padding: 24px; cursor: pointer; border: 2px dashed #EF4444; background-color: #FEF2F2; transition: all 0.2s ease;">
                        <div class="scanner-line"></div>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 16px; position: relative; z-index: 2;">
                            <div style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px dashed #FCA5A5; border-radius: 8px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <p id="fileName" style="font-weight: 600; color: #DC2626; margin-bottom: 2px;">
                                    Klik untuk upload poster
                                </p>
                                <p style="font-size: 0.85rem; color: #991B1B; margin: 0;">
                                    Format PNG, JPG, JPEG (Maks. 5MB)
                                </p>
                            </div>
                        </div>
                        <input type="file" id="poster" name="poster" accept="image/png, image/jpeg, image/jpg" style="display: none;" required>
                    </div>
                    
                    <button type="button" id="btnScanPoster" class="btn" style="margin-top: 12px; background: #DC2626; color: white; width: 100%; font-weight: 600; font-size: 0.9rem; display: none; align-items: center; justify-content: center; gap: 8px; border-radius: 8px; box-shadow: var(--shadow-sm); padding: 12px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>✨ Pindai & Isi Otomatis dengan AI</span>
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label">Judul Event</label>
                    <input type="text" name="title" class="form-control" placeholder="Tuliskan nama event secara jelas..." required>
                </div>

                <div class="form-group" id="generalDescriptionGroup">
                    <label class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Jelaskan detail agenda, pembicara, syarat, dan info penting lainnya..."></textarea>
                </div>

                <!-- DYNAMIC OPREC FIELDS (Hanya muncul untuk kategori Kepanitiaan) -->
                <div id="oprecFieldsContainer" style="display: none; background: #F9FAFB; padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                    <div style="font-weight: 700; font-size: 0.95rem; color: var(--text-dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary-red)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Detail Rekrutmen Kepanitiaan (OPREC)
                    </div>

                    <div class="form-group">
                        <label class="form-label">Divisi yang Dibuka</label>
                        <input type="text" id="oprecDivisions" class="form-control" placeholder="Contoh: Acara, Humas, PDD, Perkap, Keamanan">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kualifikasi / Persyaratan</label>
                        <textarea id="oprecRequirements" class="form-control" placeholder="Contoh: &#10;- Mahasiswa Aktif Informatika angkatan 2024-2025&#10;- Berkomitmen dan bertanggung jawab" style="min-height: 80px;"></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Timeline Seleksi & Jadwal (Opsional)</label>
                        <textarea id="oprecTimeline" class="form-control" placeholder="Contoh: &#10;- 6 - 18 Juni: Pendaftaran&#10;- 19 Juni: Seleksi Berkas&#10;- 21 - 23 Juni: Wawancara&#10;- 24 Juni: Pengumuman" style="min-height: 100px;"></textarea>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="" disabled selected hidden>Pilih Kategori</option>
                            <option value="seminar">Seminar</option>
                            <option value="workshop">Workshop</option>
                            <option value="kompetisi">Kompetisi</option>
                            <option value="kepanitiaan">Kepanitiaan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipe Event</label>
                        <select name="event_type" class="form-control" required>
                            <option value="" disabled selected hidden>Pilih Tipe</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Khusus Prodi (Opsional)</label>
                    <select name="prodi" class="form-control">
                        <option value="">Tidak ada (Terbuka untuk Umum / Semua Prodi)</option>
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

                <!-- SECTION 2: WAKTU & TEMPAT -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Waktu & Tempat
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal & Waktu</label>
                        <input type="datetime-local" name="event_date" class="form-control" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" class="form-control" placeholder="Gedung / Link Zoom / hybrid" required>
                    </div>
                </div>

                <!-- SECTION 3: PENDAFTARAN & SASARAN -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    Pendaftaran & Sasaran
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga Tiket</label>
                        <input type="text" name="price" class="form-control" placeholder="Contoh: GRATIS / Rp 15.000" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Peserta</label>
                        <input type="text" name="target_participants" class="form-control" placeholder="Contoh: Mahasiswa Tel-U, Umum" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Link Pendaftaran <span style="font-weight: normal; color: var(--text-muted); font-size: 0.85rem;">(Opsional - Kosongkan jika langsung datang/walk-in)</span></label>
                    <input type="url" name="registration_link" class="form-control" placeholder="Contoh: https://linktr.ee/eventmu">
                </div>

                <!-- SECTION 4: MEDIA & PENYELENGGARA -->
                <div class="form-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Penyelenggara & Media
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Penyelenggara</label>
                        <input type="text" name="organizer_name" class="form-control" placeholder="Contoh: HMTI Tel-U Purwokerto" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kontak Hubung</label>
                        <input type="text" name="contact_person" class="form-control" placeholder="Contoh: Kak Rani (08123456789)" required>
                    </div>
                </div>

                <div class="toggle-container" style="padding: 20px 24px; border-radius: 8px; margin-bottom: 32px; justify-content: flex-start; gap: 16px; border: 1px solid var(--border-color); background-color: var(--white);">
                    <div class="toggle-switch" id="takToggle" style="margin-right: 8px; cursor: pointer;">
                        <div class="toggle-slider"></div>
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 2px; color: var(--text-dark);">
                            Event ini termasuk TAK
                        </div>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">
                            Tri Dharma & Transkrip Aktivitas Kemahasiswaan
                        </div>
                    </div>
                    <input type="checkbox" id="includeTak" name="is_tak" style="display:none;">
                </div>

                <button type="submit" id="btnSubmitEvent" class="btn btn-primary" style="padding: 14px; font-weight: 600; width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Ajukan Event Baru
                </button>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    @include('components.footer')



</body>

</html>
