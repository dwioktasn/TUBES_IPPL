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

    @php
        $upcomingEvents = $events->filter(function($e) { return !\Carbon\Carbon::parse($e->event_date)->isPast(); });
        $pastEvents = $events->filter(function($e) { return \Carbon\Carbon::parse($e->event_date)->isPast(); });
    @endphp

    <div class="event-list" style="display: flex; flex-direction: column; gap: 20px;">
        @if($upcomingEvents->count() > 0)
            @foreach($upcomingEvents as $event)
                @include('admin.components.event-card', ['event' => $event])
            @endforeach
        @endif

        @if($pastEvents->count() > 0)
            <div style="margin: 32px 0 16px 0; display: flex; align-items: center; gap: 12px; border-bottom: 2px solid #E5E7EB; padding-bottom: 12px;">
                <i class="fa-solid fa-flag-checkered" style="color: #6B7280; font-size: 1.2rem;"></i>
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #4B5563;">Event Yang Sudah Selesai</h3>
                <span style="background: #F3F4F6; padding: 2px 8px; border-radius: 999px; font-size: 0.8rem; font-weight: 600; color: #6B7280;">{{ $pastEvents->count() }} event</span>
            </div>

            @foreach($pastEvents as $event)
                @include('admin.components.event-card', ['event' => $event])
            @endforeach
        @endif

        @if($events->count() == 0)
        <div style="text-align: center; padding: 40px; color: #6B7280; background: white; border-radius: 12px; border: 1px dashed #D1D5DB;">
            <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 16px; color: #E5E7EB;"></i>
            <p>Tidak ada event yang ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
