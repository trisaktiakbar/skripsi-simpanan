<?php

include('../../../app/functions/base_url.php');
include('../../../app/functions/db_connect.php');
include('../../../app/functions/query.php');
include('../../../app/functions/user_auth.php');
include('../../../app/functions/upload_file.php');


$code = $_GET['id'];
$id = $_GET['get'];

$id_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($id_laporan)) {
    header('Location: ..');
} else {
    $result_laporan = query("SELECT id, judul_laporan FROM laporan WHERE qr_code = '$code' LIMIT 1")[0];
    $id_laporan = $result_laporan['id'];
    $judul_laporan = $result_laporan['judul_laporan'];
}

$result_barang_bukti = mysqli_query($conn, "SELECT * FROM barang_bukti WHERE id='$id' AND kode_laporan = '$id_laporan'");

if (!mysqli_fetch_assoc($result_barang_bukti)) {
    header('Location: ..');
} else {
    $result_barang_bukti = query("SELECT * FROM barang_bukti WHERE id='$id'")[0];
}

$nama_barang_bukti = $result_barang_bukti['nama_barang_bukti'];
$kuantitas = $result_barang_bukti['kuantitas'];
$keterangan = $result_barang_bukti['keterangan'];
$file_pendukung = $result_barang_bukti['file_pendukung'];


if (isset($_POST['submit'])) {
    $nama_barang_bukti = $_POST['nama-barang-bukti'];
    $kuantitas = $_POST['kuantitas'];
    $keterangan = $_POST['keterangan'];

    if ($_FILES['file-pendukung']['name'] !== '') {
        $file_pendukung = uploadFile($_FILES['file-pendukung'], '../../../app/data/file/barang-bukti/');
    }

    mysqli_query(
        $conn,
        "UPDATE barang_bukti SET
        nama_barang_bukti = '$nama_barang_bukti',
        kuantitas = '$kuantitas',
        keterangan = '$keterangan',
        file_pendukung = '$file_pendukung'
        WHERE id = '$id'"
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
    <title>SIMPANAN | Barang Bukti</title>
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
                    <h1 class="mt-4">Detail Barang Bukti</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none"><?= $judul_laporan ?></a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none">Barang Bukti</a></li>
                        <li class="breadcrumb-item active"><?= $nama_barang_bukti ?></li>
                    </ol>

                    <div class="card mb-5 pb-4 card-border-bottom-primary">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="nama-barang-bukti" class="form-label">Nama Barang Bukti</label>
                                            <input type="text" class="form-control" id="nama-barang-bukti" name="nama-barang-bukti" onchange="enableSubmit()" aria-describedby="nama-barang-bukti" placeholder="Nama Barang Bukti" value="<?= $nama_barang_bukti ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label for="kuantitas" class="form-label">Kuantitas</label>
                                            <input type="number" class="form-control" id="kuantitas" name="kuantitas" onchange="enableSubmit()" aria-describedby="kuantitas" placeholder="Kuantitas" value="<?= $kuantitas ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" onchange="enableSubmit()" aria-describedby="keterangan" placeholder="Keterangan" rows="5"><?= $keterangan ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-none" id="row-file-pendukung">
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="mb-4">
                                            <label for="file-pendukung" class="form-label">File Pendukung</label>
                                            <input type="file" onchange="updateFilePendukung(event)" class="form-control" onchange="enableSubmit()" id="file-pendukung" name="file-pendukung">
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-1" id="row-preview-file">
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <label for="file-pendukung" class="form-label">File Pendukung</label>

                                        <a href="<?= $BASE_URL ?>app/data/file/barang-bukti/<?= $file_pendukung ?>" download="<?= $nama_barang_bukti ?>" class="text-decoration-none text-dark">
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="row align-items-center">
                                                        <div style="width:15%">
                                                            <img src="<?= $BASE_URL ?>assets/img/icons-folder.png" alt="<?= $nama_barang_bukti ?>" class="w-100">
                                                        </div>
                                                        <div style="width: 85%;">
                                                            <p style="display: inline;"><?= $nama_barang_bukti ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                </a>

                                <div class="row mb-4">
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <button type="button" class="btn btn-secondary w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#GantiFileModal">Ganti File</button>
                                    </div>

                                    <div class="modal fade" id="GantiFileModal" tabindex="-1" aria-labelledby="GantiFileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="GantiFileModalLabel">File Pendukung</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body w-100">
                                                    <label for="file-pendukung" class="py-5 w-100 justify-content-center my-3 cursor-pointer text-primary">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h1 id="icon-plus" class="text-center"><i class="fa-solid fa-square-plus"></i></h1>
                                                                <h5 id="pilih-file" class="text-center">Pilih File</h5>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-chevron-left"></i>&ensp;Kembali</button>
                                                    <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="updatePreviewFile(event)"><i class="fas fa-pen"></i>&ensp;Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col text-end">
                                        <a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i></a>
                                        <button type="submit" class="btn btn-primary" id="submit" name="submit" disabled>Simpan Perubahan</button>
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

        let updateFilePendukung = function(event) {
            let file_pendukung = document.getElementById('file-pendukung');
            let file_pendukung_filename = file_pendukung.files[0].name;
            let icon_plus = document.getElementById('icon-plus');
            icon_plus.classList.add('d-none')
            let pilih_file = document.getElementById('pilih-file');
            pilih_file.innerText = file_pendukung_filename;
        };

        let updatePreviewFile = function(event) {
            document.getElementById('row-preview-file').classList.add('d-none');
            document.getElementById('row-file-pendukung').classList.remove('d-none');
            enableSubmit();
        }

        function enableSubmit() {
            document.getElementById('submit').removeAttribute('disabled');
        }
    </script>
</body>

</html>