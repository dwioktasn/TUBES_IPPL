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

    <!-- FORM FILTER -->
    <form id="searchForm" action="{{ route('home') }}" method="GET" style="display: none;"></form>

    <!-- HERO SECTION -->
    <header class="hero">
        <div class="hero-content">

            <div class="badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">

                    <path d="M22 10L12 5 2 10l10 5 10-5z"/>
                    <path d="M6 12v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/>
                    <path d="M22 10v6"/>

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
                    name="search"
                    form="searchForm"
                    value="{{ request('search') }}"
                    placeholder="Cari event..."
                    placeholder="Cari event...">

            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container">

        <!-- FILTER -->
        <div class="filters-container">

            <div class="filter-label">

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

            <div class="filters-bar">

                <select class="filter-select" name="category" form="searchForm">
                    <option value="">Semua Kategori</option>
                    <option value="seminar" {{ request('category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="workshop" {{ request('category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="kompetisi" {{ request('category') == 'kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                    <option value="kepanitiaan" {{ request('category') == 'kepanitiaan' ? 'selected' : '' }}>Kepanitiaan</option>
                    <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <select class="filter-select" name="event_type" form="searchForm">
                    <option value="">Semua Tipe</option>
                    <option value="online" {{ request('event_type') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('event_type') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="hybrid" {{ request('event_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>

                <select class="filter-select" name="prodi" form="searchForm">
                    <option value="">Semua Prodi</option>
                    <option value="S1 Teknik Telekomunikasi" {{ request('prodi') == 'S1 Teknik Telekomunikasi' ? 'selected' : '' }}>S1 Teknik Telekomunikasi</option>
                    <option value="S1 Teknik Elektro" {{ request('prodi') == 'S1 Teknik Elektro' ? 'selected' : '' }}>S1 Teknik Elektro</option>
                    <option value="S1 Teknik Biomedis" {{ request('prodi') == 'S1 Teknik Biomedis' ? 'selected' : '' }}>S1 Teknik Biomedis</option>
                    <option value="S1 Teknik Informatika" {{ request('prodi') == 'S1 Teknik Informatika' ? 'selected' : '' }}>S1 Teknik Informatika</option>
                    <option value="S1 Rekayasa Perangkat Lunak (Software Engineering)" {{ request('prodi') == 'S1 Rekayasa Perangkat Lunak (Software Engineering)' ? 'selected' : '' }}>S1 Rekayasa Perangkat Lunak</option>
                    <option value="S1 Sains Data" {{ request('prodi') == 'S1 Sains Data' ? 'selected' : '' }}>S1 Sains Data</option>
                    <option value="S1 Teknik Industri" {{ request('prodi') == 'S1 Teknik Industri' ? 'selected' : '' }}>S1 Teknik Industri</option>
                    <option value="S1 Sistem Informasi" {{ request('prodi') == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                    <option value="S1 Teknik Logistik" {{ request('prodi') == 'S1 Teknik Logistik' ? 'selected' : '' }}>S1 Teknik Logistik</option>
                    <option value="S1 Teknologi Pangan" {{ request('prodi') == 'S1 Teknologi Pangan' ? 'selected' : '' }}>S1 Teknologi Pangan</option>
                    <option value="S1 Desain Komunikasi Visual" {{ request('prodi') == 'S1 Desain Komunikasi Visual' ? 'selected' : '' }}>S1 Desain Komunikasi Visual</option>
                    <option value="S1 Desain Produk" {{ request('prodi') == 'S1 Desain Produk' ? 'selected' : '' }}>S1 Desain Produk</option>
                    <option value="S1 Bisnis Digital" {{ request('prodi') == 'S1 Bisnis Digital' ? 'selected' : '' }}>S1 Bisnis Digital</option>
                    <option value="D3 Teknik Telekomunikasi" {{ request('prodi') == 'D3 Teknik Telekomunikasi' ? 'selected' : '' }}>D3 Teknik Telekomunikasi</option>
                </select>

            </div>
        </div>

        <!-- EVENTS -->
        <div id="events-container" style="position: relative; min-height: 300px;">
            <!-- Loading Overlay -->
            <div id="loading-overlay" style="display: none; position: absolute; inset: 0; background: rgba(248, 249, 250, 0.7); z-index: 50; justify-content: center; align-items: flex-start; padding-top: 60px; border-radius: 12px; backdrop-filter: blur(2px);">
                <div style="width: 40px; height: 40px; border: 4px solid #E5E7EB; border-top: 4px solid #C02428; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
            
            <div id="events-content" style="transition: opacity 0.2s;">
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
                        Event Tersedia
                    </h2>

                    <span style="color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
                        ({{ count($events) }} event)
                    </span>
                </div>

                @if(count($events) > 0)

                    <div class="events-grid">
                        @foreach ($events as $event)
                            @include('components.event-card', ['event' => $event])
                        @endforeach
                    </div>

                @else

                    <!-- EMPTY STATE -->
                    <div class="empty-state">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 16px;">
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
                        <p class="text-muted" style="color: var(--text-muted); font-size: 0.95rem;">
                            Event yang tersedia akan muncul di sini
                        </p>
                    </div>

                @endif
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    @include('components.footer')

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchForm = document.getElementById('searchForm');
            var filterSelects = document.querySelectorAll('.filter-select');
            var loadingOverlay = document.getElementById('loading-overlay');
            var eventsContent = document.getElementById('events-content');
            var searchInput = document.querySelector('.search-input');

            function fetchEvents(e) {
                if(e) e.preventDefault();
                
                // Tampilkan loading
                loadingOverlay.style.display = 'flex';
                eventsContent.style.opacity = '0.5';

                // Ambil data form
                var formData = new FormData(searchForm);
                var params = new URLSearchParams(formData);
                
                // Pastikan input search masuk ke parameter
                if (searchInput && searchInput.value) {
                    params.set('search', searchInput.value);
                }

                var url = searchForm.action + '?' + params.toString();

                // Update URL di browser tanpa reload (biar bisa di-copy/share)
                window.history.pushState({}, '', url);

                // Lakukan AJAX request
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(html, 'text/html');
                        
                        // Ambil inner HTML dari #events-content hasil fetch
                        var newContent = doc.getElementById('events-content');
                        
                        if(newContent) {
                            eventsContent.innerHTML = newContent.innerHTML;
                        }
                        
                        // Sembunyikan loading
                        loadingOverlay.style.display = 'none';
                        eventsContent.style.opacity = '1';
                    })
                    .catch(err => {
                        console.error('Gagal mengambil data:', err);
                        loadingOverlay.style.display = 'none';
                        eventsContent.style.opacity = '1';
                    });
            }

            // Saat filter dropdown berubah
            filterSelects.forEach(function(select) {
                select.addEventListener('change', fetchEvents);
            });
            
            // Saat user menekan Enter di form pencarian
            searchForm.addEventListener('submit', fetchEvents);
            
            // Tangkap enter key di input search manually karena form di luar
            if(searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        fetchEvents();
                    }
                });
            }
        });
    </script>
</body>

</html>