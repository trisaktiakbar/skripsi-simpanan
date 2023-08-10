<?php

include('../../app/functions/db_connect.php');
include('../../app/functions/base_url.php');
include('../../app/functions/domain_name.php');
include('../../app/functions/upload_file.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');
include('../../vendor/qrcode/qrlib.php');

if (isset($_POST['submit'])) {
    $judul_laporan = $_POST['judul'];
    $keterangan = $_POST['keterangan'];
    $surat_pengantar = uploadFile($_FILES['surat-pengantar'], '../../app/data/file/surat-pengantar/');
    $qr_code = uniqid();

    $PNG_TEMP_DIR = '../../app/data/qr-code/';
    if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR . $qr_code . '.png';
    $codeString = $DOMAIN_NAME . '/scan?id=' . $qr_code;
    QRcode::png($codeString, $filename);

    mysqli_query(
        $conn,
        "INSERT INTO laporan (
        judul_laporan,
        keterangan,
        surat_pengantar,
        qr_code,
        status
        ) VALUES (
        '$judul_laporan',
        '$keterangan',
        '$surat_pengantar',
        '$qr_code',
        'belum diproses'
        )"
    );
    header("Location: ../detail?id=$qr_code");
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
    <title>SIMPANAN | Tambah Laporan</title>
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
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active">Tambah Laporan</li>
                    </ol>

                    <div class="card mb-4 p-lg-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-3">Tambah Laporan</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">


                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-4">
                                            <label for="judul" class="form-label">Judul Laporan</label>
                                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Laporan" maxlength="255" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="5" maxlength="999"></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="surat-pengantar" class="form-label">Surat Pengantar</label>
                                            <input type="file" class="form-control" id="surat-pengantar" name="surat-pengantar" required>
                                        </div>
                                        <div class="col text-center">
                                            <a onclick="window.location.replace('<?= $BASE_URL ?>laporan/index.php')" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i>&ensp;Kembali</a>
                                            <button type="submit" class="btn btn-primary" id="submit" name="submit"><i class="fa-solid fa-floppy-disk"></i>&ensp;Simpan Perubahan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
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