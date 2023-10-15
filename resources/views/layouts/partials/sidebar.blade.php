<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info ">
                <a href="/" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <!-- Owner sidebar -->
                @if(Auth::user()->position == 'owner')
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user-group"></i>
                        <p>
                            Karyawan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Tambah karyawan -->
                        <li class="nav-item">
                            <a href="{{ route('owner.register') }}" class="nav-link">
                                <p>Tambah Akun Karyawan</p>
                            </a>
                        </li>
                        <!-- Laporan Absensi -->
                        <li class="nav-item">
                            <a href="{{ route('owner.employee.report') }}" class="nav-link">
                                <p>Laporan Absensi</p>
                            </a>
                        </li>
                        <!-- Laporan Gaji -->
                        <li class="nav-item">
                            <a href="{{ route('owner.employee.salary') }}" class="nav-link">
                                <p>Laporan Penggajian</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Stok -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                        <p>
                            Stok
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Laporan Stok -->
                        <li class="nav-item">
                            <a href="{{ route('owner.stock.report') }}" class="nav-link">
                                <p>Laporan Stok</p>
                            </a>
                        </li>
                        <!-- Tambah Stok -->
                        <li class="nav-item">
                            <a href="{{ route('owner.add.stock') }}" class="nav-link">
                                <p>Tambah Stok</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Menu -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-utensils"></i>
                        <p>
                            Menu
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Tambah Menu -->
                        <li class="nav-item">
                            <a href="{{ route('menu.create') }}" class="nav-link">
                                <p>Tambah Menu</p>
                            </a>
                        </li>
                        <!-- Edit menu -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>Edit Menu</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Headbar Sidebar -->
                @elseif(Auth::user()->position == 'headbar')

                <li class="nav-item">
                    <a href="{{ route('headbar-attendance.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Absensi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('headbar.add.stock') }}" class="nav-link">
                        <i class="nav-icon fa fa-plus"></i>
                        <p>Tambah Stok</p>
                    </a>
                </li>
                <!-- Employee Sidebar -->
                @else

                <li class="nav-item">
                    <a href="{{ route('employee-attendance.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Absensi
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                        <form action="{{route('logout')}}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>