<?php

include('../../../app/functions/base_url.php');
include('../../../app/functions/db_connect.php');
include('../../../app/functions/query.php');
include('../../../app/functions/user_auth.php');
include('../../../app/functions/upload_file.php');


$code = $_GET['id'];

$kode_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code='$code'");

if (!mysqli_fetch_assoc($kode_laporan)) {
    header('Location: ..');
} else {
    $result_laporan = query("SELECT id, judul_laporan FROM laporan WHERE qr_code = '$code' LIMIT 1")[0];
    $kode_laporan = $result_laporan['id'];
    $judul_laporan = $result_laporan['judul_laporan'];
}


if (isset($_POST['submit'])) {
    $nama_barang_bukti = $_POST['nama-barang-bukti'];
    $kuantitas = $_POST['kuantitas'];
    $kuantitas = "" ? $kuantitas = 0 : $kuantitas;
    $keterangan = $_POST['keterangan'];
    $file_pendukung = '';

    if ($_FILES['file-pendukung']) {
        $file_pendukung = uploadFile($_FILES['file-pendukung'], '../../../app/data/file/barang-bukti/');
    }

    mysqli_query(
        $conn,
        "INSERT INTO barang_bukti (
        nama_barang_bukti,
        kuantitas,
        keterangan,
        file_pendukung,
        kode_laporan
        ) VALUES (
        '$nama_barang_bukti',
        '$kuantitas',
        '$keterangan',
        '$file_pendukung',
        '$kode_laporan')"
    );
    header("Location: ..?id=$code");
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
    <title>SIMPANAN | Tambah Barang Bukti</title>
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
                    <h1 class="mt-4">Tambah Barang Bukti</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none"><?= $judul_laporan ?></a></li>
                        <li class="breadcrumb-item active">Tambah Barang Bukti</li>
                    </ol>

                    <div class="card mb-5 pb-4 card-border-bottom-primary">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="nama-barang-bukti" class="form-label">Nama Barang Bukti</label>
                                            <input type="text" class="form-control" id="nama-barang-bukti" name="nama-barang-bukti" aria-describedby="nama-barang-bukti" placeholder="Nama Barang Bukti">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label for="kuantitas" class="form-label">Kuantitas</label>
                                            <input type="number" class="form-control" id="kuantitas" name="kuantitas" min="0" aria-describedby="kuantitas" placeholder="Kuantitas" value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" aria-describedby="keterangan" placeholder="Keterangan" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <label for="file-pendukung" class="form-label">File Pendukung</label>
                                            <input type="file" class="form-control" id="file-pendukung" name="file-pendukung" aria-describedby="file-pendukung" placeholder="File Pendukung">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col text-end">
                                        <a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i></a>
                                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
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
    <script>
        const nav_collapse_laporan = document.getElementById('nav-collapse-laporan');
        nav_collapse_laporan.classList.remove('collapsed');
        nav_collapse_laporan.classList.add('active');
        nav_collapse_laporan.setAttribute('aria-expanded', true);

        const collapse_layout_laporan = document.getElementById('collapse-layout-laporan');
        collapse_layout_laporan.classList.add('show');

        const nav_link_semua_laporan = document.getElementById('nav-link-semua-laporan');
        nav_link_semua_laporan.classList.add('active');

        let previewImage = function(event) {
            let foto_preview = document.getElementById('foto-preview');
            foto_preview.src = URL.createObjectURL(event.target.files[0]);
            foto_preview.onload = function() {
                URL.revokeObjectURL(foto_preview.src) // free memory
            }
        };
    </script>
</body>

</html>