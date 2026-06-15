@extends('admin.layouts.app')

@section('title', isset($event) ? 'Edit Event - TelU Events' : 'Tambah Event - TelU Events')

@push('styles')
<style>
    /* Scanning laser effect for poster AI upload */
    .upload-area {
        position: relative;
        overflow: hidden;
    }

    .upload-area.scanning {
        pointer-events: none;
        opacity: 0.85;
        border-color: var(--telu-red) !important;
    }

    .scanner-line {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, transparent, var(--telu-red), transparent);
        box-shadow: 0 0 10px var(--telu-red);
        z-index: 5;
    }

    .upload-area.scanning .scanner-line {
        display: block;
        animation: scanLine 2s linear infinite;
    }

    @keyframes scanLine {
        0% { top: 0%; }
        50% { top: 100%; }
        100% { top: 0%; }
    }

    /* Autofill glow animation */
    .autofill-glow {
        animation: glowGreen 1.8s ease-out;
    }

    @keyframes glowGreen {
        0% {
            border-color: #10B981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
            background-color: #ECFDF5;
        }
        100% {
            border-color: var(--slate-200);
            box-shadow: none;
            background-color: var(--slate-50);
        }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
@php
    $oprecDivisions = '';
    $oprecRequirements = '';
    $oprecTimeline = '';
    
    if (isset($event) && $event->category === 'kepanitiaan' && $event->description) {
        $desc = $event->description;
        
        // Parse Divisi yang Dibuka
        if (preg_match('/### Divisi yang Dibuka:\s*(.*?)(?=\s*###|$)/s', $desc, $matches)) {
            $oprecDivisions = trim($matches[1]);
        }
        
        // Parse Kualifikasi & Persyaratan
        if (preg_match('/### Kualifikasi & Persyaratan:\s*(.*?)(?=\s*###|$)/s', $desc, $matches)) {
            $oprecRequirements = trim($matches[1]);
        }
        
        // Parse Timeline Seleksi
        if (preg_match('/### Timeline Seleksi:\s*(.*?)(?=\s*###|$)/s', $desc, $matches)) {
            $oprecTimeline = trim($matches[1]);
        }
    }
@endphp

<div class="page-header" style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
    <div class="page-title" style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('admin.events') }}" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: var(--slate-100); color: var(--slate-600); text-decoration: none; font-size: 0.95rem; transition: background 0.2s;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="margin: 0; font-size: 1.3rem; color: var(--slate-900);">{{ isset($event) ? 'Edit Event' : 'Tambah Event Baru' }}</h2>
            <p style="margin: 4px 0 0 0; color: var(--slate-500); font-size: 0.82rem;">
                {{ isset($event) ? 'Perbarui informasi event kemahasiswaan.' : 'Tambahkan event baru langsung tanpa melalui proses verifikasi.' }}
            </p>
        </div>
    </div>
</div>

