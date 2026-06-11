@php $user = auth()->user(); @endphp
<aside class="crms-sidebar admin-sidebar" id="crmsSidebar">
    <div class="crms-sidebar-brand">
        <div class="brand-icon">
            <i data-lucide="shield" style="width:20px;height:20px"></i>
        </div>
        <span class="brand-text">CRMS Admin</span>
    </div>

    <nav class="crms-sidebar-nav">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="crms-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="nav-icon"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        <div class="nav-section-title mt-3">User Management</div>
        <a href="{{ route('admin.clients.index') }}" class="crms-nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
            <i data-lucide="building-2" class="nav-icon"></i>
            <span class="nav-label">Clients</span>
        </a>
        <div class="admin-submenu">
            <a href="{{ route('admin.client-users.index') }}" class="crms-nav-item {{ request()->routeIs('admin.client-users.*') ? 'active' : '' }}">
                <span class="nav-label">Client Users</span>
            </a>
            <a href="{{ route('admin.developers.index') }}" class="crms-nav-item {{ request()->routeIs('admin.developers.*') ? 'active' : '' }}">
                <span class="nav-label">Developers</span>
            </a>
            <a href="{{ route('admin.managers.index') }}" class="crms-nav-item {{ request()->routeIs('admin.managers.*') ? 'active' : '' }}">
                <span class="nav-label">Managers</span>
            </a>
        </div>
        <a href="{{ route('admin.users.index') }}" class="crms-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i data-lucide="users" class="nav-icon"></i>
            <span class="nav-label">All Users</span>
        </a>

        <div class="nav-section-title mt-3">Operations</div>
        <a href="{{ route('admin.projects.index') }}" class="crms-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i data-lucide="folder-kanban" class="nav-icon"></i>
            <span class="nav-label">Projects</span>
        </a>
        <a href="{{ route('admin.change-requests.index') }}" class="crms-nav-item {{ request()->routeIs('admin.change-requests.*') ? 'active' : '' }}">
            <i data-lucide="file-text" class="nav-icon"></i>
            <span class="nav-label">Change Requests</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="crms-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i data-lucide="bar-chart-3" class="nav-icon"></i>
            <span class="nav-label">Reports</span>
        </a>

        <div class="nav-section-title mt-3">System</div>
        <a href="{{ route('admin.settings.index') }}" class="crms-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i data-lucide="settings" class="nav-icon"></i>
            <span class="nav-label">Settings</span>
        </a>
        <a href="{{ route('admin.activity-logs.index') }}" class="crms-nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i data-lucide="activity" class="nav-icon"></i>
            <span class="nav-label">Activity Logs</span>
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="crms-nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i data-lucide="user" class="nav-icon"></i>
            <span class="nav-label">Profile</span>
        </a>
    </nav>

    <div class="crms-sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="crms-nav-item w-100 border-0 bg-transparent">
                <i data-lucide="log-out" class="nav-icon"></i>
                <span class="nav-label">Logout</span>
            </button>
        </form>
    </div>
</aside>
