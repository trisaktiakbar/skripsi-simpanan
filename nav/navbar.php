<?php
$status = $_SESSION['status'];
?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html"><span class="text-primary"><i class="fa-solid fa-handcuffs"></i>&ensp;SIM</span>PANAN</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <h6 class="order-1 order-lg-0 d-none d-lg-block mx-4 me-lg-0 my-auto text-white text-uppercase"><span class="text-primary">Sistem Informasi Manajemen</span> Pengaduan Tindak Pidana</h6>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <?php if ($status !== "pegawai") : ?>
                    <li>
                        <a class="dropdown-item" href="<?= $BASE_URL ?>">Dashboard</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                <?php endif ?>
                <li><a class="dropdown-item" href="<?= $BASE_URL ?>pengaturan/profil">Profil</a></li>
                <li><a class="dropdown-item" href="<?= $BASE_URL ?>pengaturan/ganti-password">Ganti Password</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-primary" href="<?= $BASE_URL ?>absensi">SIMPANAN Presence</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item cursor-pointer text-danger" onclick="window.location.replace('<?= $BASE_URL ?>app/functions/log_out.php')">Log Out</a></li>
            </ul>
        </li>
    </ul>
</nav>