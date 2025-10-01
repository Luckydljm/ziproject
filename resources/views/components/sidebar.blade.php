<div class="header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <h3 class="text-primary">M-ESSENCE</h3>
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-small">
            <h3 class="text-primary">M-ESSENCE</h3>
        </a>
    </div>

    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">
        <!-- Zoom Screen -->
        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list">
                <img src="{{ asset('assets/img/icons/header-icon-04.svg') }}" alt="" />
            </a>
        </li>

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle"
                        src="{{ Auth::user()->detail->foto_url ?? asset('assets/img/profiles/user.png') }}"
                        width="31" alt="{{ Auth::user()->detail->nama ?? Auth::user()->username }}" />

                    <div class="user-text">
                        <h6>{{ Auth::user()->detail->nama ?? Auth::user()->username }}</h6>
                        <p class="text-muted mb-0">{{ Auth::user()->role }}</p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ Auth::user()->detail->foto_url ?? asset('assets/img/profiles/user.png') }}"
                            alt="User Image" class="avatar-img rounded-circle" />
                    </div>
                    <div class="user-text">
                        <h6>{{ Auth::user()->detail->nama ?? Auth::user()->username }}</h6>
                        <p class="text-muted mb-0">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </div>
        </li>
    </ul>

</div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                {{-- Dashboard --}}
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="feather-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Menu untuk Frontliner --}}
                @if (Auth::user()->role === 'Frontliner')
                    <li class="{{ Request::is('moment/create') ? 'active' : '' }}">
                        <a href="{{ route('moment.create') }}">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Moment</span>
                        </a>
                    </li>
                @endif

                {{-- Histori Moment --}}
                <li class="{{ Request::is('histori') ? 'active' : '' }}">
                    <a href="{{ route('moment.histori') }}">
                        <i class="feather-list"></i>
                        <span>Histori</span>
                    </a>
                </li>

                {{-- Menu untuk Kepala Cabang --}}
                @if (Auth::user()->role === 'Kepala Cabang')
                    <li class="{{ Request::is('data-pengguna*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Data Pengguna</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'Frontliner')
                    <li class="{{ Request::is('reminder') ? 'active' : '' }}">
                        <a href="{{ route('reminder.index') }}"><i class="fas fa-calendar-alt"></i> <span>Jadwal
                                Nasabah</span></a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
