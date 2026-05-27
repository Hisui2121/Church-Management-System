<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ isset($title) ? $title . ' - ChurchMS' : 'ChurchMS' }}
    </title>

    {{-- FONTS --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   

</head>

<body>
    <div class="app-layout">

        {{-- SIDEBAR --}}
        @auth
        <aside class="sidebar">

            <div class="sidebar-top">

                <div class="logo">
                    <span class="logo-text">
                        he
                    </span>
                </div>

                <nav class="sidebar-menu">

                    {{-- DASHBOARD --}}
                    <a
                        href="/dashboard"
                        class="{{ request()->is('dashboard') ? 'active' : '' }}"
                    >
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>

                    {{-- MEMBERS --}}
                    <a
                        href="{{ route('members.index') }}"
                        class="{{ request()->is('members*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-people-fill"></i>
                        <span>Members</span>
                    </a>

                    {{-- MINISTRIES --}}
                    <a
                        href="#"
                        class="{{ request()->is('ministries*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-heart-fill"></i>
                        <span>Ministry</span>
                    </a>

                    {{-- EVENTS --}}
                    <a
                        href="#"
                        class="{{ request()->is('events*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Events</span>
                    </a>

                    {{-- ANNOUNCEMENTS --}}
                    <a
                        href="#"
                        class="{{ request()->is('announcements*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-megaphone-fill"></i>
                        <span>News</span>
                    </a>

                    {{-- SETTINGS --}}
                    <a
                        href="#"
                        class="{{ request()->is('settings*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
                    </a>

                </nav>

            </div>

            <div class="sidebar-bottom">
                ✨
            </div>

        </aside>
        @endauth

        {{-- MAIN CONTENT --}}
        <div class="main-wrapper">

            {{-- HEADER --}}
            @auth
            <header class="dashboard-header">

                <div>

                    <h1>heroes</h1>

                    <p>
                        Church Management Dashboard
                    </p>

                </div>

                <div class="header-actions">

                    <span class="dark-label">
                        DARK MODE
                    </span>

                    <button class="header-btn">
                        <i class="bi bi-moon-fill"></i>
                    </button>

                    <button class="header-btn">
                        <i class="bi bi-bell-fill"></i>
                    </button>

                    <button class="header-btn">
                        <i class="bi bi-person-fill"></i>
                    </button>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="logout-btn">
                            Logout
                        </button>

                    </form>

                </div>

            </header>
            @endauth

            {{-- PAGE CONTENT --}}
            
            <main class="page-content">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <footer class="footer">

                <p>
                    © 2026 ChurchMS —
                    Heroes Church Membership Information Management System
                </p>

            </footer>

        </div>

    </div>

</body>
</html>