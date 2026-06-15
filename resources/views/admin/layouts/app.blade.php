<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - TelU Events')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <style>
        :root {
            --telu-red: #c02428;
            --telu-red-hover: #a11e21;
            --slate-50: #F8FAFC;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-400: #94A3B8;
            --slate-500: #64748B;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1E293B;
            --slate-900: #0F172A;
            --slate-950: #0B0F19;
        }

        body {
            background: #F9FAFB;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #1F2937;
            display: flex;
            flex-direction: row;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 240px;
            background: var(--slate-950);
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            border-right: 1px solid #1E293B;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px;
            border-bottom: 1px solid #1E293B;
            height: 70px;
            box-sizing: border-box;
        }

        .sidebar-brand-icon {
            background: var(--telu-red);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .sidebar-brand-text h1 {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: white;
            letter-spacing: 0.5px;
        }

        .sidebar-brand-text p {
            margin: 0;
            font-size: 0.65rem;
            color: var(--slate-400);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: var(--slate-400);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.04);
        }

        .nav-item.active {
            background: var(--telu-red);
            color: white;
        }

        .nav-item i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid #1E293B;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--slate-400);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: white;
        }

        /* Main Content Styles */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            height: 100vh;
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
            background: white;
            border-bottom: 1px solid var(--slate-200);
            height: 70px;
            min-height: 70px;
            box-sizing: border-box;
            flex-shrink: 0;
        }

        /* Digital Clock */
        .digital-clock-container {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--slate-500);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .digital-clock-container i {
            color: var(--telu-red);
        }

        /* Profile Nav Section */
        .navbar-profile-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-profile-badge {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--slate-100);
            color: var(--telu-red);
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--slate-200);
        }

        .admin-info {
            display: flex;
            flex-direction: column;
        }

        .admin-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--slate-800);
            line-height: 1.2;
        }

        .admin-role {
            font-size: 0.7rem;
            color: var(--slate-500);
        }

        .btn-outline-nav {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border: 1px solid var(--slate-200);
            border-radius: 6px;
            color: var(--slate-600);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            background: white;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-outline-nav:hover {
            background: var(--slate-50);
            border-color: var(--slate-300);
            color: #111827;
        }

        .main-content {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
            background: #F9FAFB;
        }
        
        /* Global UI Elements */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title h2 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--slate-900);
        }

        .page-title p {
            margin: 4px 0 0 0;
            color: var(--slate-500);
            font-size: 0.85rem;
        }

        .content-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--slate-200);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .alert-success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;}
        .alert-error { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA;}

        /* Unified Form Controls */
        .search-form {
            position: relative;
        }

        .search-form i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            font-size: 0.9rem;
        }

        .search-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            box-sizing: border-box;
            background: var(--slate-50);
            color: var(--slate-800);
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: var(--slate-400);
            background: white;
            box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
        }

        /* Event Card Redesign styles */
        .admin-event-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
            display: flex;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .admin-event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: var(--slate-300);
        }

        .admin-event-card.completed {
            border-left: 4px solid var(--slate-400);
            background: #FAFAFA;
        }

        .event-poster {
            position: relative;
            width: 180px;
            min-height: 180px;
            background: var(--slate-100);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-right: 1px solid var(--slate-100);
        }

        .tak-badge-img {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--telu-red);
            color: white;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 0.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 3px;
            letter-spacing: 0.05em;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .event-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 16px 20px;
            box-sizing: border-box;
        }

        .event-badges {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .event-badges .badge {
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-category { background: var(--slate-50); color: var(--slate-600); border-color: var(--slate-200) !important; }
        .badge-type { background: #F0FDF4; color: #16A34A; border-color: #DCFCE7 !important; }
        .badge-prodi { background: #FEF2F2; color: var(--telu-red); border-color: #FEE2E2 !important; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .badge-status-pending { background: #FFFBEB; color: #D97706; border-color: #FDE68A !important; }
        .badge-status-approved { background: #ECFDF5; color: #10B981; border-color: #A7F3D0 !important; }
        .badge-status-rejected { background: #FEE2E2; color: #EF4444; border-color: #FCA5A5 !important; }
        .badge-completed { background: var(--slate-800); color: white; border-color: var(--slate-800) !important; }

        .event-title {
            margin: 0 0 8px 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--slate-900);
            line-height: 1.35;
            text-decoration: none;
            transition: color 0.15s;
        }

        .event-title:hover {
            color: var(--telu-red);
        }

        .event-details-row {
            display: flex;
            gap: 16px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--slate-500);
            font-size: 0.78rem;
        }

        .detail-item i {
            color: var(--slate-400);
            width: 12px;
        }

        .event-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--slate-100);
            width: 100%;
        }

        /* Admin Action Buttons */
        .admin-btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s;
            background: transparent;
        }

        .admin-btn-detail {
            background: var(--slate-100);
            color: var(--slate-600);
            border-color: var(--slate-200);
        }

        .admin-btn-detail:hover {
            background: var(--slate-200);
            color: var(--slate-800);
        }

        .admin-btn-approve {
            background: #10B981;
            color: white;
        }

        .admin-btn-approve:hover {
            background: #059669;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.15);
        }

        .admin-btn-reject {
            background: #F59E0B;
            color: white;
        }

        .admin-btn-reject:hover {
            background: #D97706;
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.15);
        }

        .admin-btn-delete {
            background: white;
            color: #EF4444;
            border-color: #FCA5A5;
        }

        .admin-btn-delete:hover {
            background: #FEF2F2;
            border-color: #EF4444;
        }

        /* Helper styles for stats-grid and others */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--slate-200);
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-color: var(--slate-300);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 0.72rem;
            color: var(--slate-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card p {
            margin: 4px 0 0 0;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--slate-800);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* Filter Tab Bar */
        .filter-container {
            display: inline-flex;
            background: var(--slate-100);
            padding: 4px;
            border-radius: 8px;
            gap: 2px;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .tab-badge {
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-weight: 700;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                T
            </div>
            <div class="sidebar-brand-text">
                <h1>Tel-U Admin</h1>
                <p>Event Console</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.events') }}" class="nav-item {{ request()->routeIs('admin.events') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Event Management</span>
            </a>
            <a href="{{ route('admin.calendar') }}" class="nav-item {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar"></i>
                <span>Calendar Event</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Site</span>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <!-- Digital Clock -->
            <div class="digital-clock-container">
                <i class="fa-regular fa-clock"></i>
                <span id="digital-clock">Loading...</span>
            </div>

            <!-- Profile and Logout -->
            <div class="navbar-profile-section">
                <div class="admin-profile-badge">
                    <div class="admin-avatar">A</div>
                    <div class="admin-info">
                        <span class="admin-name">Administrator</span>
                        <span class="admin-role">Main Officer</span>
                    </div>
                </div>
                
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-outline-nav">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
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

            @yield('content')
        </main>
    </div>

    <!-- Digital Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const dayName = days[now.getDay()];
            const date = String(now.getDate()).padStart(2, '0');
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('digital-clock').innerText = `${dayName}, ${date} ${monthName} ${year} - ${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    @stack('scripts')
</body>
</html>
