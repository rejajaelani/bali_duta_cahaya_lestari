        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= ($type_page == 1) ? '../' : '../../' ?>" class="brand-link">
                <img src="<?= ($type_page == 1) ? '../' : '../../' ?>images/logo.png" alt="AdminLTE Logo" class="brand-image rounded elevation-3" style="width: 30px;height: 30px;">
                <span class="brand-text font-weight-light" style="letter-spacing: 0.02rem;font-size: 14px;font-weight: bold !important;color: #FFFF !important;text-transform: uppercase;">Bali Duta Cahaya Lestari</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= ($type_page == 1) ? '../' : '../../' ?>" class="nav-link <?= ($name_page == 'Dashboard') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item <?= ($name_page == 'Data User' || $name_page == 'Data Akun') ? 'menu-is-opening menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= ($name_page == 'Data User' || $name_page == 'Data Akun') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Data Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= ($type_page == 1) ? '../' : '../../' ?>data-user" class="nav-link <?= ($name_page == 'Data User') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= ($type_page == 1) ? '../' : '../../' ?>data-akun" class="nav-link <?= ($name_page == 'Data Akun') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Akun</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="<?= ($type_page == 1) ? '../' : '../../' ?>data-keterangan" class="nav-link <?= ($name_page == 'Data Keterangan') ? 'active' : '' ?>">
                                <i class="fas fa-sticky-note nav-icon"></i>
                                <p>Data Keterangan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= ($type_page == 1) ? '../' : '../../' ?>data-transaksi" class="nav-link <?= ($name_page == 'Data Transaksi') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Data Transaksi
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= ($type_page == 1) ? '../' : '../../' ?>data-jurnal" class="nav-link <?= ($name_page == 'Data Jurnal') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Data Jurnal
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= ($type_page == 1) ? '../' : '../../' ?>assets/index.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= ($type_page == 1) ? '../' : '../../' ?>assets/index2.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Akun</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>