<div class="content-box" style="max-width: 800px; margin: 0 auto; padding: 24px;">
    @if(session('error'))
        <div style="background: #FEE2E2; color: #B91C1C; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.82rem; font-weight: 500; border: 1px solid #FCA5A5;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> {{ session('error') }}
        </div>
    @endif

    <form id="adminEventForm" action="{{ isset($event) ? route('admin.event.update', $event->id) : route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($event))
            @method('PUT')
        @endif

        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Poster Event & AI Autofill Dropzone (Option B style) -->
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 4px;">Poster Event & AI Autofill</label>
                <p style="color: var(--slate-500); font-size: 0.78rem; margin: 0 0 10px 0; line-height: 1.4;">
                    Pilih poster event. AI akan memindai data dan mengisi formulir di bawah secara otomatis!
                </p>
                <div class="upload-area" id="posterUploadArea" data-input-id="poster" 
                     style="position: relative; overflow: hidden; border: 2px dashed #EF4444; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.2s; background: #FEF2F2;"
                     onclick="document.getElementById('poster').click()">
                    
                    <div class="scanner-line"></div>
                    
                    <div style="display: flex; align-items: center; justify-content: center; gap: 12px; position: relative; z-index: 2;">
                        <div style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: white; border: 1px dashed #FCA5A5; border-radius: 6px;">
                            <i class="fa-solid fa-cloud-arrow-up" style="font-size: 1.25rem; color: #DC2626;"></i>
                        </div>
                        <div style="text-align: left;">
                            <p id="fileName" style="margin: 0; font-size: 0.8rem; font-weight: 600; color: #DC2626;">
                                @if(isset($event) && $event->poster)
                                    Poster Tersimpan (Klik untuk ganti)
                                @else
                                    Klik untuk upload poster
                                @endif
                            </p>
                            <p style="margin: 2px 0 0 0; font-size: 0.7rem; color: #991B1B;">
                                Format: PNG, JPG, JPEG. Max: 5MB
                            </p>
                        </div>
                    </div>
                </div>
                <input type="file" id="poster" name="poster" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="showFileName(this)">
                
                <button type="button" id="btnScanPoster" class="admin-btn-action" style="margin-top: 10px; background: #DC2626; color: white; width: 100%; font-weight: 600; font-size: 0.8rem; display: none; align-items: center; justify-content: center; gap: 8px; border-radius: 8px; padding: 10px 14px;">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>✨ Pindai & Isi Otomatis dengan AI</span>
                </button>
            </div>

            <!-- Judul Event -->
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Judul Event</label>
                <input type="text" name="title" value="{{ old('title', isset($event) ? $event->title : '') }}" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; transition: all 0.2s; background: var(--slate-50);" 
                       onfocus="this.style.borderColor='var(--slate-400)'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(148, 163, 184, 0.1)';" 
                       onblur="this.style.borderColor='var(--slate-200)'; this.style.background='var(--slate-50)'; this.style.boxShadow='none';">
            </div>

            <!-- Deskripsi -->
            <div id="generalDescriptionGroup">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Deskripsi</label>
                <textarea id="description" name="description" rows="5"
                          style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; transition: all 0.2s; background: var(--slate-50); resize: vertical;"
                          onfocus="this.style.borderColor='var(--slate-400)'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(148, 163, 184, 0.1)';" 
                          onblur="this.style.borderColor='var(--slate-200)'; this.style.background='var(--slate-50)'; this.style.boxShadow='none';">{{ old('description', isset($event) ? $event->description : '') }}</textarea>
            </div>

            <!-- DYNAMIC OPREC FIELDS (Hanya muncul untuk kategori Kepanitiaan) -->
            <div id="oprecFieldsContainer" style="display: none; background: var(--slate-50); padding: 16px; border-radius: 8px; border: 1px solid var(--slate-200);">
                <div style="font-weight: 700; font-size: 0.85rem; color: var(--slate-800); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-users-gear" style="color: var(--telu-red);"></i>
                    Detail Rekrutmen Kepanitiaan (OPREC)
                </div>

                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 0.78rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Divisi yang Dibuka</label>
                    <input type="text" id="oprecDivisions" value="{{ old('oprec_divisions', $oprecDivisions) }}" class="form-control" placeholder="Contoh: Acara, Humas, PDD, Perkap, Keamanan"
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: white;">
                </div>

                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 0.78rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Kualifikasi / Persyaratan</label>
                    <textarea id="oprecRequirements" class="form-control" placeholder="Contoh: &#10;- Mahasiswa Aktif Informatika angkatan 2024-2025&#10;- Berkomitmen dan bertanggung jawab" 
                              style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: white; min-height: 80px; resize: vertical;">{{ old('oprec_requirements', $oprecRequirements) }}</textarea>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 0.78rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Timeline Seleksi & Jadwal (Opsional)</label>
                    <textarea id="oprecTimeline" class="form-control" placeholder="Contoh: &#10;- 6 - 18 Juni: Pendaftaran&#10;- 19 Juni: Seleksi Berkas&#10;- 21 - 23 Juni: Wawancara&#10;- 24 Juni: Pengumuman" 
                              style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: white; min-height: 80px; resize: vertical;">{{ old('oprec_timeline', $oprecTimeline) }}</textarea>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Kategori -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Kategori</label>
                    <select name="category" id="categorySelect" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                        <option value="" disabled {{ !isset($event) ? 'selected' : '' }} hidden>Pilih Kategori</option>
                        <option value="seminar" {{ old('category', isset($event) ? $event->category : '') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="workshop" {{ old('category', isset($event) ? $event->category : '') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="kompetisi" {{ old('category', isset($event) ? $event->category : '') == 'kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                        <option value="kepanitiaan" {{ old('category', isset($event) ? $event->category : '') == 'kepanitiaan' ? 'selected' : '' }}>Kepanitiaan</option>
                        <option value="lainnya" {{ old('category', isset($event) ? $event->category : '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Tipe Event -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Tipe Event</label>
                    <select name="event_type" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                        <option value="" disabled {{ !isset($event) ? 'selected' : '' }} hidden>Pilih Tipe</option>
                        <option value="online" {{ old('event_type', isset($event) ? $event->event_type : '') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('event_type', isset($event) ? $event->event_type : '') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="hybrid" {{ old('event_type', isset($event) ? $event->event_type : '') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            <!-- Khusus Prodi (Opsional) -->
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Khusus Prodi (Opsional)</label>
                <select name="prodi" style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                    <option value="">Tidak ada (Untuk Umum/Semua Prodi)</option>
                    <option value="S1 Teknik Telekomunikasi" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Telekomunikasi' ? 'selected' : '' }}>S1 Teknik Telekomunikasi</option>
                    <option value="S1 Teknik Elektro" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Elektro' ? 'selected' : '' }}>S1 Teknik Elektro</option>
                    <option value="S1 Teknik Biomedis" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Biomedis' ? 'selected' : '' }}>S1 Teknik Biomedis</option>
                    <option value="S1 Teknik Informatika" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Informatika' ? 'selected' : '' }}>S1 Teknik Informatika</option>
                    <option value="S1 Rekayasa Perangkat Lunak (Software Engineering)" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Rekayasa Perangkat Lunak (Software Engineering)' ? 'selected' : '' }}>S1 Rekayasa Perangkat Lunak</option>
                    <option value="S1 Sains Data" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Sains Data' ? 'selected' : '' }}>S1 Sains Data</option>
                    <option value="S1 Teknik Industri" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Industri' ? 'selected' : '' }}>S1 Teknik Industri</option>
                    <option value="S1 Sistem Informasi" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                    <option value="S1 Teknik Logistik" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknik Logistik' ? 'selected' : '' }}>S1 Teknik Logistik</option>
                    <option value="S1 Teknologi Pangan" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Teknologi Pangan' ? 'selected' : '' }}>S1 Teknologi Pangan</option>
                    <option value="S1 Desain Komunikasi Visual" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Desain Komunikasi Visual' ? 'selected' : '' }}>S1 Desain Komunikasi Visual</option>
                    <option value="S1 Desain Produk" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Desain Produk' ? 'selected' : '' }}>S1 Desain Produk</option>
                    <option value="S1 Bisnis Digital" {{ old('prodi', isset($event) ? $event->prodi : '') == 'S1 Bisnis Digital' ? 'selected' : '' }}>S1 Bisnis Digital</option>
                    <option value="D3 Teknik Telekomunikasi" {{ old('prodi', isset($event) ? $event->prodi : '') == 'D3 Teknik Telekomunikasi' ? 'selected' : '' }}>D3 Teknik Telekomunikasi</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Tanggal & Waktu -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Tanggal & Waktu</label>
                    <input type="datetime-local" name="event_date" 
                           value="{{ old('event_date', isset($event) ? date('Y-m-d\TH:i', strtotime($event->event_date)) : '') }}" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>

                <!-- Lokasi -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', isset($event) ? $event->location : '') }}" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Harga -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Harga</label>
                    <input type="text" name="price" value="{{ old('price', isset($event) ? $event->price : '') }}" placeholder="GRATIS / Rp 5.000" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>

                <!-- Target Peserta -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Target Peserta</label>
                    <input type="text" name="target_participants" value="{{ old('target_participants', isset($event) ? $event->target_participants : '') }}" placeholder="Mahasiswa, Umum, dll" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>
            </div>

            <!-- Link Pendaftaran -->
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Link Pendaftaran <span style="font-weight: normal; color: var(--slate-400); font-size: 0.75rem;">(Opsional - Kosongkan jika langsung datang/walk-in)</span></label>
                <input type="url" name="registration_link" value="{{ old('registration_link', isset($event) ? $event->registration_link : '') }}" placeholder="https://..."
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Nama Penyelenggara -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Nama Penyelenggara</label>
                    <input type="text" name="organizer_name" value="{{ old('organizer_name', isset($event) ? $event->organizer_name : '') }}" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>

                <!-- Kontak -->
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--slate-700); margin-bottom: 6px;">Kontak Penyelenggara</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', isset($event) ? $event->contact_person : '') }}" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid var(--slate-200); border-radius: 8px; font-size: 0.85rem; color: var(--slate-800); outline: none; background: var(--slate-50); transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--slate-400)'" onblur="this.style.borderColor='var(--slate-200)'">
                </div>
            </div>

            <!-- Switch TAK -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 1px solid var(--slate-200); border-radius: 8px; background: var(--slate-50);">
                <div>
                    <div style="font-weight: 600; color: var(--slate-800); font-size: 0.85rem;">Event Memberikan Nilai TAK</div>
                    <div style="font-size: 0.75rem; color: var(--slate-500);">Aktifkan jika event ini memberikan Transkrip Aktivitas Kemahasiswaan</div>
                </div>
                <label style="position: relative; display: inline-block; width: 40px; height: 22px;">
                    <input type="checkbox" id="includeTak" name="is_tak" style="opacity: 0; width: 0; height: 0;" {{ old('is_tak', isset($event) && $event->is_tak) ? 'checked' : '' }}>
                    <span id="takSlider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ old('is_tak', isset($event) && $event->is_tak) ? 'var(--telu-red)' : 'var(--slate-300)' }}; transition: .3s; border-radius: 34px;">
                        <span id="takCircle" style="position: absolute; content: ''; height: 16px; width: 16px; left: {{ old('is_tak', isset($event) && $event->is_tak) ? '21px' : '3px' }}; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%;"></span>
                    </span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <a href="{{ route('admin.events') }}" class="admin-btn-action admin-btn-detail" style="padding: 10px 18px;">Batal</a>
                <button type="submit" class="admin-btn-action" style="padding: 10px 18px; color: white; background: var(--telu-red); border: none;">
                    <i class="fa-solid fa-save"></i> {{ isset($event) ? 'Simpan Perubahan' : 'Tambahkan Event' }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function showFileName(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById('fileName').innerText = input.files[0].name;
            document.getElementById('fileName').style.color = '#10B981';
            document.getElementById('btnScanPoster').style.display = 'flex';
        } else {
            document.getElementById('btnScanPoster').style.display = 'none';
        }
    }

    const takCheckbox = document.getElementById('includeTak');
    const takSlider = document.getElementById('takSlider');
    const takCircle = document.getElementById('takCircle');

    takCheckbox.addEventListener('change', function() {
        if (this.checked) {
            takSlider.style.backgroundColor = 'var(--telu-red)'; // Red color when active
            takCircle.style.left = '21px';
        } else {
            takSlider.style.backgroundColor = 'var(--slate-300)'; // Gray color when inactive
            takCircle.style.left = '3px';
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const categorySelect = document.getElementById('categorySelect');
        const oprecFieldsContainer = document.getElementById('oprecFieldsContainer');
        const generalDescriptionGroup = document.getElementById('generalDescriptionGroup');

        const toggleCategoryFields = () => {
            const priceInput = document.querySelector('[name="price"]');
            if (categorySelect && categorySelect.value === 'kepanitiaan') {
                if (oprecFieldsContainer) oprecFieldsContainer.style.display = 'block';
                if (generalDescriptionGroup) generalDescriptionGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = 'GRATIS';
                    priceInput.readOnly = true;
                    priceInput.style.backgroundColor = '#F3F4F6';
                    priceInput.style.color = '#6B7280';
                }
            } else {
                if (oprecFieldsContainer) oprecFieldsContainer.style.display = 'none';
                if (generalDescriptionGroup) generalDescriptionGroup.style.display = 'block';
                if (priceInput && priceInput.readOnly) {
                    priceInput.value = '';
                    priceInput.readOnly = false;
                    priceInput.style.backgroundColor = '';
                    priceInput.style.color = '';
                }
            }
        };

        if (categorySelect) {
            categorySelect.addEventListener('change', toggleCategoryFields);
            toggleCategoryFields(); // Run on initial load
        }

        // AI Scan Poster Logic
        const btnScanPoster = document.getElementById('btnScanPoster');
        const posterInput = document.getElementById('poster');
        const posterUploadArea = document.getElementById('posterUploadArea');

        if (btnScanPoster && posterInput) {
            btnScanPoster.addEventListener('click', async () => {
                if (!posterInput.files || posterInput.files.length === 0) {
                    alert('Silakan pilih poster terlebih dahulu.');
                    return;
                }

                const file = posterInput.files[0];
                
                // Client-side validations
                if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    alert('Ukuran poster maksimal adalah 5MB.');
                    return;
                }
                
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file harus berupa PNG, JPG, atau JPEG.');
                    return;
                }

                const formData = new FormData();
                formData.append('poster', file);

                const tokenInput = document.querySelector('input[name="_token"]');
                const token = tokenInput ? tokenInput.value : '';

                // Show scanning animation
                if (posterUploadArea) {
                    posterUploadArea.classList.add('scanning');
                }
                btnScanPoster.disabled = true;
                const originalBtnText = btnScanPoster.innerHTML;
                btnScanPoster.innerHTML = `
                    <i class="fa-solid fa-spinner" style="animation: spin 1s linear infinite;"></i>
                    <span>Memindai poster dengan AI...</span>
                `;

                try {
                    const userApiKey = localStorage.getItem('user_gemini_api_key') || '';
                    const headers = {
                        'X-CSRF-TOKEN': token
                    };
                    if (userApiKey) {
                        headers['X-Gemini-Key'] = userApiKey;
                    }

                    const response = await fetch('/api/extract-poster', {
                        method: 'POST',
                        headers: headers,
                        body: formData
                    });

                    const result = await response.json();

                    if (!response.ok || !result.success) {
                        throw new Error(result.error || 'Gagal memindai poster.');
                    }

                    const data = result.data;

                    // 1. Set category first
                    if (categorySelect && data.category !== undefined) {
                        categorySelect.value = data.category;
                        toggleCategoryFields();
                    }

                    // 2. Populate regular fields
                    const fields = [
                        'title', 'description', 'event_type', 'prodi',
                        'event_date', 'location', 'price', 'target_participants',
                        'registration_link', 'organizer_name', 'contact_person'
                    ];

                    fields.forEach(fieldName => {
                        const input = document.querySelector(`[name="${fieldName}"]`);
                        if (input && data[fieldName] !== undefined) {
                            input.value = data[fieldName];
                            
                            // Apply glow animation
                            input.classList.remove('autofill-glow');
                            void input.offsetWidth; // Trigger reflow to restart animation
                            input.classList.add('autofill-glow');
                        }
                    });

                    // 3. Populate OPREC fields if category is Kepanitiaan
                    if (data.category === 'kepanitiaan') {
                        const oprecFields = {
                            'oprec_divisions': '#oprecDivisions',
                            'oprec_requirements': '#oprecRequirements',
                            'oprec_timeline': '#oprecTimeline'
                        };

                        Object.entries(oprecFields).forEach(([key, selector]) => {
                            const input = document.querySelector(selector);
                            if (input && data[key] !== undefined) {
                                input.value = data[key];
                                
                                // Apply glow animation
                                input.classList.remove('autofill-glow');
                                void input.offsetWidth;
                                input.classList.add('autofill-glow');
                            }
                        });
                    }

                    // Handle TAK Toggle
                    const includeTakCheckbox = document.getElementById('includeTak');
                    if (includeTakCheckbox && data.is_tak !== undefined) {
                        includeTakCheckbox.checked = data.is_tak;
                        const event = new Event('change');
                        includeTakCheckbox.dispatchEvent(event);
                    }

                    alert('✨ Berhasil memindai poster! Formulir telah diisi otomatis secara pintar.');

                } catch (error) {
                    console.error(error);
                    alert('Gagal memindai poster: ' + error.message);
                } finally {
                    if (posterUploadArea) {
                        posterUploadArea.classList.remove('scanning');
                    }
                    btnScanPoster.disabled = false;
                    btnScanPoster.innerHTML = originalBtnText;
                }
            });
        }

        // Form compilation on submit
        const form = document.getElementById('adminEventForm');
        if (form) {
            form.addEventListener('submit', (e) => {
                const descTextarea = document.getElementById('description');
                
                if (categorySelect && categorySelect.value === 'kepanitiaan') {
                    const divisions = document.getElementById('oprecDivisions').value.trim();
                    const requirements = document.getElementById('oprecRequirements').value.trim();
                    const timeline = document.getElementById('oprecTimeline').value.trim();

                    let compiled = "";
                    if (divisions) {
                        compiled += `### Divisi yang Dibuka:\n${divisions}\n\n`;
                    }
                    if (requirements) {
                        compiled += `### Kualifikasi & Persyaratan:\n${requirements}\n\n`;
                    }
                    if (timeline) {
                        compiled += `### Timeline Seleksi:\n${timeline}\n\n`;
                    }

                    const oprecDesc = compiled.trim();
                    if (!oprecDesc) {
                        e.preventDefault();
                        alert('Harap isi detail rekrutmen kepanitiaan terlebih dahulu.');
                        return;
                    }
                    if (descTextarea) {
                        descTextarea.value = oprecDesc;
                    }
                } else {
                    if (descTextarea && !descTextarea.value.trim()) {
                        e.preventDefault();
                        alert('Deskripsi event tidak boleh kosong.');
                        return;
                    }
                }
            });
        }
    });
</script>
@endsection
