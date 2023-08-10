<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/pegawai_auth.php');
include('../../app/functions/detail_date_formatter.php');

$result_absensi = query("SELECT * FROM absensi INNER JOIN user ON absensi.kode_user = user.id");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | List Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('../../nav/navbar.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <?php include('../../nav/sidenav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Absensi</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Absensi</a></li>
                        <li class="breadcrumb-item active">List Absensi</li>
                    </ol>

                    <a href="<?= $BASE_URL ?>absensi/scan" class="btn btn-primary mb-3">Absen Sekarang</a>
                    <div class="card mb-4 card-border-bottom-primary">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            List Absensi
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($result_absensi as $absensi) : ?>
                                        <tr class="text-center">
                                            <td class="align-middle"><?= $absensi['nama_depan'] . ' ' . $absensi['nama_belakang'] ?></td>
                                            <td class="align-middle"><?= $absensi['username'] ?></td>
                                            <td class="align-middle"><?= detailDateFormatter($absensi['check_in']) ?></td>
                                            <td class="align-middle"><?= $absensi['check_out'] ? detailDateFormatter($absensi['check_out']) : "-" ?></td>
                                            <td class="align-middle"><?= time() ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../../footer/footer.php') ?>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?= $BASE_URL ?>js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script>
        const nav_collapse_absensi = document.getElementById('nav-collapse-absensi');
        nav_collapse_absensi.classList.remove('collapsed');
        nav_collapse_absensi.classList.add('active');
        nav_collapse_absensi.setAttribute('aria-expanded', true);

        const collapse_layout_absensi = document.getElementById('collapse-layout-absensi');
        collapse_layout_absensi.classList.add('show');

        const nav_link_list_absensi = document.getElementById('nav-link-list-absensi');
        nav_link_list_absensi.classList.add('active');
    </script>
</body>

</html>