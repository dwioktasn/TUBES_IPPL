@php
    $isPast = \Carbon\Carbon::parse($event->event_date)->isPast();
@endphp
<a href="{{ url('/event/' . $event->slug) }}" style="text-decoration: none; color: inherit; display: block; height: 100%;">
<div class="event-card" style="height: 100%; {{ $isPast ? 'opacity: 0.8; filter: grayscale(60%);' : '' }}">
    <div class="event-poster" style="position: relative;">
        <img src="{{ $event->poster ? asset('storage/' . $event->poster) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3' }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        
        @if($isPast)
        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 5;">
            <div style="border: 3px solid rgba(255,255,255,0.9); color: rgba(255,255,255,0.9); padding: 8px 16px; font-weight: 800; font-size: 1.5rem; letter-spacing: 2px; transform: rotate(-15deg); border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.3); text-shadow: 0 2px 4px rgba(0,0,0,0.5);">SELESAI</div>
        </div>
        @endif

        <div class="event-tags-top" style="z-index: 10; position: absolute;">
            @if($event->is_tak)
                <span class="tag-badge tag-tak">TAK</span>
            @endif
            
            @if($event->price_type === 'gratis')
                <span class="tag-badge tag-gratis">GRATIS</span>
            @else
                <span class="tag-badge tag-berbayar">BERBAYAR</span>
            @endif

        </div>
    </div>

    <div class="event-body">
        <div class="event-category" style="margin-bottom: 8px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            {{ ucfirst($event->category) }}
        </div>

        @if($event->prodi)
        <div style="margin-bottom: 12px;">
            <span style="display: inline-flex; align-items: center; gap: 4px; background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                Khusus Prodi {{ $event->prodi }}
            </span>
        </div>
        @endif

        <h3 class="event-title">
            {{ $event->title }}
        </h3>

        <div class="event-meta">
            <div class="event-meta-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                {{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('d F Y') }}
            </div>
            <div class="event-meta-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                {{ $event->location }}
            </div>
            <div class="event-meta-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
                {{ ucfirst($event->event_type) }}
            </div>
            <div class="event-meta-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span style="{{ $event->price_type === 'gratis' ? 'color: #10B981; font-weight: 600;' : '' }}">
                    {{ $event->price_type === 'gratis' ? 'Gratis' : $event->price }}
                </span>
            </div>
        </div>
    </div>
</div>
</a>
