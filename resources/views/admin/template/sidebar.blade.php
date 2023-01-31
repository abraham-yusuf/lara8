<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" style="background-color: skyblue;"
            href="/">
            <div class="sidebar-brand-text mx-2 ">MMTop Bakery</div>
        </a>
        <li class="nav-item p-2" style="font-size: 15px">
            <center><b>
                    <p style="font-size: 12px">{{ auth()->user()->role }}</p>
                </b></center>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('home') ? 'text-primary' : '' }}" href="/home">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        {{-- @if (auth()->user()->role === 'super-admin')

        @endif --}}
        <hr class="sidebar-divider">

        @if (auth()->user()->role == 'manager')
            <li class="nav-item {{ request()->is('user') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('user') ? 'text-primary' : '' }}" href="/user">
                    <i class="fas fa-users"></i>
                    <span>Data Pengguna</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif
        @if (auth()->user()->role == 'gudang' || auth()->user()->role == 'manager')
            <li class="nav-item {{ request()->is('barang') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('barang') ? 'text-primary' : '' }}" href="/barang">
                    <i class="fas fa-pills"></i>
                    <span>Barang</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif

        @if (auth()->user()->role == 'gudang')
            <li class="nav-item {{ request()->is('satuan') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('satuan') ? 'text-primary' : '' }}" href="/satuan">
                    <i class="fas fa-sitemap"></i>
                    <span>Satuan</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif

        {{-- menu customer --}}
        @if (auth()->user()->role == 'kasir' || auth()->user()->role == 'manager')
            <li class="nav-item {{ request()->is('customer') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('customer') ? 'text-primary' : '' }}" href="/customer">
                    <i class="fas fa-users"></i>
                    <span>Customer</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif
        @if (auth()->user()->role == 'gudang')
            <li class="nav-item {{ request()->is('supplier') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('supplier') ? 'text-primary' : '' }}" href="/supplier">
                    <i class="fas fa-truck"></i>
                    <span>Supplier</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif

        {{-- menu transaksi --}}
        @if (auth()->user()->role == 'gudang' ||
            auth()->user()->role == 'kasir' ||
            auth()->user()->role == 'administrasi' ||
            auth()->user()->role == 'manager')
            <li
                class="nav-item {{ request()->is('barang-masuk') ? 'active' : '' }}{{ request()->is('barang-keluar') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fas fa-cart-plus"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseBootstrap"
                    class="collapse {{ request()->is('barang-masuk') ? 'show' : '' }}{{ request()->is('order-barang') ? 'show' : '' }}"
                    aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @if (auth()->user()->role != 'kasir')
                            <a class="collapse-item {{ request()->is('barang-masuk') ? 'text-primary' : '' }}"
                                href="/barang-masuk">Barang Masuk</a>
                        @endif
                        @if (auth()->user()->role != 'gudang')
                            <a class="collapse-item {{ request()->is('order-barang') ? 'text-primary' : '' }}"
                                href="/order-barang">Order Barang</a>
                        @endif
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
        @endif
        {{-- menu report --}}
        <li class="nav-item {{ request()->is('report') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('report') ? 'text-primary' : '' }}" href="/report">
                <i class="fas fa-file-word"></i>
                <span>Report</span></a>
        </li>

        <hr class="sidebar-divider">

        {{-- @if (auth()->user()->role === 'sales')
            <hr class="sidebar-divider">

            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('order') ? 'text-primary' : '' }}"
                            href="/order">Tambah Order</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
        @endif

        @if (auth()->user()->role === 'administrasi')
            <hr class="sidebar-divider">
            <li class="nav-item {{ request()->is('order') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('order') ? 'text-primary' : '' }}" href="/order">
                    <i class="fas fa-sitemap"></i>
                    <span>Order</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('barang-masuk') ? 'text-primary' : '' }}"
                            href="/barang-masuk">Barang Masuk</a>
                        <a class="collapse-item {{ request()->is('barang-keluar') ? 'text-primary' : '' }}"
                            href="/barang-keluar">Barang Keluar</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item {{ request()->is('laporan') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('laporan') ? 'text-primary' : '' }}" href="/laporan">
                    <i class="fas fa-boxes"></i>
                    <span>laporan</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif

        @if (auth()->user()->role === 'gudang')
            <hr class="sidebar-divider">
            <li class="nav-item {{ request()->is('barang') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('barang') ? 'text-primary' : '' }}" href="/barang">
                    <i class="fas fa-sitemap"></i>
                    <span>Barang</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item {{ request()->is('order') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('order') ? 'text-primary' : '' }}" href="/order">
                    <i class="fas fa-sitemap"></i>
                    <span>Order</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('barang-keluar') ? 'text-primary' : '' }}"
                            href="/barang-keluar">Barang Keluar</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item {{ request()->is('laporan') ? 'active' : '' }}">
                <a class="nav-link {{ request()->is('laporan') ? 'text-primary' : '' }}" href="/laporan">
                    <i class="fas fa-boxes"></i>
                    <span>laporan</span></a>
            </li>
            <hr class="sidebar-divider">
        @endif --}}

        <div class="version" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- TopBar -->
            <nav style="background-color: skyblue;"
                class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto">


                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle"
                                src="{{ auth()->user()->avatar ? auth()->user()->avatar : 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png' }}"
                                style="max-width: 60px">
                            <span class="ml-2 d-none d-lg-inline text-white small">{{ auth()->user()->nama }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Topbar -->
