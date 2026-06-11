<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-arrow-repeat me-1"></i> CRMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                @if(auth()->user()->isClient())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('change-requests.*') ? 'active' : '' }}" href="{{ route('change-requests.index') }}">
                            <i class="bi bi-file-earmark-text me-1"></i> My Change Requests
                        </a>
                    </li>
                @endif
                @if(auth()->user()->isDeveloper())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('timelines.*') ? 'active' : '' }}" href="{{ route('timelines.index') }}">
                            <i class="bi bi-calendar-range me-1"></i> Timelines
                        </a>
                    </li>
                @endif
                @if(auth()->user()->isManager())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manager.timelines.*') ? 'active' : '' }}" href="{{ route('manager.timelines.index') }}">
                            <i class="bi bi-check2-square me-1"></i> Review Timelines
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        <span class="badge {{ Auth::user()->role_badge_class }} ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
