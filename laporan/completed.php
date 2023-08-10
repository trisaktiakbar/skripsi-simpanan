<?php

include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/user_auth.php');
include('../app/functions/date_formatter.php');

$result_laporan = query("SELECT * FROM laporan WHERE status = 'selesai'");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Laporan Selesai</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('../nav/navbar.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <?php include('../nav/sidenav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Semua Laporan</a></li>
                        <li class="breadcrumb-item active">Laporan Selesai</li>
                    </ol>

                    <a href="<?= $BASE_URL ?>laporan/tambah/" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Laporan</a>
                    <div class="card mb-4 card-border-bottom-primary">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Semua Laporan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table-striped">
                                <thead>
                                    <tr>
                                        <th>Judul Laporan</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Terakhir Diperbarui</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Judul Laporan</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Terakhir Diperbarui</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($result_laporan as $laporan) : ?>
                                        <tr class="text-center">
                                            <td class="align-middle"><?= $laporan['judul_laporan'] ?></td>
                                            <td class="align-middle"><?= dateFormatter($laporan['created_at']) ?></td>
                                            <td class="align-middle"><?= dateFormatter($laporan['updated_at']) ?></td>
                                            <td class="align-middle"><a href="<?= $BASE_URL ?>laporan/<?= $laporan['status'] === 'belum diproses' ? "unprocessed.php" : ($laporan['status'] === 'sementara proses' ? "on-processing.php" : "completed.php") ?>" class="text-decoration-none badge rounded-pill shadow border border-1 <?= $laporan['status'] === 'belum diproses' ? "border-danger text-danger" : ($laporan['status'] === 'sementara proses' ? "border-warning text-warning" : "border-success text-success") ?> p-2"><?= ucwords($laporan['status']) ?></a></td>
                                            <td class="align-middle"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $laporan['qr_code'] ?>"><span class="btn btn-sm btn-primary my-1">Lihat Detail</span></a></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../footer/footer.php') ?>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?= $BASE_URL ?>js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script>
        const nav_collapse_laporan = document.getElementById('nav-collapse-laporan');
        nav_collapse_laporan.classList.remove('collapsed');
        nav_collapse_laporan.classList.add('active');
        nav_collapse_laporan.setAttribute('aria-expanded', true);

        const collapse_layout_laporan = document.getElementById('collapse-layout-laporan');
        collapse_layout_laporan.classList.add('show');

        const nav_link_semua_laporan = document.getElementById('nav-link-laporan-selesai');
        nav_link_semua_laporan.classList.add('active');
    </script>
</body>

</html>