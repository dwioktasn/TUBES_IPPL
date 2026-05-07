<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelU Events</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>

<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- HERO SECTION -->
    <header class="hero">
        <div class="hero-content">

            <div class="badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">

                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />

                </svg>

                Telkom University Event Hub
            </div>

            <h1>
                Temukan Event<br>
                Kampus Terbaik
            </h1>

            <p>
                Jelajahi seminar, workshop, kompetisi,
                dan event seru lainnya di Telkom University
            </p>

            <div class="search-container">

                <svg class="search-icon"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">

                    <circle cx="11" cy="11" r="8"></circle>

                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>

                </svg>

                <input type="text"
                    class="search-input"
                    placeholder="Cari event...">

            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container">

        <!-- FILTER -->
        <div class="filters-container"
            style="display: flex; align-items: center; gap: 12px; margin-bottom: 40px;">

            <div class="filter-label"
                style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); font-size: 0.95rem; font-weight: 500;">

                <svg width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">

                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>

                </svg>

                Filter:
            </div>

            <div class="filters-bar" style="margin-bottom: 0;">

                <select class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="seminar">Seminar</option>
                    <option value="workshop">Workshop</option>
                    <option value="kompetisi">Kompetisi</option>
                </select>

                <select class="filter-select">
                    <option value="">Hybrid</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>

            </div>
        </div>

        <!-- SECTION HEADER -->
        <div class="section-header"
            style="display: flex; align-items: center; gap: 12px; margin-bottom: 40px;">

            <svg width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="var(--primary-red)"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">

                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>

                <line x1="16" y1="2" x2="16" y2="6"></line>

                <line x1="8" y1="2" x2="8" y2="6"></line>

                <line x1="3" y1="10" x2="21" y2="10"></line>

            </svg>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin: 0;">
                Event Terverifikasi
            </h2>

            <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
                ({{ count($events) }} event)
            </span>
        </div>

        <!-- EVENTS -->
        @if(count($events) > 0)

            <div class="events-grid">

                @foreach ($events as $event)
                    <a href="{{ url('/event/' . $event->slug) }}" style="text-decoration: none; color: inherit; display: block; height: 100%;">
                    <div class="event-card" style="height: 100%;">
                        <div class="event-poster">
                            <img src="{{ $event->poster ? asset('storage/' . $event->poster) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3' }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="event-tags-top">
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
                            <div class="event-category">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                                {{ ucfirst($event->category) }}
                            </div>

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
                                @if($event->price_type === 'berbayar' && $event->price)
                                <div class="event-meta-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                    {{ $event->price }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    </a>

                @endforeach

            </div>

        @else

            <!-- EMPTY STATE -->
            <div class="empty-state">

                <svg width="60"
                    height="60"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#D1D5DB"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    style="margin-bottom: 16px;">

                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>

                    <line x1="16" y1="2" x2="16" y2="6"></line>

                    <line x1="8" y1="2" x2="8" y2="6"></line>

                    <line x1="3" y1="10" x2="21" y2="10"></line>

                    <line x1="8" y1="14" x2="16" y2="14"></line>

                    <line x1="8" y1="18" x2="12" y2="18"></line>

                </svg>

                <h3 style="font-size: 1.15rem; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                    Belum ada event
                </h3>

                <p class="text-muted"
                    style="color: var(--text-muted); font-size: 0.95rem;">

                    Event yang sudah terverifikasi
                    akan muncul di sini

                </p>

            </div>

        @endif

    </main>

    <!-- FOOTER -->
    @include('components.footer')

</body>

</html>