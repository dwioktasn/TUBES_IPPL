@extends('admin.layouts.app')

@section('title', 'Manajemen Event - TelU Events')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div class="page-title">
        <h2>Manajemen Event</h2>
        <p>Kelola, verifikasi, dan tolak permintaan event mahasiswa.</p>
    </div>
    <div>
        <a href="{{ route('admin.event.create') }}" class="btn-action" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 8px; font-size: 0.95rem; font-weight: 600; text-decoration: none; background: #DC2626; color: white; box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.2);">
            <i class="fa-solid fa-plus"></i> Tambah Event
        </a>
    </div>
</div>

<div class="content-box">
    <form action="{{ route('admin.events') }}" method="GET" class="search-form">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan judul, penyelenggara, lokasi..." value="{{ request('search') }}">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
    </form>

    <div class="filter-container" style="display: inline-flex; background: #F3F4F6; padding: 6px; border-radius: 999px; gap: 4px; margin-bottom: 32px;">
        <a href="{{ route('admin.events', ['status' => 'pending', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'pending' || !request('status') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 999px; text-decoration: none; font-size: 0.875rem; font-weight: 500; color: {{ request('status') == 'pending' || !request('status') ? '#111827' : '#4B5563' }}; background: {{ request('status') == 'pending' || !request('status') ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'pending' || !request('status') ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
            <i class="fa-regular fa-clock"></i> Pending 
            <span style="padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; background: #FEF3C7; color: #D97706;">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('admin.events', ['status' => 'approved', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'approved' ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 999px; text-decoration: none; font-size: 0.875rem; font-weight: 500; color: {{ request('status') == 'approved' ? '#111827' : '#4B5563' }}; background: {{ request('status') == 'approved' ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'approved' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
            <i class="fa-regular fa-circle-check"></i> Verified 
            <span style="padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; background: #DCFCE7; color: #16A34A;">{{ $verifiedCount }}</span>
        </a>
        <a href="{{ route('admin.events', ['status' => 'rejected', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'rejected' ? 'active' : '' }}" style="display: flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 999px; text-decoration: none; font-size: 0.875rem; font-weight: 500; color: {{ request('status') == 'rejected' ? '#111827' : '#4B5563' }}; background: {{ request('status') == 'rejected' ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'rejected' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
            <i class="fa-regular fa-circle-xmark"></i> Rejected 
            <span style="padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; background: #FEE2E2; color: #DC2626;">{{ $rejectedCount }}</span>
        </a>
    </div>

    <div class="event-list" style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($events as $event)
        <div class="event-card" style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: stretch; border: 1px solid #E5E7EB; border-radius: 12px; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.02); width: 100%; box-sizing: border-box; overflow: hidden;">
            <div class="event-poster" style="position: relative; width: 240px; height: auto; min-height: 200px; background: #F3F4F6; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                @if($event->is_tak)
                <div class="tak-badge-img" style="position: absolute; top: 12px; left: 12px; background: #EF4444; color: white; padding: 4px 8px; border-radius: 999px; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; gap: 4px; letter-spacing: 0.05em;">
                    <i class="fa-solid fa-bolt" style="font-size: 0.6rem;"></i> TAK
                </div>
                @endif

                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <i class="fa-regular fa-calendar" style="font-size: 3rem; color: #9CA3AF;"></i>
                @endif
            </div>

            <div class="event-content" style="flex: 1; display: flex; flex-direction: column; min-width: 0; padding: 24px;">
                <div class="event-badges" style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                    <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: #F9FAFB; color: #374151; border: 1px solid #E5E7EB;">{{ ucfirst($event->category) }}</span>
                    <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: white; color: #374151; border: 1px solid #E5E7EB;">{{ ucfirst($event->event_type) }}</span>
                    @if($event->prodi)
                        <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;">{{ $event->prodi }}</span>
                    @endif
                    
                    @if($event->status == 'pending')
                        <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: white; color: #F59E0B; border: 1px solid #F59E0B;"><i class="fa-regular fa-clock"></i> Pending</span>
                    @elseif($event->status == 'approved')
                        <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: white; color: #10B981; border: 1px solid #10B981;"><i class="fa-regular fa-circle-check"></i> Verified</span>
                    @else
                        <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: white; color: #EF4444; border: 1px solid #EF4444;"><i class="fa-regular fa-circle-xmark"></i> Rejected</span>
                    @endif
                </div>

                <a href="{{ route('admin.event.show', $event->id) }}" style="text-decoration: none;">
                    <h3 class="event-title" style="margin: 0 0 16px 0; font-size: 1.25rem; font-weight: 700; color: #111827;">{{ $event->title }}</h3>
                </a>

                <div class="event-details-row" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; gap: 24px;">
                    <div class="event-details-col" style="display: flex; flex-direction: column; gap: 8px;">
                        <div class="detail-item" style="display: flex; align-items: center; gap: 8px; color: #6B7280; font-size: 0.875rem;">
                            <i class="fa-regular fa-user" style="color: #9CA3AF; width: 16px;"></i>
                            {{ $event->organizer_name }}
                        </div>
                        <div class="detail-item" style="display: flex; align-items: center; gap: 8px; color: #6B7280; font-size: 0.875rem;">
                            <i class="fa-solid fa-location-dot" style="color: #9CA3AF; width: 16px;"></i>
                            {{ $event->location }}
                        </div>
                    </div>
                    <div class="event-details-col" style="display: flex; flex-direction: column; gap: 8px;">
                        <div class="detail-item" style="display: flex; align-items: center; gap: 8px; color: #6B7280; font-size: 0.875rem;">
                            <i class="fa-regular fa-calendar-days" style="color: #9CA3AF; width: 16px;"></i>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y - H:i') }}
                        </div>
                    </div>
                </div>

                <div class="event-actions" style="display: flex; align-items: center; gap: 12px; margin-top: auto; padding-top: 16px; border-top: 1px solid #E5E7EB;">
                    <a href="{{ route('admin.event.show', $event->id) }}" class="btn-action" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 0.875rem; font-weight: 500; text-decoration: none; background: #F3F4F6; color: #374151; border: 1px solid #D1D5DB;">
                        <i class="fa-regular fa-eye"></i> Detail
                    </a>

                    @if($event->status != 'approved')
                    <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-action" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; background: #10B981; color: white;">
                            <i class="fa-solid fa-check"></i> Approve
                        </button>
                    </form>
                    @endif

                    @if($event->status != 'rejected')
                    <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-action" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; background: #EF4444; color: white;">
                            <i class="fa-solid fa-xmark"></i> Reject
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="margin: 0; margin-left: auto;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?');" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; background: transparent; color: #EF4444;">
                            <i class="fa-regular fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px; color: #6B7280; background: white; border-radius: 12px; border: 1px dashed #D1D5DB;">
            <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 16px; color: #E5E7EB;"></i>
            <p>Tidak ada event yang ditemukan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
