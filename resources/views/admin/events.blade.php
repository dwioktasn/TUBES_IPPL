@extends('admin.layouts.app')

@section('title', 'Manajemen Event - TelU Events')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h2>Manajemen Event</h2>
        <p>Kelola, verifikasi, dan tolak permintaan event mahasiswa.</p>
    </div>
    <div>
        <a href="{{ route('admin.event.create') }}" class="admin-btn-action" style="background: var(--telu-red); color: white; padding: 10px 18px; border-radius: 8px; font-size: 0.85rem; box-shadow: 0 4px 6px -1px rgba(192, 36, 40, 0.2);">
            <i class="fa-solid fa-plus"></i> Tambah Event
        </a>
    </div>
</div>

<!-- STATS GRID -->
<div class="stats-grid">
    <!-- Total Event -->
    <a href="{{ route('admin.events') }}" class="stat-card">
        <div>
            <h3>Total Event</h3>
            <p>{{ $totalCount }}</p>
        </div>
        <div class="stat-icon" style="background: var(--slate-100); color: var(--slate-600);">
            <i class="fa-solid fa-list-check"></i>
        </div>
    </a>
    <!-- Pending -->
    <a href="{{ route('admin.events', ['status' => 'pending']) }}" class="stat-card">
        <div>
            <h3>Pending</h3>
            <p style="color: #D97706;">{{ $pendingCount }}</p>
        </div>
        <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
            <i class="fa-regular fa-clock"></i>
        </div>
    </a>
    <!-- Verified -->
    <a href="{{ route('admin.events', ['status' => 'approved']) }}" class="stat-card">
        <div>
            <h3>Verified</h3>
            <p style="color: #16A34A;">{{ $verifiedCount }}</p>
        </div>
        <div class="stat-icon" style="background: #DCFCE7; color: #16A34A;">
            <i class="fa-regular fa-circle-check"></i>
        </div>
    </a>
    <!-- Rejected -->
    <a href="{{ route('admin.events', ['status' => 'rejected']) }}" class="stat-card">
        <div>
            <h3>Rejected</h3>
            <p style="color: #DC2626;">{{ $rejectedCount }}</p>
        </div>
        <div class="stat-icon" style="background: #FEE2E2; color: #DC2626;">
            <i class="fa-regular fa-circle-xmark"></i>
        </div>
    </a>
</div>

<div class="content-box">
    <!-- SEARCH & FILTER BAR -->
    <div style="display: flex; gap: 16px; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap;">
        <!-- Search Input -->
        <form action="{{ route('admin.events') }}" method="GET" class="search-form" style="flex: 1; min-width: 260px; margin-bottom: 0;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan judul, penyelenggara, lokasi..." value="{{ request('search') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>

        <!-- Status Filter Tabs -->
        <div class="filter-container">
            <a href="{{ route('admin.events', ['search' => request('search')]) }}" class="tab-btn" style="color: {{ !request('status') ? 'var(--slate-900)' : 'var(--slate-500)' }}; background: {{ !request('status') ? 'white' : 'transparent' }}; box-shadow: {{ !request('status') ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
                Semua
            </a>
            <a href="{{ route('admin.events', ['status' => 'pending', 'search' => request('search')]) }}" class="tab-btn" style="color: {{ request('status') == 'pending' ? 'var(--slate-900)' : 'var(--slate-500)' }}; background: {{ request('status') == 'pending' ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'pending' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
                Pending 
                <span class="tab-badge" style="background: #FEF3C7; color: #D97706;">{{ $pendingCount }}</span>
            </a>
            <a href="{{ route('admin.events', ['status' => 'approved', 'search' => request('search')]) }}" class="tab-btn" style="color: {{ request('status') == 'approved' ? 'var(--slate-900)' : 'var(--slate-500)' }}; background: {{ request('status') == 'approved' ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'approved' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
                Verified 
                <span class="tab-badge" style="background: #DCFCE7; color: #16A34A;">{{ $verifiedCount }}</span>
            </a>
            <a href="{{ route('admin.events', ['status' => 'rejected', 'search' => request('search')]) }}" class="tab-btn" style="color: {{ request('status') == 'rejected' ? 'var(--slate-900)' : 'var(--slate-500)' }}; background: {{ request('status') == 'rejected' ? 'white' : 'transparent' }}; box-shadow: {{ request('status') == 'rejected' ? '0 1px 2px rgba(0,0,0,0.05)' : 'none' }};">
                Rejected 
                <span class="tab-badge" style="background: #FEE2E2; color: #DC2626;">{{ $rejectedCount }}</span>
            </a>
        </div>
    </div>

    @php
        $upcomingEvents = $events->filter(function($e) { return !\Carbon\Carbon::parse($e->event_date)->isPast(); });
        $pastEvents = $events->filter(function($e) { return \Carbon\Carbon::parse($e->event_date)->isPast(); });
    @endphp

    <div class="event-list" style="display: flex; flex-direction: column; gap: 16px;">
        @if($upcomingEvents->count() > 0)
            @foreach($upcomingEvents as $event)
                @include('admin.components.event-card', ['event' => $event])
            @endforeach
        @endif

        @if($pastEvents->count() > 0)
            <div style="margin: 24px 0 12px 0; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid var(--slate-100); padding-bottom: 10px;">
                <i class="fa-solid fa-flag-checkered" style="color: var(--slate-500); font-size: 1rem;"></i>
                <h3 style="margin: 0; font-size: 0.95rem; font-weight: 700; color: var(--slate-700);">Event Yang Sudah Selesai</h3>
                <span style="background: var(--slate-100); padding: 2px 8px; border-radius: 999px; font-size: 0.72rem; font-weight: 600; color: var(--slate-500);">{{ $pastEvents->count() }} event</span>
            </div>

            @foreach($pastEvents as $event)
                @include('admin.components.event-card', ['event' => $event])
            @endforeach
        @endif

        @if($events->count() == 0)
        <div style="text-align: center; padding: 48px 32px; color: var(--slate-500); background: white; border-radius: 12px; border: 1px dashed var(--slate-300);">
            <i class="fa-regular fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--slate-200);"></i>
            <p style="margin: 0; font-weight: 500; font-size: 0.85rem;">Tidak ada event yang ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
