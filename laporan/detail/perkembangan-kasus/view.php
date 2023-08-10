<?php

include('../../../app/functions/base_url.php');
include('../../../app/functions/db_connect.php');
include('../../../app/functions/query.php');
include('../../../app/functions/user_auth.php');
include('../../../app/functions/detail_date_formatter.php');


$code = $_GET['id'];
$id = $_GET['get'];

$kode_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code='$code'");

if (!mysqli_fetch_assoc($kode_laporan)) {
    header('Location: ..');
} else {
    $result_laporan = query("SELECT id, judul_laporan FROM laporan WHERE qr_code='$code'")[0];
    $kode_laporan = $result_laporan['id'];
    $judul_laporan = $result_laporan['judul_laporan'];
}

$result_perkembangan_kasus = mysqli_query($conn, "SELECT * FROM perkembangan_kasus WHERE id = '$id' AND kode_laporan = '$kode_laporan' LIMIT 1");
if (!mysqli_fetch_assoc($result_perkembangan_kasus)) {
    header('Location: ..');
} else {
    $result_perkembangan_kasus = query("SELECT * FROM perkembangan_kasus WHERE id = '$id' AND kode_laporan = '$kode_laporan' LIMIT 1")[0];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Detail Perkembangan Kasus</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('../../../nav/navbar.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <?php include('../../../nav/sidenav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Perkembangan Kasus</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none"><?= $judul_laporan ?></a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none">Perkembangan Kasus</a></li>
                        <li class="breadcrumb-item active"><?= $result_perkembangan_kasus['judul'] ?></li>
                    </ol>

                    <div class="card mb-5 pb-4 card-border-bottom-primary">
                        <div class="card-body p-lg-5">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3><?= $result_perkembangan_kasus['judul'] ?></h3>
                                    <p class="mb-3 small text-muted">Ditambahkan pada <?= detailDateFormatter($result_perkembangan_kasus['created_at']) ?>, Terakhir diperbarui pada <?= detailDateFormatter($result_perkembangan_kasus['updated_at']) ?></p>
                                </div>
                                <div>
                                    <a href="<?= $BASE_URL ?>laporan/detail/?id=<?= $code ?>" class="btn btn-outline-primary" title="Kembali"><i class="fa-solid fa-chevron-left"></i></a>
                                    <a href="<?= $BASE_URL ?>laporan/detail/perkembangan-kasus/edit.php?id=<?= $code ?>&get=<?= $id ?>" class="btn btn-primary"><i class="fas fa-pen"></i>&ensp;Perbarui</a>
                                </div>
                            </div>
                            <p><?= $result_perkembangan_kasus['deskripsi'] ?></p>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../../../footer/footer.php') ?>
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

        const nav_link_semua_laporan = document.getElementById('nav-link-semua-laporan');
        nav_link_semua_laporan.classList.add('active');
    </script>
</body>

</html>