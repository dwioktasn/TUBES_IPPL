<div class="event-card" style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: stretch; border: 1px solid #E5E7EB; border-radius: 12px; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.02); width: 100%; box-sizing: border-box; overflow: hidden; {{ \Carbon\Carbon::parse($event->event_date)->isPast() ? 'opacity: 0.85; filter: grayscale(40%);' : '' }}">
    <div class="event-poster" style="position: relative; width: 240px; height: auto; min-height: 200px; background: #F3F4F6; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
        @if($event->is_tak)
        <div class="tak-badge-img" style="position: absolute; top: 12px; left: 12px; background: #EF4444; color: white; padding: 4px 8px; border-radius: 999px; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; gap: 4px; letter-spacing: 0.05em; z-index: 10;">
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

            @if(\Carbon\Carbon::parse($event->event_date)->isPast())
                <span class="badge" style="padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: #111827; color: white; border: 1px solid #111827;"><i class="fa-solid fa-flag-checkered"></i> Selesai</span>
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
