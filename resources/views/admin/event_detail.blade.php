@extends('admin.layouts.app')

@section('title', 'Detail Event - TelU Events')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div class="page-title" style="display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('admin.events') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #F3F4F6; color: #4B5563; text-decoration: none; font-size: 1.2rem; transition: background 0.2s;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: #111827;">Detail Event</h2>
        </div>
    </div>
    
    <div class="event-actions-top" style="display: flex; gap: 12px;">
        <a href="{{ route('admin.event.edit', $event->id) }}" class="btn-action" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; text-decoration: none; background: #3B82F6; color: white;">
            <i class="fa-solid fa-pen-to-square"></i> Edit
        </a>

        @if($event->status != 'approved')
        <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-action" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; border: none; background: #10B981; color: white;">
                <i class="fa-solid fa-check"></i> Approve
            </button>
        </form>
        @endif

        @if($event->status != 'rejected')
        <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-action" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; border: none; background: #EF4444; color: white;">
                <i class="fa-solid fa-xmark"></i> Reject
            </button>
        </form>
        @endif
        
        <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?');" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; border: 1px solid #D1D5DB; background: white; color: #EF4444;">
                <i class="fa-regular fa-trash-can"></i> Hapus
            </button>
        </form>
    </div>
</div>

<div class="content-box" style="padding: 0; overflow: hidden; background: white; border-radius: 12px; border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    
    <!-- Header Status -->
    <div style="padding: 16px 32px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 0.9rem; color: #6B7280;">Status Event:</div>
        <div>
            @if($event->status == 'pending')
                <span style="padding: 6px 16px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; background: #FEF3C7; color: #D97706; display: inline-flex; align-items: center; gap: 6px;"><i class="fa-regular fa-clock"></i> Menunggu Verifikasi</span>
            @elseif($event->status == 'approved')
                <span style="padding: 6px 16px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; background: #DCFCE7; color: #16A34A; display: inline-flex; align-items: center; gap: 6px;"><i class="fa-regular fa-circle-check"></i> Disetujui</span>
            @else
                <span style="padding: 6px 16px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; background: #FEE2E2; color: #DC2626; display: inline-flex; align-items: center; gap: 6px;"><i class="fa-regular fa-circle-xmark"></i> Ditolak</span>
            @endif
        </div>
    </div>

    <!-- Poster Section -->
    <div style="background: #F3F4F6; width: 100%; display: flex; justify-content: center; align-items: center; padding: 40px 0;">
        <div style="position: relative; width: 100%; max-width: 320px; aspect-ratio: 3 / 4; background: #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <img src="{{ $event->poster ? asset('storage/' . $event->poster) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3' }}" style="width: 100%; height: 100%; object-fit: cover;">
            <div style="position: absolute; top: 16px; right: 16px; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                @if($event->is_tak)
                    <span style="padding: 6px 16px; font-size: 0.8rem; font-weight: 700; background: #EF4444; color: white; border-radius: 999px; letter-spacing: 0.05em; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">TAK</span>
                @endif
                @if($event->price_type === 'gratis')
                    <span style="padding: 6px 16px; font-size: 0.8rem; font-weight: 700; background: #10B981; color: white; border-radius: 999px; letter-spacing: 0.05em; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">GRATIS</span>
                @else
                    <span style="padding: 6px 16px; font-size: 0.8rem; font-weight: 700; background: #F59E0B; color: white; border-radius: 999px; letter-spacing: 0.05em; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">BERBAYAR</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div style="padding: 32px; max-width: 800px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: 32px; text-align: center;">
            <h1 style="font-size: 2rem; font-weight: 800; color: #111827; margin: 0 0 16px 0; line-height: 1.3;">{{ $event->title }}</h1>
        </div>

        <!-- Grid Info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; background: #F9FAFB; padding: 24px; border-radius: 12px; border: 1px solid #F3F4F6;">
            <div style="display: flex; gap: 16px; align-items: flex-start;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-regular fa-calendar-days" style="color: #EF4444; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 4px; font-weight: 500;">Tanggal & Waktu</div>
                    <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
                    <div style="font-size: 0.85rem; color: #4B5563; margin-top: 2px;">{{ \Carbon\Carbon::parse($event->event_date)->format('H.i') }} WIB</div>
                </div>
            </div>

            <div style="display: flex; gap: 16px; align-items: flex-start;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-solid fa-location-dot" style="color: #EF4444; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 4px; font-weight: 500;">Lokasi</div>
                    <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ $event->location }}</div>
                    @if($event->event_type)
                    <div style="font-size: 0.85rem; color: #4B5563; margin-top: 2px;">{{ ucfirst($event->event_type) }}</div>
                    @endif
                </div>
            </div>

            <div style="display: flex; gap: 16px; align-items: flex-start;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-solid fa-tags" style="color: #EF4444; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 4px; font-weight: 500;">Kategori</div>
                    <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ ucfirst($event->category) }}</div>
                </div>
            </div>

            <div style="display: flex; gap: 16px; align-items: flex-start;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fa-solid fa-users" style="color: #EF4444; font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 4px; font-weight: 500;">Target Peserta</div>
                    <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ $event->target_participants }}</div>
                </div>
            </div>
        </div>

        <!-- Biaya Pendaftaran -->
        <div style="background: white; border: 1px solid #E5E7EB; border-radius: 12px; padding: 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 0.9rem; color: #6B7280; font-weight: 500;">Biaya Pendaftaran</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #111827;">
                @if($event->price_type === 'gratis')
                    FREE
                @else
                    {{ $event->price }}
                @endif
            </div>
        </div>

        <!-- TAK -->
        @if($event->is_tak)
        <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 12px; padding: 20px; margin-bottom: 32px; display: flex; gap: 16px; align-items: flex-start;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fa-solid fa-bolt" style="color: #DC2626; font-size: 1.1rem;"></i>
            </div>
            <div>
                <div style="font-weight: 700; font-size: 1rem; color: #B91C1C; margin-bottom: 6px;">Event Memberikan Nilai TAK</div>
                <div style="font-size: 0.9rem; color: #991B1B; line-height: 1.5;">Event ini memberikan nilai Tri Dharma Aktivitas Kemahasiswaan (TAK) yang dapat digunakan untuk memenuhi syarat kelulusan di Telkom University.</div>
            </div>
        </div>
        @endif

        <!-- Tentang Event -->
        <div style="margin-bottom: 32px;">
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 16px; color: #111827; border-bottom: 2px solid #F3F4F6; padding-bottom: 8px; display: inline-block;">Deskripsi Event</h3>
            <div style="color: #4B5563; line-height: 1.7; font-size: 0.95rem; text-align: justify;">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>

        <!-- Penyelenggara & Link -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
            <div style="background: white; border: 1px solid #E5E7EB; border-radius: 12px; padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111827;">Informasi Penyelenggara</h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-sitemap" style="color: #6B7280; font-size: 0.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 2px; font-weight: 500;">Diselenggarakan oleh</div>
                            <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ $event->organizer_name }}</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-phone" style="color: #6B7280; font-size: 0.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: #6B7280; margin-bottom: 2px; font-weight: 500;">Kontak</div>
                            <div style="font-weight: 600; color: #111827; font-size: 0.95rem;">{{ $event->contact_person }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background: white; border: 1px solid #E5E7EB; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; color: #111827;">Link Pendaftaran</h3>
                <p style="font-size: 0.9rem; color: #6B7280; margin-bottom: 16px; line-height: 1.5;">Peserta akan diarahkan ke link berikut saat mendaftar:</p>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input type="text" value="{{ $event->registration_link }}" readonly style="flex: 1; padding: 10px 16px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 0.9rem; color: #374151; background: #F9FAFB;">
                    <a href="{{ str_starts_with($event->registration_link, 'http') ? $event->registration_link : 'http://' . $event->registration_link }}" target="_blank" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: #F3F4F6; color: #4B5563; border-radius: 6px; border: 1px solid #D1D5DB; text-decoration: none;" title="Buka Link">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .btn-action:hover {
        opacity: 0.9;
    }
</style>
@endsection
