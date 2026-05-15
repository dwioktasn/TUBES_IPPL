@extends('admin.layouts.app')

@section('title', isset($event) ? 'Edit Event - TelU Events' : 'Tambah Event - TelU Events')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div class="page-title" style="display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('admin.events') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #F3F4F6; color: #4B5563; text-decoration: none; font-size: 1.2rem; transition: background 0.2s;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">{{ isset($event) ? 'Edit Event' : 'Tambah Event Baru' }}</h2>
            <p style="margin: 4px 0 0 0; color: #6B7280; font-size: 0.9rem;">
                {{ isset($event) ? 'Perbarui informasi event yang sudah ada.' : 'Tambahkan event baru langsung tanpa melalui proses verifikasi.' }}
            </p>
        </div>
    </div>
</div>

<div class="content-box" style="background: white; border-radius: 12px; border: 1px solid #E5E7EB; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 800px;">
    @if(session('error'))
        <div style="background: #FEE2E2; color: #991B1B; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 0.9rem;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ isset($event) ? route('admin.event.update', $event->id) : route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($event))
            @method('PUT')
        @endif

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Judul Event -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Judul Event</label>
                <input type="text" name="title" value="{{ old('title', isset($event) ? $event->title : '') }}" required
                       style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none; transition: border-color 0.2s;" 
                       onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#D1D5DB'">
            </div>

            <!-- Deskripsi -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="description" required rows="5"
                          style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none; transition: border-color 0.2s; resize: vertical;"
                          onfocus="this.style.borderColor='#3B82F6'" onblur="this.style.borderColor='#D1D5DB'">{{ old('description', isset($event) ? $event->description : '') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Kategori -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Kategori</label>
                    <select name="category" required style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none; background: white;">
                        <option value="" disabled {{ !isset($event) ? 'selected' : '' }} hidden>Pilih Kategori</option>
                        <option value="seminar" {{ old('category', isset($event) ? $event->category : '') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="workshop" {{ old('category', isset($event) ? $event->category : '') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="kompetisi" {{ old('category', isset($event) ? $event->category : '') == 'kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                        <option value="lainnya" {{ old('category', isset($event) ? $event->category : '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Tipe Event -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Tipe Event</label>
                    <select name="event_type" required style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none; background: white;">
                        <option value="" disabled {{ !isset($event) ? 'selected' : '' }} hidden>Pilih Tipe</option>
                        <option value="online" {{ old('event_type', isset($event) ? $event->event_type : '') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('event_type', isset($event) ? $event->event_type : '') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="hybrid" {{ old('event_type', isset($event) ? $event->event_type : '') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            <!-- Khusus Prodi (Opsional) -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Khusus Prodi (Opsional)</label>
                <select name="prodi" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none; background: white;">
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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Tanggal & Waktu -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Tanggal & Waktu</label>
                    <input type="datetime-local" name="event_date" 
                           value="{{ old('event_date', isset($event) ? date('Y-m-d\TH:i', strtotime($event->event_date)) : '') }}" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>

                <!-- Lokasi -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', isset($event) ? $event->location : '') }}" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Harga -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Harga</label>
                    <input type="text" name="price" value="{{ old('price', isset($event) ? $event->price : '') }}" placeholder="GRATIS / Rp 5.000" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>

                <!-- Target Peserta -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Target Peserta</label>
                    <input type="text" name="target_participants" value="{{ old('target_participants', isset($event) ? $event->target_participants : '') }}" placeholder="Mahasiswa, Umum, dll" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>
            </div>

            <!-- Link Pendaftaran -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Link Pendaftaran</label>
                <input type="url" name="registration_link" value="{{ old('registration_link', isset($event) ? $event->registration_link : '') }}" placeholder="https://..." required
                       style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Nama Penyelenggara -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Penyelenggara</label>
                    <input type="text" name="organizer_name" value="{{ old('organizer_name', isset($event) ? $event->organizer_name : '') }}" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>

                <!-- Kontak -->
                <div>
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak Penyelenggara</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', isset($event) ? $event->contact_person : '') }}" required
                           style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; color: #111827; outline: none;">
                </div>
            </div>

            <!-- Poster Event -->
            <div>
                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Poster Event (Opsional)</label>
                <div style="border: 2px dashed #D1D5DB; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: border-color 0.2s; background: #F9FAFB;"
                     onclick="document.getElementById('poster').click()"
                     onmouseover="this.style.borderColor='#3B82F6'"
                     onmouseout="this.style.borderColor='#D1D5DB'">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size: 2rem; color: #9CA3AF; margin-bottom: 12px;"></i>
                    <p id="fileName" style="margin: 0 0 4px 0; font-weight: 500; color: #374151;">Klik untuk upload poster</p>
                    <p style="margin: 0; font-size: 0.8rem; color: #6B7280;">Format: PNG, JPG, JPEG. Max: 5MB</p>
                    @if(isset($event) && $event->poster)
                        <p style="margin: 8px 0 0 0; font-size: 0.85rem; color: #10B981;">(Poster saat ini sudah tersimpan, upload baru untuk mengganti)</p>
                    @endif
                    <input type="file" id="poster" name="poster" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="showFileName(this)">
                </div>
            </div>

            <!-- Switch TAK -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border: 1px solid #E5E7EB; border-radius: 8px; background: #F9FAFB;">
                <div>
                    <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">Event Memberikan Nilai TAK</div>
                    <div style="font-size: 0.85rem; color: #6B7280;">Aktifkan jika event ini memberikan Transkrip Aktivitas Kemahasiswaan</div>
                </div>
                <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                    <input type="checkbox" id="includeTak" name="is_tak" style="opacity: 0; width: 0; height: 0;" {{ old('is_tak', isset($event) && $event->is_tak) ? 'checked' : '' }}>
                    <span id="takSlider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ old('is_tak', isset($event) && $event->is_tak) ? '#EF4444' : '#D1D5DB' }}; transition: .4s; border-radius: 34px;">
                        <span id="takCircle" style="position: absolute; content: ''; height: 18px; width: 18px; left: {{ old('is_tak', isset($event) && $event->is_tak) ? '22px' : '3px' }}; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                    </span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 16px;">
                <a href="{{ route('admin.events') }}" style="padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; color: #374151; background: #F3F4F6; border: 1px solid #D1D5DB;">Batal</a>
                <button type="submit" style="padding: 12px 24px; border-radius: 8px; font-weight: 600; color: white; background: #DC2626; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;">
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
        }
    }

    const takCheckbox = document.getElementById('includeTak');
    const takSlider = document.getElementById('takSlider');
    const takCircle = document.getElementById('takCircle');

    takCheckbox.addEventListener('change', function() {
        if (this.checked) {
            takSlider.style.backgroundColor = '#EF4444'; // Red color when active
            takCircle.style.left = '22px';
        } else {
            takSlider.style.backgroundColor = '#D1D5DB'; // Gray color when inactive
            takCircle.style.left = '3px';
        }
    });
</script>
@endsection
