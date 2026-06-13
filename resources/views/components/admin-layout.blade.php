<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ isset($title) ? $title . ' - Church Admin' : 'Church Admin' }}
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
    <link rel="stylesheet" href="{{ asset('css/admin/tables.css') }}">
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
        @include('admin.partials.sidebar')

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
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode(auth()->user()->name) }}" alt="Avatar" class="avatar">
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
                <p>© 2026 Church Management System - Admin Dashboard</p>
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
