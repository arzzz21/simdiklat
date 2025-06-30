<header id="page-topbar">
    <div class="navbar-header d-flex justify-content-between px-3 align-items-center">
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <h5 class="mb-0 ms-2">Halo, {{ auth()->user()->name }}</h5>
        </div>
        <div>
            {{-- <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">Logout</a> --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 text-start">
                    <i class="bx bx-power-off me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>
