<a href="{{ route('karyawan.dashboard') }}" class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<a href="{{ route('karyawan.pesanan.index') }}" class="nav-link {{ request()->routeIs('karyawan.pesanan.*') ? 'active' : '' }}">
    <i class="bi bi-inbox"></i> Kelola Pesanan
</a>
<a href="{{ route('karyawan.proses.index') }}" class="nav-link {{ request()->routeIs('karyawan.proses.*') ? 'active' : '' }}">
    <i class="bi bi-arrow-repeat"></i> Proses Laundry
</a>