<div class="crms-topbar">
    <div class="crms-topbar-left">
        <button class="crms-topbar-btn" id="sidebarToggle" aria-label="Toggle sidebar">
            <i data-lucide="panel-left" style="width:20px;height:20px"></i>
        </button>
        @isset($header)
            <div class="d-none d-md-block">
                {{ $header }}
            </div>
        @endisset
    </div>

    <div class="crms-topbar-right">
        <button class="crms-topbar-btn" data-bs-toggle="dropdown" aria-label="Notifications">
            <i data-lucide="bell" style="width:20px;height:20px"></i>
            <span class="crms-notification-dot"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="width:280px">
            <li class="px-3 py-2 border-bottom">
                <strong class="small">Notifications</strong>
            </li>
            <li class="px-3 py-3 text-muted small">No new notifications</li>
        </ul>

        <div class="dropdown crms-user-dropdown">
            <button class="dropdown-toggle" data-bs-toggle="dropdown">
                <div class="crms-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="d-none d-sm-block">
                    <div class="crms-user-name">{{ Auth::user()->name }}</div>
                    <div class="crms-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <i data-lucide="chevron-down" style="width:16px;height:16px;color:#94A3B8"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                    <div class="text-muted small">{{ Auth::user()->email }}</div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i data-lucide="user" style="width:16px;height:16px" class="me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                        <i data-lucide="layout-dashboard" style="width:16px;height:16px" class="me-2"></i> Dashboard
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i data-lucide="log-out" style="width:16px;height:16px" class="me-2"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
