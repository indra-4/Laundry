<a href="{{ route('kurir.dashboard') }}" class="nav-link {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<a href="{{ route('kurir.penjemputan.index') }}" class="nav-link {{ request()->routeIs('kurir.penjemputan.*') ? 'active' : '' }}">
    <i class="bi bi-box-arrow-in-down"></i> Penjemputan
</a>
<a href="{{ route('kurir.pengantaran.index') }}" class="nav-link {{ request()->routeIs('kurir.pengantaran.*') ? 'active' : '' }}">
    <i class="bi bi-box-arrow-up"></i> Pengantaran
</a>
<a href="{{ route('kurir.chat.index') }}" class="nav-link {{ request()->routeIs('kurir.chat.*') ? 'active' : '' }}">
    <i class="bi bi-chat-dots"></i> Chat
</a>