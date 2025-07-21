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

                @role('pegawai')
                <li><a href="{{ url('/pegawai') }}"><i class="bx bx-home"></i><span>Dashboard Pegawai</span></a></li>
                @endrole

                @if(auth()->user()->pegawai?->jabatan?->is_manajer)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manajer.laporan.index') }}">
                            <i class="mdi mdi-check-circle"></i>
                            <span>Verifikasi Laporan</span>
                        </a>
                    </li>
                @endif

                @hasanyrole('admin|dosen')
                {{-- Manajemen Data --}}
                <li class="menu-title">Manajemen Data</li>
                @endhasanyrole

                {{-- Kampus --}}
                @role('admin')
                <li><a href="{{ route('kampus.index') }}"><i class="bx bx-building"></i><span>Kampus</span></a></li>
                <li><a href="{{ route('jenis-program.index') }}"><i class="bx bx-clipboard"></i><span>Jenis Program</span></a></li>
                @endrole

                {{-- Mahasiswa (admin dan dosen) --}}
                @hasanyrole('admin|dosen')
                <li><a href="{{ route('mahasiswa.index') }}"><i class="bx bx-user"></i><span>Mahasiswa</span></a></li>
                @endhasanyrole

                {{-- Tambah Dosen --}}
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dosen.index') }}">
                            <i class="bx bx-user"></i> <span>Dosen</span>
                        </a>
                    </li>
                @endif

                {{-- Data Pegawai --}}
                @role('admin')
                <li class="menu-title">Manajemen Pegawai</li>
                <li> <a href="{{ route('admin.unit.index') }}"> <i class="mdi mdi-office-building"></i> <span>Unit</span> </a> </li>
                <li> <a href="{{ route('admin.jabatan.index') }}"> <i class="mdi mdi-account-tie"></i> <span>Jabatan</span> </a> </li>
                <li> <a href="{{ route('admin.pegawai.index') }}"> <i class="mdi mdi-account-multiple"></i> <span>Pegawai</span> </a> </li>
                {{-- <li> <a href="{{ route('admin.pegawaiuser.create') }}"> <i class="mdi mdi-account-plus"></i> <span>Buat User Pegawai</span> </a> </li> --}}
                @endrole

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
                    <li class="menu-title">Manajemen Magang dan Pelatihan</li>

                    <li class="{{ request()->routeIs('admin.pengajuan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.pengajuan.index') }}">
                        <i class="mdi mdi-clipboard-list"></i> <span>Pengajuan Masuk</span>
                    </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.pengajuan.verifikasi.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.pengajuan.verifikasi.index') }}">
                            <i class="mdi mdi-file-check"></i>
                            <span>Verifikasi Berkas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.invoice.verifikasi.index') }}">
                            <i class="mdi mdi-credit-card"></i> <span>Verifikasi Pembayaran</span>
                        </a>
                    </li>
                @endrole

                @role('admin')
                    <li class="menu-title">Manajemen Pelatihan Pegawai</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pelatihan.index') }}" class="nav-link">
                            <i class="mdi mdi-teach"></i> {{-- ganti icon sesuai template kamu --}}
                            <span>Pelatihan Luar RS</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
    </div>
</div>
