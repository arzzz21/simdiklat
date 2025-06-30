<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                @role('admin')
                <li><a href="{{ url('/admin') }}"><i class="bx bx-home-circle"></i><span>Dashboard Admin</span></a></li>
                <li><a href="{{ url('/admin/users') }}"><i class="bx bx-user"></i><span>Manajemen User</span></a></li>
                @endrole

                @role('dosen')
                <li><a href="{{ url('/dosen') }}"><i class="bx bx-home"></i><span>Dashboard Dosen</span></a></li>
                <li><a href="{{ url('/dosen/pengajuan') }}"><i class="bx bx-file"></i><span>Pengajuan PKL</span></a></li>
                @endrole
            </ul>
        </div>
    </div>
</div>
