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
            <li class="{{ request()->routeIs('tanggapan') ? 'active' : '' }}">
                <a href="{{ route('tanggapan') }}" class="menu-link"><i class="fas fa-comments"></i>Tanggapan</a>
            </li>
            <li class="{{ request()->routeIs('laporan') ? 'active' : '' }}">
                <a href="{{ route('laporan') }}" class="menu-link"><i class="fas fa-chart-bar"></i>Laporan</a>
            </li>
            <li class="{{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                <a href="{{ route('pengaturan') }}" class="menu-link"><i class="fas fa-cog"></i>Pengaturan</a>
            </li>
        </ul>
    </div>

    <button class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
        Log Out
    </button>
</aside>
