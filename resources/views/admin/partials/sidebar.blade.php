<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-top">
        <div class="sidebar-brand" id="sidebarBrand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo-img" id="brandLogo">
        </div>

        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <nav class="admin-sidebar-menu" aria-label="Admin navigation">
        <div class="menu-section">
            <div class="section-label">MAIN MENU</div>

            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                <i class="bi bi-house-door-fill"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.members.index') }}" class="menu-item {{ request()->routeIs('admin.members.*') ? 'active' : '' }}" title="Members">
                <i class="bi bi-people-fill"></i>
                <span class="menu-text">Members</span>
            </a>

            <a href="{{ route('admin.ministries.index') }}" class="menu-item {{ request()->routeIs('admin.ministries.*') ? 'active' : '' }}" title="Ministries">
                <i class="bi bi-heart-fill"></i>
                <span class="menu-text">Ministries</span>
            </a>

            <a href="{{ route('admin.events.index') }}" class="menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" title="Events">
                <i class="bi bi-calendar-event-fill"></i>
                <span class="menu-text">Events</span>
            </a>

            @if(auth()->user()?->hasRole('Admin'))
                <a href="{{ route('admin.attendance.index') }}" class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" title="Attendance">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span class="menu-text">Attendance</span>
                </a>
            @endif

            <a href="{{ route('admin.announcements.index') }}" class="menu-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" title="Announcements">
                <i class="bi bi-megaphone-fill"></i>
                <span class="menu-text">Announcements</span>
            </a>

            <a href="{{ route('admin.banners.index') }}" class="menu-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" title="Banners">
                <i class="bi bi-image-fill"></i>
                <span class="menu-text">Banners</span>
            </a>
        </div>

        @if(auth()->user()?->hasRole('Admin'))
            <div class="menu-section">
                <div class="section-label">SYSTEM</div>

                <a href="{{ route('audit_logs.index') }}" class="menu-item {{ request()->routeIs('audit_logs.*') ? 'active' : '' }}" title="Audit Trail">
                    <i class="bi bi-journal-text"></i>
                    <span class="menu-text">Audit Trail</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="System Users">
                    <i class="bi bi-people-fill"></i>
                    <span class="menu-text">System Users</span>
                </a>

                <a href="{{ route('admin.permissions.index') }}" class="menu-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" title="Roles and Permissions">
                    <i class="bi bi-shield-check-fill"></i>
                    <span class="menu-text">Roles and Permissions</span>
                </a>
            </div>
        @endif
    </nav>

    <div class="sidebar-bottom">
        <div class="user-profile-mini">
            <div class="avatar-small bg-gray-300 flex items-center justify-center text-gray-600" style="width: 32px; height: 32px; border-radius: 50%;"><i class="bi bi-person"></i></div>
            <div class="user-info-mini">
                <div class="user-name-mini">{{ auth()->user()->name }}</div>
                <div class="user-role-mini">{{ auth()->user()->roles->first()?->name ?? 'User' }}</div>
            </div>
        </div>
    </div>
</aside>
