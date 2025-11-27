<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs(['superadmin.pendeta.index', 'superadmin.pendeta.create', 'superadmin.pendeta.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#pendeta-menu" aria-expanded="{{ request()->routeIs(['superadmin.pendeta.index', 'superadmin.pendeta.create', 'superadmin.pendeta.edit']) ? 'true' : 'false' }}" aria-controls="pendeta-menu">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Pendeta</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['superadmin.pendeta.index', 'superadmin.pendeta.create', 'superadmin.pendeta.edit']) ? 'show' : '' }}" id="pendeta-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.pendeta.index') ? 'active' : '' }}" href="{{ route('superadmin.pendeta.index') }}">Daftar Pendeta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.pendeta.create') ? 'active' : '' }}" href="{{ route('superadmin.pendeta.create') }}">Tambah Pendeta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.pendeta.transfer.form') ? 'active' : '' }}" href="{{ route('superadmin.pendeta.transfer.form') }}">Perpindahan Pendeta</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['superadmin.departemen.index', 'superadmin.departemen.create', 'superadmin.departemen.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#departemen-menu" aria-expanded="{{ request()->routeIs(['superadmin.departemen.index', 'superadmin.departemen.create', 'superadmin.departemen.edit']) ? 'true' : 'false' }}" aria-controls="departemen-menu">
                <i class="icon-grid-2 menu-icon"></i>
                <span class="menu-title">Departemen</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['superadmin.departemen.index', 'superadmin.departemen.create', 'superadmin.departemen.edit']) ? 'show' : '' }}" id="departemen-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.departemen.index') ? 'active' : '' }}" href="{{ route('superadmin.departemen.index') }}">Daftar Departemen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.departemen.create') ? 'active' : '' }}" href="{{ route('superadmin.departemen.create') }}">Tambah Departemen</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['superadmin.region.index', 'superadmin.region.create', 'superadmin.region.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#region-menu" aria-expanded="{{ request()->routeIs(['superadmin.region.index', 'superadmin.region.create', 'superadmin.region.edit']) ? 'true' : 'false' }}" aria-controls="region-menu">
                <i class="icon-location menu-icon"></i>
                <span class="menu-title">Region</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['superadmin.region.index', 'superadmin.region.create', 'superadmin.region.edit']) ? 'show' : '' }}" id="region-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.region.index') ? 'active' : '' }}" href="{{ route('superadmin.region.index') }}">Daftar Region</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.region.create') ? 'active' : '' }}" href="{{ route('superadmin.region.create') }}">Tambah Region</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ request()->routeIs(['superadmin.permohonan_perpindahan.index', 'superadmin.permohonan_perpindahan.create', 'superadmin.permohonan_perpindahan.edit']) ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#permohonan-menu" aria-expanded="{{ request()->routeIs(['superadmin.permohonan_perpindahan.index', 'superadmin.permohonan_perpindahan.create', 'superadmin.permohonan_perpindahan.edit']) ? 'true' : 'false' }}" aria-controls="permohonan-menu">
                <i class="mdi mdi-map-marker menu-icon"></i>
                <span class="menu-title">Perpindahan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs(['superadmin.permohonan_perpindahan.index', 'superadmin.permohonan_perpindahan.create', 'superadmin.permohonan_perpindahan.edit']) ? 'show' : '' }}" id="permohonan-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.permohonan_perpindahan.index') ? 'active' : '' }}" href="{{ route('superadmin.permohonan_perpindahan.index') }}">Daftar Perpindahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.permohonan_perpindahan.create') ? 'active' : '' }}" href="{{ route('superadmin.permohonan_perpindahan.create') }}">Tambah Perpindahan</a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- Menu Laporan Baru -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('superadmin.laporan.index') }}">
                <i class="mdi mdi-file-document menu-icon"></i>
                <span class="menu-title">Laporan</span>
            </a>
        </li>
    </ul>
</nav>
