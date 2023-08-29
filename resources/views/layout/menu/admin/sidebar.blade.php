<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ env('APP_LOGO') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ppni.or.id/simk/id/image/foto/31720126348.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()['nama']['nama_depan'] }} {{ Auth::user()['nama']['nama_belakang'] }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/dashboard/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link">

                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>My Profile<span class="right badge badge-danger">New</span></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('marital_status') }}" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Master
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('observation.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            Observation
                        </p>
                    </a>
                </li>
                <li class="nav-header">EXAMPLES</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Dokumen
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/regulasi" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Regulasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/form" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Formulir Keperawatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/read-mail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Read</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Data Pasien
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/pasien" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Base Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/pasien/register.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pasien Dirawat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/pasien/pembagian-pasien.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembagian Kelolaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/pasien/admisi.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admisi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/ruangan/pelayanan.php" class="nav-link">
                        <i class="nav-icon fas fa-hospital-alt"></i>
                        <p>
                            Ruangan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Logbook
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/regulasi" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pasien Ruangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://rspon.net/ppni/simk/form" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pasien Kelolaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/read-mail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Admin Area</li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/perawat/mutasi.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">Mutasi Perawat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/spk" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>SPK Perawat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/regulasi" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Regulasi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/admin-data" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Admin Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/form" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Formulir Keperawatan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/unit/detail.php?id=349537bf357a6c8316213cfe2fc2319d" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Unit Kerja</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/ruangan" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Ruang Pelayanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/dokter" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p>Dokter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://rspon.net/ppni/simk/auth/logout.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

