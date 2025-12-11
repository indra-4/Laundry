<a href="{{ route('pemilik.dashboard') }}" class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<a href="{{ route('pemilik.pesanan.index') }}" class="nav-link {{ request()->routeIs('pemilik.pesanan.*') ? 'active' : '' }}">
    <i class="bi bi-inbox"></i> Semua Pesanan
</a>
<a href="{{ route('pemilik.layanan.index') }}" class="nav-link {{ request()->routeIs('pemilik.layanan.*') ? 'active' : '' }}">
    <i class="bi bi-tags"></i> Kelola Layanan
</a>
<a href="{{ route('pemilik.karyawan.index') }}" class="nav-link {{ request()->routeIs('pemilik.karyawan.*') ? 'active' : '' }}">
    <i class="bi bi-people"></i> Kelola Karyawan
</a>
<a href="{{ route('pemilik.laporan.index') }}" class="nav-link {{ request()->routeIs('pemilik.laporan.*') ? 'active' : '' }}">
    <i class="bi bi-graph-up"></i> Laporan
</a>