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
    <div style="display: flex; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #E5E7EB;">
        <span style="display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: #4B5563;">
            <span style="width: 12px; height: 12px; border-radius: 50%; background: #10B981;"></span> Verified
        </span>
        <span style="display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: #4B5563;">
            <span style="width: 12px; height: 12px; border-radius: 50%; background: #F59E0B;"></span> Pending
        </span>
        <span style="display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: #4B5563;">
            <span style="width: 12px; height: 12px; border-radius: 50%; background: #EF4444;"></span> Rejected
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
                // If there's an URL attached to the event, FullCalendar visits it automatically unless default is prevented
                // In our case we set URL to the event management page with search filter
            },
            themeSystem: 'standard',
            height: 700,
            eventTimeFormat: { // like '14:30:00'
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
        border: 1px solid #E5E7EB;
    }
    .fc-theme-standard th, .fc-theme-standard td {
        border-color: #E5E7EB;
    }
    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
    }
    .fc .fc-button-primary {
        background-color: white;
        border-color: #D1D5DB;
        color: #374151;
        text-transform: capitalize;
    }
    .fc .fc-button-primary:hover {
        background-color: #F9FAFB;
        border-color: #D1D5DB;
        color: #111827;
    }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active {
        background-color: #F3F4F6;
        border-color: #D1D5DB;
        color: #111827;
    }
    .fc .fc-button-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(209, 213, 219, 0.5);
    }
    .fc-daygrid-event {
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.8rem;
        border: none;
    }
    .fc-col-header-cell-cushion {
        color: #4B5563;
        font-weight: 500;
        padding: 8px;
    }
    .fc-daygrid-day-number {
        color: #374151;
        font-weight: 500;
        padding: 8px;
    }
</style>
@endpush
