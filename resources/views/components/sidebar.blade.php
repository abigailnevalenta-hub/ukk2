<aside class="sidebar">
    <div class="logo">PSS</div>

    <div class="menu-section">
        <div class="menu-label">Main</div>
        <ul class="menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link"><i class="fas fa-home"></i>Dashboard</a>
            </li>

            <li class="{{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
                <a href="{{ route('pengaduan.index') }}" class="menu-link"><i class="fas fa-file-alt"></i>Data Pengaduan</a>
            </li>

            <li class="{{ request()->routeIs('menunggu') ? 'active' : '' }}">
                <a href="{{ route('menunggu') }}" class="menu-link"><i class="fas fa-clock"></i>Menunggu Proses</a>
            </li>

            <li class="{{ request()->routeIs('diperbaiki') ? 'active' : '' }}">
                <a href="{{ route('diperbaiki') }}" class="menu-link"><i class="fas fa-tools"></i>Diperbaiki</a>
            </li>

            <li class="{{ request()->routeIs('selesai') ? 'active' : '' }}">
                <a href="{{ route('selesai') }}" class="menu-link"><i class="fas fa-check-circle"></i>Selesai</a>
            </li>

            <li class="{{ request()->routeIs('kategori') ? 'active' : '' }}">
                <a href="{{ route('kategori') }}" class="menu-link"><i class="fas fa-tags"></i>Kategori</a>
            </li>

            <li class="{{ request()->routeIs('tanggapan') ? 'active' : '' }}">
                <a href="{{ route('tanggapan') }}" class="menu-link"><i class="fas fa-comments"></i>Tanggapan</a>
            </li>
           
        </ul>
    </div>

    <button class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
        Log Out
    </button>
</aside>
