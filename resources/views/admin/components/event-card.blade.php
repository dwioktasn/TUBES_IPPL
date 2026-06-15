<div class="admin-event-card {{ \Carbon\Carbon::parse($event->event_date)->isPast() ? 'completed' : '' }}">
    <div class="event-poster">
        @if($event->is_tak)
        <div class="tak-badge-img">
            <i class="fa-solid fa-bolt"></i> TAK
        </div>
        @endif

        @if($event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <div style="text-align: center; color: var(--slate-400);">
                <i class="fa-regular fa-image" style="font-size: 2rem; margin-bottom: 6px; display: block;"></i>
                <span style="font-size: 0.7rem; font-weight: 500;">No Poster</span>
            </div>
        @endif
    </div>

    <div class="event-content">
        <div class="event-badges">
            <span class="badge badge-category">{{ ucfirst($event->category) }}</span>
            <span class="badge badge-type">{{ ucfirst($event->event_type) }}</span>
            
            @if($event->prodi)
                <span class="badge badge-prodi" title="{{ $event->prodi }}">{{ $event->prodi }}</span>
            @endif
            
            @if($event->status == 'pending')
                <span class="badge badge-status-pending"><i class="fa-regular fa-clock"></i> Pending</span>
            @elseif($event->status == 'approved')
                <span class="badge badge-status-approved"><i class="fa-regular fa-circle-check"></i> Verified</span>
            @else
                <span class="badge badge-status-rejected"><i class="fa-regular fa-circle-xmark"></i> Rejected</span>
            @endif

            @if(\Carbon\Carbon::parse($event->event_date)->isPast())
                <span class="badge badge-completed"><i class="fa-solid fa-flag-checkered"></i> Selesai</span>
            @endif
        </div>

        <a href="{{ route('admin.event.show', $event->id) }}" style="text-decoration: none;">
            <h3 class="event-title">{{ $event->title }}</h3>
        </a>

        <div class="event-details-row">
            <div class="detail-item">
                <i class="fa-regular fa-user"></i>
                {{ $event->organizer_name }}
            </div>
            <div class="detail-item">
                <i class="fa-solid fa-location-dot"></i>
                {{ $event->location }}
            </div>
            <div class="detail-item">
                <i class="fa-regular fa-calendar-days"></i>
                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y - H:i') }}
            </div>
        </div>

        <div class="event-actions">
            <a href="{{ route('admin.event.show', $event->id) }}" class="admin-btn-action admin-btn-detail">
                <i class="fa-regular fa-eye"></i> Detail
            </a>

            @if($event->status != 'approved')
            <form action="{{ route('admin.event.approve', $event->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-btn-action admin-btn-approve">
                    <i class="fa-solid fa-check"></i> Approve
                </button>
            </form>
            @endif

            @if($event->status != 'rejected')
            <form action="{{ route('admin.event.reject', $event->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-btn-action admin-btn-reject">
                    <i class="fa-solid fa-xmark"></i> Reject
                </button>
            </form>
            @endif

            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="margin: 0; margin-left: auto;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn-action admin-btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                    <i class="fa-regular fa-trash-can"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
