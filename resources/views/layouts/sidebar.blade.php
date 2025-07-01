<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Menu</li>

                {{-- Dashboard --}}
                @role('admin')
                <li><a href="{{ url('/admin') }}"><i class="bx bx-home-circle"></i><span>Dashboard Admin</span></a></li>
                @endrole

                @role('dosen')
                <li><a href="{{ url('/dosen') }}"><i class="bx bx-home"></i><span>Dashboard Dosen</span></a></li>
                @endrole

                {{-- Manajemen Data --}}
                <li class="menu-title">Manajemen Data</li>

                {{-- Kampus --}}
                @role('admin')
                <li><a href="{{ route('kampus.index') }}"><i class="bx bx-building"></i><span>Kampus</span></a></li>
                @endrole

                {{-- Mahasiswa (admin dan dosen) --}}
                @hasanyrole('admin|dosen')
                <li><a href="{{ route('mahasiswa.index') }}"><i class="bx bx-user"></i><span>Mahasiswa</span></a></li>
                @endhasanyrole

                {{-- Jenis Program --}}
                @role('admin')
                <li><a href="{{ route('jenis-program.index') }}"><i class="bx bx-clipboard"></i><span>Jenis Program</span></a></li>
                @endrole

                {{-- Tambah Dosen --}}
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dosen.index') }}">
                            <i class="bx bx-user"></i> <span>Dosen</span>
                        </a>
                    </li>
                @endif

                {{-- Pengajuan --}}
                @role('dosen')
                    {{-- <li class="menu-title">Manajemen</li>
                    <li>
                        <a href="{{ route('dosen.pengajuan.index') }}" class="waves-effect">
                            <i class="bx bx-send"></i>
                            <span>Pengajuan</span>
                        </a>
                    </li> --}}
                    <li class="menu-title">Dosen</li>
                    <li class="{{ request()->routeIs('dosen.pengajuan.index') ? 'active' : '' }}">
                        <a href="{{ route('dosen.pengajuan.index') }}">
                            <i class="mdi mdi-file-document"></i>
                            <span>Pengajuan</span>
                        </a>
                    </li>
                @endrole
                @role('admin')
                    <li class="menu-title">Manajemen</li>

                    <li class="{{ request()->routeIs('admin.pengajuan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengajuan.index') }}">
                        <i class="mdi mdi-clipboard-list"></i> <span>Pengajuan Masuk</span>
                    </a>
                    </li>
                    <li class="menu-title">Admin</li>
                    <li class="{{ request()->routeIs('admin.pengajuan.verifikasi.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.pengajuan.verifikasi.index') }}">
                            <i class="mdi mdi-file-check"></i>
                            <span>Verifikasi Berkas</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
    </div>
</div>
