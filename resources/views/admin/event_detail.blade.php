@extends('admin.layouts.app')

@section('title', 'Detail Event - TelU Events')

@section('content')
<div class="page-header" style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
    <div class="page-title" style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('admin.events') }}" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: var(--slate-100); color: var(--slate-600); text-decoration: none; font-size: 0.95rem; transition: background 0.2s;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="margin: 0; font-size: 1.3rem; color: var(--slate-900);">Detail Event</h2>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">
    
    <!-- LEFT COLUMN: POSTER & ACTIONS -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Poster Box -->
        <div class="content-box" style="padding: 0; overflow: hidden; text-align: center; border-radius: 12px;">
            <div style="position: relative; width: 100%; aspect-ratio: 3/4; background: var(--slate-100);">
                @if($event->is_tak)
                    <span style="position: absolute; top: 12px; left: 12px; padding: 4px 10px; font-size: 0.65rem; font-weight: 700; background: var(--telu-red); color: white; border-radius: 999px; letter-spacing: 0.05em; box-shadow: 0 2px 4px rgba(0,0,0,0.15); z-index: 10;">TAK</span>
                @endif
                
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--slate-400);">
                        <i class="fa-regular fa-image" style="font-size: 3rem; margin-bottom: 12px;"></i>
                        <span style="font-size: 0.8rem; font-weight: 500;">No Poster</span>
                    </div>
                @endif
            </div>
            
            <!-- Status Ribbon -->
            <div style="padding: 10px 16px; font-size: 0.8rem; font-weight: 600; text-align: center; border-top: 1px solid var(--slate-200); background: var(--slate-50);">
                @if($event->status == 'pending')
                    <span style="color: #D97706;"><i class="fa-regular fa-clock"></i> Pending Verification</span>
                @elseif($event->status == 'approved')
                    <span style="color: #10B981;"><i class="fa-regular fa-circle-check"></i> Verified / Published</span>
                @else
                    <span style="color: #EF4444;"><i class="fa-regular fa-circle-xmark"></i> Rejected</span>
                @endif
            </div>
        </div>

        <!-- Action Card -->
        <div class="content-box" style="display: flex; flex-direction: column; gap: 10px; padding: 16px;">
            <h4 style="margin: 0 0 4px 0; font-size: 0.8rem; font-weight: 700; color: var(--slate-500); text-transform: uppercase; letter-spacing: 0.05em;">Aksi Konsol</h4>
            
            <a href="{{ route('admin.event.edit', $event->id) }}" class="admin-btn-action admin-btn-detail" style="justify-content: center; padding: 9px;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Informasi
            </a>

            @if($event->status != 'approved')
            <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="admin-btn-action admin-btn-approve" style="width: 100%; justify-content: center; padding: 9px;">
                    <i class="fa-solid fa-check"></i> Verifikasi Event
                </button>
            </form>
            @endif

            @if($event->status != 'rejected')
            <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="admin-btn-action admin-btn-reject" style="width: 100%; justify-content: center; padding: 9px;">
                    <i class="fa-solid fa-xmark"></i> Tolak Event
                </button>
            </form>
            @endif

            <div style="margin: 6px 0; border-top: 1px dashed var(--slate-200);"></div>

            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn-action admin-btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?');" style="width: 100%; justify-content: center; padding: 9px;">
                    <i class="fa-regular fa-trash-can"></i> Hapus Permanen
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT COLUMN: DETAILED INFO -->
    <div class="content-box" style="padding: 24px;">
        <h1 style="font-size: 1.35rem; font-weight: 800; color: var(--slate-900); margin: 0 0 16px 0; line-height: 1.3;">{{ $event->title }}</h1>

        <!-- Info Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; background: var(--slate-50); padding: 16px; border-radius: 8px; border: 1px solid var(--slate-200);">
            <div style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 30px; height: 30px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--telu-red);">
                    <i class="fa-regular fa-calendar-days" style="font-size: 0.85rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: var(--slate-500); font-weight: 600; text-transform: uppercase;">Tanggal & Waktu</div>
                    <div style="font-weight: 600; color: var(--slate-800); font-size: 0.85rem; margin-top: 2px;">{{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
                    <div style="font-size: 0.78rem; color: var(--slate-600); margin-top: 1px;">{{ \Carbon\Carbon::parse($event->event_date)->format('H.i') }} WIB</div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 30px; height: 30px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--telu-red);">
                    <i class="fa-solid fa-location-dot" style="font-size: 0.85rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: var(--slate-500); font-weight: 600; text-transform: uppercase;">Lokasi</div>
                    <div style="font-weight: 600; color: var(--slate-800); font-size: 0.85rem; margin-top: 2px;">{{ $event->location }}</div>
                    <div style="font-size: 0.78rem; color: var(--slate-600); margin-top: 1px;">{{ ucfirst($event->event_type) }}</div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 30px; height: 30px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--telu-red);">
                    <i class="fa-solid fa-tags" style="font-size: 0.85rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: var(--slate-500); font-weight: 600; text-transform: uppercase;">Kategori</div>
                    <div style="font-weight: 600; color: var(--slate-800); font-size: 0.85rem; margin-top: 2px;">{{ ucfirst($event->category) }}</div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: flex-start;">
                <div style="width: 30px; height: 30px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--telu-red);">
                    <i class="fa-solid fa-users" style="font-size: 0.85rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: var(--slate-500); font-weight: 600; text-transform: uppercase;">Target Peserta</div>
                    <div style="font-weight: 600; color: var(--slate-800); font-size: 0.85rem; margin-top: 2px;">{{ $event->target_participants }}</div>
                </div>
            </div>
        </div>

        <!-- Biaya & Nilai TAK -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
            <div style="border: 1px solid var(--slate-200); border-radius: 8px; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; background: white;">
                <span style="font-size: 0.8rem; color: var(--slate-500); font-weight: 500;">Biaya Pendaftaran</span>
                @php
                    $priceLower = !empty($event->price) ? strtolower(trim($event->price)) : '';
                    $isGratis = ($event->price_type === 'gratis' || $priceLower === 'gratis' || $priceLower === 'free' || $priceLower === '0');
                @endphp
                <span style="font-size: 1.05rem; font-weight: 700; color: {{ $isGratis ? '#10B981' : 'var(--slate-900)' }};">
                    {{ $isGratis ? 'Gratis' : $event->price }}
                </span>
            </div>

            @if($event->is_tak)
            <div style="border: 1px solid #FECACA; border-radius: 8px; padding: 14px 16px; display: flex; align-items: center; gap: 10px; background: #FEF2F2; color: #991B1B;">
                <i class="fa-solid fa-bolt" style="color: #DC2626; font-size: 1rem;"></i>
                <div style="font-size: 0.75rem; line-height: 1.3;">
                    <strong style="display: block; font-size: 0.78rem;">Memberikan Nilai TAK</strong>
                    Diakui secara akademis.
                </div>
            </div>
            @else
            <div style="border: 1px solid var(--slate-200); border-radius: 8px; padding: 14px 16px; display: flex; align-items: center; gap: 10px; background: var(--slate-50); color: var(--slate-500);">
                <i class="fa-solid fa-ban" style="font-size: 0.9rem;"></i>
                <div style="font-size: 0.75rem; line-height: 1.3;">
                    <strong style="display: block; font-size: 0.78rem;">Tidak Ada Nilai TAK</strong>
                    Hanya berupa event reguler.
                </div>
            </div>
            @endif
        </div>

        <!-- Deskripsi Event -->
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 10px; color: var(--slate-800); border-bottom: 2px solid var(--slate-100); padding-bottom: 6px; display: inline-block;">Deskripsi Event</h3>
            <div style="color: var(--slate-600); line-height: 1.6; font-size: 0.85rem; text-align: justify; white-space: pre-line;">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>

        <!-- Penyelenggara & Link -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <!-- Penyelenggara -->
            <div style="border: 1px solid var(--slate-200); border-radius: 8px; padding: 16px; background: white;">
                <h4 style="font-size: 0.8rem; font-weight: 700; margin: 0 0 12px 0; color: var(--slate-800);">Penyelenggara</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--slate-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--slate-500);">
                            <i class="fa-solid fa-sitemap" style="font-size: 0.75rem;"></i>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--slate-700); font-weight: 500;">
                            {{ $event->organizer_name }}
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--slate-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--slate-500);">
                            <i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--slate-700); font-weight: 500;">
                            {{ $event->contact_person }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link Pendaftaran -->
            <div style="border: 1px solid var(--slate-200); border-radius: 8px; padding: 16px; background: white; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h4 style="font-size: 0.8rem; font-weight: 700; margin: 0 0 4px 0; color: var(--slate-800);">Link Registrasi</h4>
                    <p style="font-size: 0.72rem; color: var(--slate-500); margin: 0 0 10px 0;">URL pendaftaran bagi peserta:</p>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    @if($event->registration_link)
                        <input type="text" value="{{ $event->registration_link }}" readonly style="flex: 1; padding: 8px 12px; border: 1px solid var(--slate-200); border-radius: 6px; font-size: 0.78rem; color: var(--slate-600); background: var(--slate-50); outline: none;">
                        <a href="{{ str_starts_with($event->registration_link, 'http') ? $event->registration_link : 'http://' . $event->registration_link }}" target="_blank" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: var(--slate-100); color: var(--slate-600); border-radius: 6px; border: 1px solid var(--slate-200); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--slate-200)'" onmouseout="this.style.background='var(--slate-100)'" title="Buka Link">
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.8rem;"></i>
                        </a>
                    @else
                        <input type="text" value="Langsung Datang ke Lokasi (Walk-in)" readonly style="flex: 1; padding: 8px 12px; border: 1px dashed var(--slate-300); border-radius: 6px; font-size: 0.78rem; color: var(--slate-500); background: var(--slate-50); outline: none; font-style: italic;">
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
