<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <style>
            .text-center {
                text-align: center;
            }

            .logo-dashboard {
                display: block;
                margin: 0 auto;
                height: 100px;
                /* Sesuaikan tinggi gambar sesuai kebutuhan */
                margin-left: 30px;
                /* Sesuaikan nilai ini untuk menggeser gambar ke kanan */
            }
        </style>
        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="dashboard" class="navbar-brand mx-2 mb-3 text-center d-block">
                    <img src="<?= base_url('img/' . $darren2->logo_dashboard) ?>" alt="CV Diesel Service Logo"
                        class="logo-dashboard">
                </a>

                <div class="d-flex justify-content-center align-items-center ms-4 mb-4">
                    <?php if (session()->get('level') == "Admin") { ?>
                        <a href="<?= base_url('home/pesan') ?>" class="btn btn-primary rounded-pill m-2 btn-custom">
                            Tambah Pesanan
                        </a>
                    <?php } ?>
                </div>
                <div class="navbar-nav w-100">

                    <?php
                    $current_url = $_SERVER['REQUEST_URI']; // Mendapatkan URL saat ini
                    ?>
                    <nav>
                        <a href="<?= base_url('home/dashboard') ?>"
                            class="nav-item nav-link <?= ($current_url == '/home/dashboard') ? 'active' : '' ?>">
                            <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                        </a>

                        <?php if (session()->get('level') == "Admin") { ?>
                            <a href="<?= base_url('home/transaksi') ?>"
                                class="nav-item nav-link <?= ($current_url == '/home/transaksi') ? 'active' : '' ?>">
                                <i class="fa fa-keyboard me-2"></i>Transaksi
                            </a>

                            <a href="<?= base_url('home/teknisi') ?>"
                                class="nav-item nav-link <?= ($current_url == '/home/teknisi') ? 'active' : '' ?>">
                                <i class="fa fa-th me-2"></i>Teknisi
                            </a>
                            <!-- <a href="<?= base_url('home/user') ?>" class="nav-item nav-link <?= ($current_url == '/home/user') ? 'active' : '' ?>">
            <i class="fa fa-table me-2"></i>User
        </a> -->

                            <a href="<?= base_url('home/setting') ?>"
                                class="nav-item nav-link <?= ($current_url == '/home/setting') ? 'active' : '' ?>">
                                <i class="fa fa-cogs me-2"></i>Setting
                            </a>

                            <a href="<?= base_url('home/laporan') ?>"
                                class="nav-item nav-link <?= ($current_url == '/home/laporan') ? 'active' : '' ?>">
                                <i class="fa fa-file-alt me-2"></i>Laporan
                            </a>
                        <?php } ?>
                    </nav>
                    <!-- Separator -->
                    <hr class="dropdown-divider mx-3 my-2">

                    <!-- Log Activity Menu -->
                    <a href="<?= base_url('home/log_activity') ?>"
                        class="nav-item nav-link <?= ($current_url == '/home/log_activity') ? 'active' : '' ?>">
                        <i class="fa fa-list-alt me-2"></i>Log Activity
                    </a>
                    <!-- New History Edit Menu -->
                </div>
        </div>
        </nav>
    </div>
    <!-- Sidebar End -->



    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                        <span class="d-none d-lg-inline-flex"><?= session()->get('username') ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="profile" class="dropdown-item">My Profile</a>
                        <a href="setting" class="dropdown-item">Settings</a>
                        <a href="logout" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->