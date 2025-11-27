<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('departemen.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('departemen.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs(['departemen.pendeta.index', 'departemen.pendeta.create', 'departemen.pendeta.edit', 'departemen.pendeta.perlawatan', 'departemen.pendeta.penjadwalan']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#pendeta-menu" aria-expanded="{{ request()->routeIs(['departemen.pendeta.index', 'departemen.pendeta.create', 'departemen.pendeta.edit', 'departemen.pendeta.perlawatan', 'departemen.pendeta.penjadwalan']) ? 'true' : 'false' }}" aria-controls="pendeta-menu">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Pendeta</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['departemen.pendeta.index', 'departemen.pendeta.create', 'departemen.pendeta.edit', 'departemen.pendeta.perlawatan', 'departemen.pendeta.penjadwalan']) ? 'show' : '' }}" id="pendeta-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.pendeta.index') ? 'active' : '' }}" href="{{ route('departemen.pendeta.index') }}">Daftar Pendeta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.pendeta.create') ? 'active' : '' }}" href="{{ route('departemen.pendeta.create') }}">Tambah Pendeta</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['departemen.gereja.index', 'departemen.gereja.create', 'departemen.gereja.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#gereja-menu" aria-expanded="{{ request()->routeIs(['departemen.gereja.index', 'departemen.gereja.create', 'departemen.gereja.edit']) ? 'true' : 'false' }}" aria-controls="gereja-menu">
                <i class="icon-grid-2 menu-icon"></i>
                <span class="menu-title">Gereja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['departemen.gereja.index', 'departemen.gereja.create', 'departemen.gereja.edit']) ? 'show' : '' }}" id="gereja-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.gereja.index') ? 'active' : '' }}" href="{{ route('departemen.gereja.index') }}">Daftar Gereja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.gereja.create') ? 'active' : '' }}" href="{{ route('departemen.gereja.create') }}">Tambah Gereja</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['departemen.anggota.index', 'departemen.anggota.create', 'departemen.anggota.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#anggota-menu" aria-expanded="{{ request()->routeIs(['departemen.anggota.index', 'departemen.anggota.create', 'departemen.anggota.edit']) ? 'true' : 'false' }}" aria-controls="anggota-menu">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Anggota</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['departemen.anggota.index', 'departemen.anggota.create', 'departemen.anggota.edit']) ? 'show' : '' }}" id="anggota-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.anggota.index') ? 'active' : '' }}" href="{{ route('departemen.anggota.index') }}">Daftar Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.anggota.create') ? 'active' : '' }}" href="{{ route('departemen.anggota.create') }}">Tambah Anggota</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['departemen.permohonan_perpindahan.index', 'departemen.permohonan_perpindahan.create', 'departemen.permohonan_perpindahan.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#permohonan-menu" aria-expanded="{{ request()->routeIs(['departemen.permohonan_perpindahan.index', 'departemen.permohonan_perpindahan.create', 'departemen.permohonan_perpindahan.edit']) ? 'true' : 'false' }}" aria-controls="permohonan-menu">
                <i class="mdi mdi-map-marker menu-icon"></i>
                <span class="menu-title">Perpindahan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['departemen.permohonan_perpindahan.index', 'departemen.permohonan_perpindahan.create', 'departemen.permohonan_perpindahan.edit']) ? 'show' : '' }}" id="permohonan-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.permohonan_perpindahan.index') ? 'active' : '' }}" href="{{ route('departemen.permohonan_perpindahan.index') }}">Daftar Perpindahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departemen.permohonan_perpindahan.create') ? 'active' : '' }}" href="{{ route('departemen.permohonan_perpindahan.create') }}">Tambah Perpindahan</a>
                    </li>
                </ul>
            </div>
        </li>
         <!-- Menu Laporan Baru -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('departemen.laporan.index') }}">
                <i class="mdi mdi-file-document menu-icon"></i>
                <span class="menu-title">Laporan</span>
            </a>
        </li>
    </ul>
</nav>