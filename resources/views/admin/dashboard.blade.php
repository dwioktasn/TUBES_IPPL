@extends('admin.layouts.app')

@section('title', 'Dashboard - TelU Events')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h2>Dashboard</h2>
        <p>Ringkasan sistem dan event yang membutuhkan perhatian.</p>
    </div>
</div>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px;">
    <div class="stat-card" style="background: white; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; border: 1px solid #F3F4F6; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="stat-info">
            <h3 style="margin: 0; font-size: 0.875rem; color: #6B7280; font-weight: 500;">Total Event</h3>
            <p style="margin: 12px 0 0 0; font-size: 2rem; font-weight: 700; color: #111827; line-height: 1;">{{ $totalEvents }}</p>
        </div>
        <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: #FEE2E2; color: #EF4444;">
            <i class="fa-solid fa-border-all"></i>
        </div>
    </div>
    <div class="stat-card" style="background: white; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; border: 1px solid #F3F4F6; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="stat-info">
            <h3 style="margin: 0; font-size: 0.875rem; color: #6B7280; font-weight: 500;">Menunggu Verifikasi</h3>
            <p style="margin: 12px 0 0 0; font-size: 2rem; font-weight: 700; color: #111827; line-height: 1;">{{ $pendingEvents }}</p>
        </div>
        <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: #FFEDD5; color: #F59E0B;">
            <i class="fa-regular fa-clock"></i>
        </div>
    </div>
    <div class="stat-card" style="background: white; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; border: 1px solid #F3F4F6; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="stat-info">
            <h3 style="margin: 0; font-size: 0.875rem; color: #6B7280; font-weight: 500;">Terverifikasi</h3>
            <p style="margin: 12px 0 0 0; font-size: 2rem; font-weight: 700; color: #111827; line-height: 1;">{{ $verifiedEvents }}</p>
        </div>
        <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: #DCFCE7; color: #22C55E;">
            <i class="fa-regular fa-circle-check"></i>
        </div>
    </div>
    <div class="stat-card" style="background: white; border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: flex-start; border: 1px solid #F3F4F6; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="stat-info">
            <h3 style="margin: 0; font-size: 0.875rem; color: #6B7280; font-weight: 500;">Ditolak</h3>
            <p style="margin: 12px 0 0 0; font-size: 2rem; font-weight: 700; color: #111827; line-height: 1;">{{ $rejectedEvents }}</p>
        </div>
        <div class="stat-icon" style="width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: #FEE2E2; color: #EF4444;">
            <i class="fa-regular fa-circle-xmark"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Event Pending Terbaru -->
    <div class="content-box" style="padding: 24px; background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: #111827;">Pending Terbaru</h3>
            <a href="{{ route('admin.events', ['status' => 'pending']) }}" style="color: #EF4444; font-size: 0.875rem; text-decoration: none; font-weight: 500;">Lihat Semua</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($latestPendingEvents as $event)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border: 1px solid #F3F4F6; border-radius: 12px; background: #F9FAFB;">
                <div style="display: flex; gap: 16px; align-items: center;">
                    <div style="width: 48px; height: 48px; border-radius: 8px; background: #E5E7EB; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-regular fa-image" style="color: #9CA3AF;"></i>
                        @endif
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 0.95rem; font-weight: 600; color: #111827;">{{ $event->title }}</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #6B7280;">
                            <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            <span style="margin: 0 8px;">|</span>
                            <i class="fa-regular fa-user" style="margin-right: 4px;"></i> {{ $event->organizer_name }}
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="padding: 6px 12px; background: #10B981; color: white; border: none; border-radius: 6px; font-size: 0.8rem; font-weight: 500; cursor: pointer;">Approve</button>
                    </form>
                    <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="padding: 6px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 0.8rem; font-weight: 500; cursor: pointer;">Reject</button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 32px 0; color: #6B7280;">
                <i class="fa-regular fa-circle-check" style="font-size: 2rem; margin-bottom: 12px; color: #D1D5DB;"></i>
                <p style="margin: 0;">Tidak ada event pending saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Mini Calendar -->
    <div class="content-box" style="padding: 24px; background: white; border-radius: 16px; border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 20px 0; font-size: 1.125rem; font-weight: 600; color: #111827;">Kalender Event</h3>
        <div id="mini-calendar" style="font-size: 0.85em;"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('mini-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'prev,next'
            },
            height: 'auto',
            contentHeight: 350,
            events: '/admin/calendar', // We will update this or just pass data?
            // Actually, for the mini calendar, maybe we don't need real events, 
            // but let's just make it a visual calendar for now.
        });
        calendar.render();
    });
</script>
<style>
    /* FullCalendar Mini Style Tweaks */
    .fc .fc-toolbar-title { font-size: 1.1rem; }
    .fc .fc-button { padding: 4px 8px; font-size: 0.8rem; background-color: #EF4444; border-color: #EF4444; }
    .fc .fc-button:hover { background-color: #DC2626; border-color: #DC2626; }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active { background-color: #B91C1C; border-color: #B91C1C; }
</style>
@endpush
