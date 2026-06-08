<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('home') }}" class="logo-container">
        <div class="logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 24 24" 
                 fill="none" 
                 stroke="currentColor"
                 stroke-width="2" 
                 stroke-linecap="round" 
                 stroke-linejoin="round">

                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                <path d="M6 12v5c3 3 9 3 12 0v-5" />
            </svg>
        </div>

        <div class="logo-text">
            TelU <span class="logo-events">Events</span>
        </div>
    </a>

    <!-- Hamburger Menu Toggle Button for Mobile -->
    <button class="menu-toggle" id="menuToggle" aria-label="Buka Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <ul class="nav-links">
        <li>
            <a href="{{ route('home') }}">Beranda</a>
        </li>

        <li>
            <a href="{{ route('about') }}">About Us</a>
        </li>

        <li>
            <a href="{{ route('contact') }}">Contact</a>
        </li>

        <li>
            <a href="{{ route('submit-event') }}">Submit Event</a>
        </li>
    </ul>
</nav>