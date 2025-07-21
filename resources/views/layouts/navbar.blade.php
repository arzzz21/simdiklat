<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            {{-- ✅ Logo Box --}}
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="17">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/simdik-sm.png') }}" alt="Logo" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/simdik-light.png') }}" alt="Logo" height="30">
                    </span>
                </a>
            </div>

            {{-- ☰ Toggle Sidebar --}}
            <button type="button" class="btn btn-sm font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            {{-- Halo Nama --}}
            <h5 class="mb-0 ms-3">Halo, {{ auth()->user()->name }}</h5>
        </div>

        <div class="d-flex">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bx bx-power-off me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>
