<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="nav-item">
        <a href="{{ route("dashboard") }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
    </li>
    <li class="menu-header">Manejemen Data Master</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file-alt"></i>
            <span>Data Master</span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link" href="{{ route("admin.users.index") }}">Pengguna</a>
            </li>

        </ul>
    </li>
    <li class="menu-header">Manajemen Laporan</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-file-alt"></i>
            <span>Laporan Transaksi</span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link" href="{{ route("paket-laundry.index") }}">Paket Laundry</a>
            </li>
            @if (Auth::user()->role == "staff")
                <li>
                    <a class="nav-link" href="{{ route("pesanan.index") }}">Pemesanan</a>
                </li>
            @endif
            <li>
                <a class="nav-link" href="">Data Kurir</a>
            </li>

        </ul>
    </li>x
