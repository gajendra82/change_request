<div class="crms-topbar">
    <div class="crms-topbar-left">
        <button class="crms-topbar-btn" id="sidebarToggle" aria-label="Toggle sidebar">
            <i data-lucide="panel-left" style="width:20px;height:20px"></i>
        </button>
        <form action="{{ route('admin.users.index') }}" method="GET" class="d-none d-md-flex">
            <div class="crms-search-input" style="min-width:280px">
                <i data-lucide="search" class="search-icon"></i>
                <input type="text" name="search" class="form-control" placeholder="Global search users..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="crms-topbar-right">
        <div class="dropdown crms-user-dropdown">
            <button class="dropdown-toggle" data-bs-toggle="dropdown">
                <div class="crms-user-avatar">{{ auth()->user()->initials }}</div>
                <div class="d-none d-sm-block">
                    <div class="crms-user-name">{{ auth()->user()->name }}</div>
                    <div class="crms-user-role">Administrator</div>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
