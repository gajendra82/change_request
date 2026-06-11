@php
    $user = auth()->user();
@endphp
<aside class="crms-sidebar" id="crmsSidebar">
    <div class="crms-sidebar-brand">
        <div class="brand-icon">
            <i data-lucide="git-pull-request" style="width:20px;height:20px"></i>
        </div>
        <span class="brand-text">CRMS</span>
    </div>

    <nav class="crms-sidebar-nav">
        <div class="nav-section-title">Main Menu</div>

        <a href="{{ route('dashboard') }}" class="crms-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="nav-icon"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        @if($user->isClient())
            <a href="{{ route('change-requests.index') }}" class="crms-nav-item {{ request()->routeIs('change-requests.*') ? 'active' : '' }}">
                <i data-lucide="file-text" class="nav-icon"></i>
                <span class="nav-label">Change Requests</span>
            </a>
        @endif

        @if($user->isDeveloper())
            <a href="{{ route('timelines.index') }}" class="crms-nav-item {{ request()->routeIs('timelines.*') ? 'active' : '' }}">
                <i data-lucide="calendar-clock" class="nav-icon"></i>
                <span class="nav-label">Timelines</span>
            </a>
        @endif

        @if($user->isManager())
            <a href="{{ route('manager.timelines.index') }}" class="crms-nav-item {{ request()->routeIs('manager.timelines.*') ? 'active' : '' }}">
                <i data-lucide="check-circle" class="nav-icon"></i>
                <span class="nav-label">Timeline Approvals</span>
            </a>
        @endif

        <div class="nav-section-title mt-3">Workspace</div>

        <a href="#" class="crms-nav-item disabled" title="Coming soon">
            <i data-lucide="folder-kanban" class="nav-icon"></i>
            <span class="nav-label">Projects</span>
        </a>

        <a href="#" class="crms-nav-item disabled" title="Coming soon">
            <i data-lucide="bar-chart-3" class="nav-icon"></i>
            <span class="nav-label">Reports</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="crms-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i data-lucide="settings" class="nav-icon"></i>
            <span class="nav-label">Settings</span>
        </a>
    </nav>

    <div class="crms-sidebar-footer">
        <div class="d-flex align-items-center gap-2 px-2 sidebar-user-info">
            <div class="crms-user-avatar" style="width:32px;height:32px;font-size:0.75rem">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div style="overflow:hidden">
                <div class="small fw-semibold text-truncate">{{ $user->name }}</div>
                <span class="crms-badge badge-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
    </div>
</aside>
