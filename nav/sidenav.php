<?php

$current_username = $_SESSION['login'];
$status = $_SESSION['status'];
$result_user = query("SELECT * FROM user WHERE username = '$current_username'")[0];

?>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav pt-4">
            <?php if ($status !== "pegawai") : ?>
                <a class="nav-link" href="<?= $BASE_URL ?>index.php" id="nav-link-dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-grip-vertical"></i></div>
                    Dashboard
                </a>
            <?php endif ?>
            <?php if ($status !== "pegawai") : ?>
                <a id="nav-collapse-laporan" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-layout-laporan" aria-expanded="false" aria-controls="collapse-layout-laporan">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-lines"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
            <?php endif ?>
            <div class="collapse bg-primary bg-opacity-50" id="collapse-layout-laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a id="nav-link-semua-laporan" class="nav-link small" href="<?= $BASE_URL ?>laporan"><i class="fas fa-file"></i>&ensp;Semua Laporan</a>
                    <a id="nav-link-belum-diproses" class="nav-link small" href="<?= $BASE_URL ?>laporan/unprocessed.php"><i class="fas fa-file-circle-xmark"></i>&ensp;Belum Diproses</a>
                    <a id="nav-link-sementara-proses" class="nav-link small" href="<?= $BASE_URL ?>laporan/on-processing.php"><i class="fas fa-file-pen"></i>&ensp;Sementara Proses</a>
                    <a id="nav-link-laporan-selesai" class="nav-link small" href="<?= $BASE_URL ?>laporan/completed.php"><i class="fas fa-file-circle-check"></i>&ensp;Laporan Selesai</a>
                </nav>
            </div>

            <?php if ($status === "admin") : ?>
                <a class="nav-link" href="<?= $BASE_URL ?>kelola-admin" id="nav-link-kelola-admin">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Kelola Admin
                </a>
            <?php endif ?>

            <a id="nav-collapse-absensi" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-layout-absensi" aria-expanded="false" aria-controls="collapse-layout-absensi">
                <div class="sb-nav-link-icon"><i class="fas fa-business-time"></i></div>
                Absensi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse bg-primary bg-opacity-50" id="collapse-layout-absensi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a id="nav-link-list-absensi" class="nav-link small" href="<?= $BASE_URL ?>absensi/list-absensi"><i class="fas fa-table-list"></i>&ensp;List Absensi</a>
                    <a id="nav-link-riwayat" class="nav-link small" href="<?= $BASE_URL ?>absensi/riwayat"><i class="fas fa-clock-rotate-left"></i>&ensp;Riwayat</a>
                    <?php if ($status !== "pegawai") : ?>
                        <a id="nav-link-generate-qr-code" class="nav-link small" href="<?= $BASE_URL ?>absensi/generate-qr-code"><i class="fas fa-qrcode"></i>&ensp;Generate QR Code</a>
                    <?php endif ?>
                </nav>
            </div>

            <a id="nav-collapse-pengaturan" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse-layout-pengaturan" aria-expanded="false" aria-controls="collapse-layout-pengaturan">
                <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                Pengaturan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse bg-primary bg-opacity-50" id="collapse-layout-pengaturan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a id="nav-link-profil" class="nav-link small" href="<?= $BASE_URL ?>pengaturan/profil"><i class="fa-regular fa-user"></i>&ensp;Profil</a>
                    <a id="nav-link-ganti-password" class="nav-link small" href="<?= $BASE_URL ?>pengaturan/ganti-password"><i class="fas fa-key"></i>&ensp;Ganti Password</a>
                </nav>
            </div>


            <a class="nav-link" id="nav-link-tentang" href="<?= $BASE_URL ?>tentang">
                <div class="sb-nav-link-icon"><i class="fas fa-circle-exclamation"></i></div>
                Tentang
            </a>
            <a class="nav-link text-danger cursor-pointer" onclick="window.location.replace('<?= $BASE_URL ?>app/functions/log_out.php')">
                <div class="sb-nav-link-icon text-danger"><i class="fas fa-right-from-bracket"></i></div>
                Log Out
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        <span class="text-success text-truncate">●</span> <?= $result_user['nama_depan'] . " " . $result_user['nama_belakang'] ?>
    </div>
</nav>