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
        body {
            background: #F9FAFB;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #111827;
            display: flex;
            flex-direction: row;
            height: 100vh;
            overflow: hidden; /* Mencegah scroll di body */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px; /* Sedikit dilebarkan agar lebih profesional */
            background: #1c1515; /* Dark reddish-brown base */
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            border-right: 1px solid #2d2424;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 20px;
            border-bottom: 1px solid #2d2424;
            height: 80px;
            box-sizing: border-box;
        }

        .sidebar-brand-icon {
            background: #DC2626; /* TelU Red */
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .sidebar-brand-text h1 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            letter-spacing: 0.5px;
        }

        .sidebar-brand-text p {
            margin: 2px 0 0 0;
            font-size: 0.7rem;
            color: #9CA3AF;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 24px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #9CA3AF;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item.active {
            background: #DC2626; /* TelU Red */
            color: white;
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #2d2424;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #9CA3AF;
            text-decoration: none;
            font-size: 0.95rem;
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
            min-width: 0; /* Important for flex children to not overflow */
            height: 100vh;
        }

        .top-navbar {
            display: flex;
            justify-content: flex-end; /* Logout on the right */
            align-items: center;
            padding: 0 40px;
            background: white;
            border-bottom: 1px solid #E5E7EB;
            height: 80px; /* Align with sidebar brand height */
            min-height: 80px;
            box-sizing: border-box;
            flex-shrink: 0;
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
            cursor: pointer;
        }

        .btn-outline-nav:hover {
            background: #F9FAFB;
        }

        .main-content {
            padding: 32px 40px;
            overflow-y: auto;
            flex: 1;
            background: #F9FAFB;
        }
        
        /* Global utility classes used across admin */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .page-title h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .page-title p {
            margin: 4px 0 0 0;
            color: #6B7280;
            font-size: 0.875rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #EF4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #DC2626;
        }

        .content-box {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

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

        /* Form styling from earlier */
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

        .search-input:focus {
            border-color: #D1D5DB;
            background: white;
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
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.events') }}" class="nav-item {{ request()->routeIs('admin.events') ? 'active' : '' }}">
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
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-outline-nav">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
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

    @stack('scripts')
</body>
</html>
