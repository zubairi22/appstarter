<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i><img class="img-thumbnail bg-transparent border-0" width="40" height="80" src="<?= base_url('') ?>/assets/img/logo.png"></i>
        </div>
        <div class="sidebar-brand-text">E-Kinerja</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if (session()->get('user_level_id') == 1) { ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $title == 'Data Pengguna' ? 'active' : ''; ?> ">
            <a class="nav-link" href="<?= base_url('akun') ?>">
                <i class="fas fa-id-card"></i>
                <span>Data Pengguna</span></a>
        </li>

        <li class="nav-item <?= $title == 'Data Pegawai' ? 'active' : ''; ?>">
            <a class="nav-link " href="<?= base_url('pegawai') ?>">
                <i class="fas fa-users"></i>
                <span>Data Pegawai</span>
            </a>
        </li>
    <?php } ?>

    <?php if (session()->get('jabatan_id') != 1) { ?>
        <li class="nav-item <?= $title == 'Pekerjaan' ? 'active' : ''; ?>">
            <a class="nav-link " href="<?= base_url('user') ?>">
                <i class="fas fa-briefcase"></i>
                <span>Pekerjaan</span>
            </a>
        </li>


        <li class="nav-item  <?= $title == 'Laporan Pekerjaan' ? 'active' : ''; ?>">
            <a class="nav-link " href="<?= base_url('laporan') ?>">
                <i class="fas fa-business-time"></i>
                <span>Laporan Pekerjaan Saya</span>
            </a>
        </li>
    <?php } ?>

    <?php if (session()->get('jabatan') == 'KEPALA') { ?>
        <li class="nav-item <?= $title == 'Laporan Pegawai' ? 'active' : ''; ?>">
            <a class="nav-link " href="<?= base_url('laporan/laporanPegawai') ?>">
                <i class="fas fa-file-signature"></i>
                <span>Laporan Pegawai</span>
            </a>
        </li>
    <?php } ?>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>