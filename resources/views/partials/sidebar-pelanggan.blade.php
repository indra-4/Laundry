<a href="{{ route('pelanggan.dashboard') }}" class="nav-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<a href="{{ route('pelanggan.pesanan.create') }}" class="nav-link {{ request()->routeIs('pelanggan.pesanan.create') ? 'active' : '' }}">
    <i class="bi bi-plus-circle"></i> Buat Pesanan
</a>
<a href="{{ route('pelanggan.pesanan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.pesanan.*') && !request()->routeIs('pelanggan.pesanan.create') ? 'active' : '' }}">
    <i class="bi bi-list-ul"></i> Riwayat Pesanan
</a>
<a href="{{ route('pelanggan.chat.index') }}" class="nav-link {{ request()->routeIs('pelanggan.chat.*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots"></i> Chat
</a>