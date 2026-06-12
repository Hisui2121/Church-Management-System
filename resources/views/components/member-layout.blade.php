<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ isset($title) ? $title . ' - Church Members' : 'Church Members' }}
    </title>

    {{-- FONTS --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    {{-- TAILWIND & CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- ADMIN CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/utilities.css') }}">

    <style>
        :root {
            --primary: #67b69e;
            --primary-dark: #5a9d87;
            --primary-light: #e8f5f0;
            --secondary: #2c3e50;
            --border: #ececec;
            --bg-light: #f5f7fb;
            --text-dark: #333;
            --text-muted: #7b8794;
            --success: #67b69e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Instrument Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }
    </style>
</head>

<body>
    <div class="admin-app-layout">
        {{-- SIDEBAR --}}
        <aside class="admin-sidebar" id="adminSidebar">
            {{-- SIDEBAR TOP --}}
            <div class="sidebar-top">
                {{-- LOGO/ICON --}}
                <div class="sidebar-brand" id="sidebarBrand">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo-img" id="brandLogo">
                </div>

                {{-- TOGGLE BUTTON --}}
                <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            {{-- NAVIGATION MENU --}}
            <nav class="admin-sidebar-menu">
                {{-- MAIN MENU --}}
                <div class="menu-section">
                    <div class="section-label">MAIN MENU</div>

                    <a href="{{ route('user.dashboard') }}" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>

                    @if (auth()->user()->hasPermission('view_members'))
                    <a href="{{ route('members.index') }}" class="menu-item {{ request()->is('members*') ? 'active' : '' }}" title="Members">
                        <i class="bi bi-people-fill"></i>
                        <span class="menu-text">Members</span>
                    </a>
                    @endif

                    @if (auth()->user()->hasPermission('view_ministries'))
                    <a href="{{ route('ministries.index') }}" class="menu-item {{ request()->is('admin/ministries*') ? 'active' : '' }}" title="Ministries">
                        <i class="bi bi-heart-fill"></i>
                        <span class="menu-text">Ministries</span>
                    </a>
                    @endif

                    @if (auth()->user()->hasPermission('view_events'))
                    <a href="{{ route('events.index') }}" class="menu-item {{ request()->is('events*') ? 'active' : '' }}" title="Events">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span class="menu-text">Events</span>
                    </a>
                    @endif

                    @if (auth()->user()->hasPermission('view_announcements'))
                    <a href="{{ route('announcements.index') }}" class="menu-item {{ request()->is('announcements*') ? 'active' : '' }}" title="Announcements">
                        <i class="bi bi-megaphone-fill"></i>
                        <span class="menu-text">Announcements</span>
                    </a>
                    @endif
                </div>

                {{-- SYSTEM MENU --}}
                <div class="menu-section">
                    <div class="section-label">SYSTEM</div>

                    @if (auth()->user()->hasPermission('view_audit_logs'))
                    <a href="{{ route('audit_logs.index') }}" class="menu-item {{ request()->is('audit_logs*') ? 'active' : '' }}" title="Audit Trail">
                        <i class="bi bi-journal-text"></i>
                        <span class="menu-text">Audit Trail</span>
                    </a>
                    @endif
                </div>
            </nav>

            {{-- SIDEBAR BOTTOM --}}
            <div class="sidebar-bottom">
                <div class="user-profile-mini">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->name }}" alt="Avatar" class="avatar-small">
                    <div class="user-info-mini">
                        <div class="user-name-mini">{{ auth()->user()->name }}</div>
                        <div class="user-role-mini">{{ auth()->user()->memberStatus?->name ?? 'Member' }}</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="admin-main-wrapper">
            {{-- TOP BAR --}}
            <header class="admin-top-bar">
                <div class="topbar-left">
                    <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <div class="topbar-right">
                    {{-- SEARCH --}}
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>

                    {{-- NOTIFICATIONS --}}
                    <button class="topbar-btn" title="Notifications">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    {{-- USER MENU --}}
                    <div class="user-menu">
                        <button class="user-menu-btn" id="userMenuBtn">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->name }}" alt="Avatar" class="avatar">
                            <span class="user-name-short">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </button>

                        <div class="user-menu-dropdown" id="userMenuDropdown">
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-person-fill"></i> Profile
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-gear-fill"></i> Settings
                            </a>
                            <hr class="dropdown-divider">
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="admin-page-content">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <footer class="admin-footer">
                <p>© 2026 Church Management System - Member Portal</p>
            </footer>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const toggle = document.getElementById('sidebarToggle');
            const brandLogo = document.getElementById('brandLogo');
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userMenuDropdown = document.getElementById('userMenuDropdown');

            // Sidebar Toggle
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                const icon = toggle.querySelector('i');
                icon.classList.toggle('bi-chevron-right');
                icon.classList.toggle('bi-chevron-left');

                if (sidebar.classList.contains('collapsed')) {
                    brandLogo.src = "{{ asset('assets/images/logo.png') }}";
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    brandLogo.src = "{{ asset('assets/images/logo.png') }}";
                    localStorage.setItem('sidebarCollapsed', 'false');
                }
            });

            // User Menu Toggle
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                userMenuDropdown.classList.remove('show');
            });

            // Restore sidebar state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                const icon = toggle.querySelector('i');
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
                brandLogo.src = "{{ asset('assets/images/logo.png') }}";
            }
        });
    </script>
</body>
</html>
