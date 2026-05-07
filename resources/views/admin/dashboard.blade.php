<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TelU Events</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #F9FAFB;
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: #111827;
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 48px;
            background: white;
            border-bottom: 1px solid #F3F4F6;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            background: #EF4444;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
        }

        .brand-text p {
            margin: 0;
            font-size: 0.75rem;
            color: #6B7280;
        }

        .btn-outline-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            background: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .btn-outline-nav:hover {
            background: #F9FAFB;
        }

        .main-container {
            width: calc(100% - 72px);
            margin: 48px auto;
        }
        
        .page-header {
            display: flex;
            justify-content: flex-start; /* Ganti ini agar elemen menempel ke kiri */
            align-items: center;
            gap: 24px;                  /* Tambahkan gap yang konsisten */
            margin-bottom: 32px;
        }

        .page-title h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .page-title {
            flex: 1;                     /* Ambil ruang yang tersisa, mendorong tombol ke kanan */
            margin: 0;                   /* Bersihkan margin */
        }

        .page-title p {
            margin: 4px 0 0 0;           /* Sesuaikan margin deskripsi */
            color: #6B7280;
            font-weight: 300;
            font-size: 0.875rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;                  /* Gap ikon dan teks lebih renggang */
            padding: 10px 24px;          /* Padding kanan-kiri lebih lebar, seperti contoh */
            background: #EF4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            width: fit-content;          /* Ukuran pas sesuai isi */
            flex-shrink: 0;              /* Jangan biarkan tombol memanjang */
            margin-left: auto;           /* Jaga tombol tetap di kanan setelah judul */
        }

        .btn-primary:hover {
            background: #DC2626;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
            width: 100%;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border: 1px solid #F3F4F6;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .stat-info h3 {
            margin: 0;
            font-size: 0.875rem;
            color: #6B7280;
            font-weight: 500;
        }

        .stat-info p {
            margin: 12px 0 0 0;
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .icon-red { background: #FEE2E2; color: #EF4444; }
        .icon-orange { background: #FFEDD5; color: #F59E0B; }
        .icon-green { background: #DCFCE7; color: #22C55E; }

        .content-box {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #F3F4F6;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .search-form {
            position: relative;
            margin-bottom: 24px;
        }

        .search-form i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
            box-sizing: border-box;
            background: #F9FAFB;
            color: #111827;
        }

        .search-input::placeholder {
            color: #9CA3AF;
        }

        .search-input:focus {
            border-color: #D1D5DB;
            background: white;
        }

        .filter-container {
            display: inline-flex;
            background: #F3F4F6;
            padding: 6px;
            border-radius: 999px;
            gap: 4px;
            margin-bottom: 32px;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            border: none;
            background: transparent;
            color: #4B5563;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: white;
            color: #111827;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .tab-count {
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .tab-btn:nth-child(1) .tab-count { background: #FEF3C7; color: #D97706; }
        .tab-btn:nth-child(2) .tab-count { background: #DCFCE7; color: #16A34A; }
        .tab-btn:nth-child(3) .tab-count { background: #FEE2E2; color: #DC2626; }

        .event-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .event-card {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: stretch;
            gap: 0; /* Gap handled by content padding */
            padding: 0; /* Remove padding so poster touches edges */
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            background: white;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            width: 100%;
            box-sizing: border-box;
            overflow: hidden; /* Ensure stretched poster respects card's rounded corners */
        }

        .event-poster {
            position: relative;
            width: 240px; /* Wider to proportion with full height */
            height: 100%;
            border-radius: 0; /* Handled by card's overflow: hidden */
            background: #F3F4F6;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-poster > i {
            font-size: 3rem;
            color: #9CA3AF;
        }

        .tak-badge-img {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #EF4444;
            color: white;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.05em;
        }

        .event-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 24px; /* Padding handles spacing evenly around the text */
        }

        .event-badges {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-gray { background: #F9FAFB; color: #374151; border: 1px solid #E5E7EB; }
        .badge-outline { background: white; color: #374151; border: 1px solid #E5E7EB; }
        .badge-pending { background: white; color: #F59E0B; border: 1px solid #F59E0B; }
        .badge-verified { background: white; color: #10B981; border: 1px solid #10B981; }
        .badge-rejected { background: white; color: #EF4444; border: 1px solid #EF4444; }

        .event-title {
            margin: 0 0 16px 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        .event-details-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            gap: 24px;
        }

        .event-details-col {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6B7280;
            font-size: 0.875rem;
        }

        .detail-item i {
            color: #9CA3AF;
            width: 16px;
        }

        .detail-category {
            font-size: 0.875rem;
            color: #6B7280;
            margin-top: 8px;
            margin-bottom: 15px;
        }

        .event-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid #E5E7EB;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
        }

        .btn-approve {
            background: #10B981;
            color: white;
        }
        .btn-reject {
            background: #EF4444;
            color: white;
        }
        .btn-edit {
            background: white;
            border: 1px solid #E5E7EB;
            color: #374151;
        }
        .btn-delete {
            background: transparent;
            color: #EF4444;
            margin-left: auto;
            padding: 8px;
        }

        form { margin: 0; }
        
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0;}
        .alert-error { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;}

    </style>
</head>

<body>
    <nav class="top-navbar">
        <div class="brand">
            <div class="brand-icon">
                <i class="fa-solid fa-border-all"></i>
            </div>
            <div class="brand-text">
                <h1>Admin Dashboard</h1>
                <p>TelU Events</p>
            </div>
        </div>
        <a href="{{ url('/') }}" class="btn-outline-nav">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Situs
        </a>
    </nav>

    <div class="main-container">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
        @endif

        <div class="page-header">
            <div class="page-title">
                <h2>Manajemen Event</h2>
                <p>Kelola, verifikasi, dan tolak permintaan event mahasiswa.</p>
            </div>
            <a href="{{ route('submit-event') }}" class="btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Event
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Event</h3>
                    <p>{{ $totalEvents }}</p>
                </div>
                <div class="stat-icon icon-red">
                    <i class="fa-solid fa-border-all"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Menunggu Verifikasi</h3>
                    <p>{{ $pendingEvents }}</p>
                </div>
                <div class="stat-icon icon-orange">
                    <i class="fa-regular fa-clock"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Terverifikasi</h3>
                    <p>{{ $verifiedEvents }}</p>
                </div>
                <div class="stat-icon icon-green">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Ditolak</h3>
                    <p>{{ $rejectedEvents }}</p>
                </div>
                <div class="stat-icon icon-red">
                    <i class="fa-regular fa-circle-xmark"></i>
                </div>
            </div>
        </div>

        <div class="content-box">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="search-form">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan judul, penyelenggara, lokasi..." value="{{ request('search') }}">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
            </form>

            <div class="filter-container">
                <a href="{{ route('admin.dashboard', ['status' => 'pending', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'pending' || !request('status') ? 'active' : '' }}">
                    <i class="fa-regular fa-clock"></i> Pending 
                    <span class="tab-count">{{ $pendingEvents }}</span>
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'approved', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'approved' ? 'active' : '' }}">
                    <i class="fa-regular fa-circle-check"></i> Verified 
                    <span class="tab-count">{{ $verifiedEvents }}</span>
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'rejected', 'search' => request('search')]) }}" class="tab-btn {{ request('status') == 'rejected' ? 'active' : '' }}">
                    <i class="fa-regular fa-circle-xmark"></i> Rejected 
                    <span class="tab-count">{{ $rejectedEvents }}</span>
                </a>
            </div>

            <div class="event-list">
                @forelse($events as $event)
                <div class="event-card">
                    <div class="event-poster">
                        @if($event->is_tak)
                        <div class="tak-badge-img">
                            <i class="fa-solid fa-bolt" style="font-size: 0.6rem;"></i> TAK
                        </div>
                        @endif

                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                        @else
                            <i class="fa-regular fa-calendar"></i>
                        @endif
                    </div>

                    <div class="event-content">
                        <div class="event-badges">
                            <span class="badge badge-gray">{{ ucfirst($event->category) }}</span>
                            <span class="badge badge-outline">{{ ucfirst($event->event_type) }}</span>
                            
                            @if($event->status == 'pending')
                                <span class="badge badge-pending"><i class="fa-regular fa-clock"></i> Pending</span>
                            @elseif($event->status == 'approved')
                                <span class="badge badge-verified"><i class="fa-regular fa-circle-check"></i> Verified</span>
                            @else
                                <span class="badge badge-rejected"><i class="fa-regular fa-circle-xmark"></i> Rejected</span>
                            @endif
                        </div>

                        <h3 class="event-title">{{ $event->title }}</h3>

                        <div class="event-details-row">
                            <div class="event-details-col">
                                <div class="detail-item">
                                    <i class="fa-regular fa-user"></i>
                                    {{ $event->organizer_name }}
                                </div>
                                <div class="detail-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $event->location }}
                                </div>
                            </div>
                            <div class="event-details-col">
                                <div class="detail-item">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y - H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="detail-category">{{ $event->category }}</div>

                        <div class="event-actions">
                            @if($event->status != 'approved')
                            <form action="{{ route('admin.event.approve', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action btn-approve">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>
                            @endif

                            @if($event->status != 'rejected')
                            <form action="{{ route('admin.event.reject', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action btn-reject">
                                    <i class="fa-solid fa-xmark"></i> Reject
                                </button>
                            </form>
                            @endif

                            <a href="#" class="btn-action btn-edit">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>

                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="margin-left: auto;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px; color: #6B7280;">
                    <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 16px; color: #D1D5DB;"></i>
                    <p>Tidak ada event yang ditemukan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
