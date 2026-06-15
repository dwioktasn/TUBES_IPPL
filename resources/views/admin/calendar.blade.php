@extends('admin.layouts.app')

@section('title', 'Kalender Event - TelU Events')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h2>Kalender Event</h2>
        <p>Jadwal seluruh event yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="content-box">
    <!-- Legend -->
    <div style="display: flex; gap: 12px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--slate-200);">
        <span style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: var(--slate-600); font-weight: 500;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #10B981; display: inline-block;"></span> Verified
        </span>
        <span style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: var(--slate-600); font-weight: 500;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span> Pending
        </span>
        <span style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: var(--slate-600); font-weight: 500;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #EF4444; display: inline-block;"></span> Rejected
        </span>
    </div>

    <!-- Calendar Container -->
    <div id="full-calendar"></div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('full-calendar');
        
        // Pass PHP array to JS
        var eventsData = @json($calendarEvents);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: eventsData,
            eventClick: function(info) {
                // Info.event contains the event data
                // URL contains link to the event management page with search filter
            },
            themeSystem: 'standard',
            height: 600,
            eventTimeFormat: { // like '14:30'
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            }
        });
        
        calendar.render();
    });
</script>

<style>
    /* FullCalendar Styling Adjustments for Better Look */
    .fc {
        font-family: 'Inter', sans-serif;
    }
    .fc-theme-standard .fc-scrollgrid {
        border: 1px solid var(--slate-200);
    }
    .fc-theme-standard th, .fc-theme-standard td {
        border-color: var(--slate-200);
    }
    .fc .fc-toolbar-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--slate-900);
    }
    .fc .fc-button-primary {
        background-color: white;
        border-color: var(--slate-200);
        color: var(--slate-600);
        text-transform: capitalize;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 12px;
    }
    .fc .fc-button-primary:hover {
        background-color: var(--slate-50);
        border-color: var(--slate-300);
        color: var(--slate-850);
    }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active {
        background-color: var(--slate-100);
        border-color: var(--slate-300);
        color: var(--slate-900);
    }
    .fc .fc-button-primary:focus {
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.15);
    }
    .fc-daygrid-event {
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.72rem;
        font-weight: 600;
        border: none;
    }
    .fc-col-header-cell-cushion {
        color: var(--slate-600);
        font-weight: 600;
        font-size: 0.78rem;
        padding: 6px;
        text-decoration: none;
    }
    .fc-daygrid-day-number {
        color: var(--slate-700);
        font-weight: 500;
        font-size: 0.78rem;
        padding: 6px;
        text-decoration: none;
    }
</style>
@endpush
