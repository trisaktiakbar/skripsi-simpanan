<?php

include('../../app/functions/db_connect.php');
include('../../app/functions/base_url.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');
include('../../app/functions/upload_file.php');

$code = $_GET['id'];

$result_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($result_laporan)) {
    header('Location: ..');
}

$result_laporan = query("SELECT * FROM laporan WHERE qr_code = '$code' LIMIT 1")[0];

$id = $result_laporan['id'];
$judul_laporan = $result_laporan['judul_laporan'];
$keterangan = $result_laporan['keterangan'];
$surat_pengantar = $result_laporan['surat_pengantar'];
$qr_code = $result_laporan['qr_code'];

if (isset($_POST['submit'])) {
    $judul_laporan = $_POST['judul'];
    $keterangan = $_POST['keterangan'];

    if ($_FILES['surat-pengantar']['name'] !== "") {
        $surat_pengantar = uploadFile($_FILES['surat-pengantar'], '../../app/data/file/surat-pengantar/');
    }

    mysqli_query(
        $conn,
        "UPDATE laporan SET
        judul_laporan = '$judul_laporan',
        keterangan = '$keterangan',
        surat_pengantar = '$surat_pengantar'
        WHERE qr_code = '$qr_code'"
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
    <title>SIMPANAN | Sunting Laporan</title>
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
                    <h1 class="mt-4">Sunting Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active">Sunting Laporan</li>
                    </ol>

                    <div class="card mb-4 p-lg-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-3">Sunting Laporan</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">


                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-4">
                                            <label for="judul" class="form-label">Judul Laporan</label>
                                            <input type="text" class="form-control" value="<?= $judul_laporan ?>" id="judul" name="judul" placeholder="Judul Laporan" maxlength="255" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="5" maxlength="999"><?= $keterangan ?></textarea>
                                        </div>

                                        <div class="row d-none" id="row-surat-pengantar">
                                            <div class="col-lg-4 col-md-6 col-sm-8">
                                                <div class="mb-4">
                                                    <label for="surat-pengantar" class="form-label">Surat Pengantar</label>
                                                    <input type="file" onchange="updateSuratPengantar(event)" class="form-control" id="surat-pengantar" name="surat-pengantar">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-1" id="row-preview-file">
                                            <div class="col-lg-4 col-md-6 col-sm-8">
                                                <label for="surat-pengantar" class="form-label">Surat Pengantar</label>

                                                <div class="card">
                                                    <div class="card-body">

                                                        <div class="row align-items-center">
                                                            <div style="width:15%">
                                                                <img src="<?= $BASE_URL ?>assets/img/icons-folder.png" alt="<?= $judul_laporan ?>" class="w-100">
                                                            </div>
                                                            <div style="width: 85%;">
                                                                <p style="display: inline;"><?= $judul_laporan ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-lg-4 col-md-6 col-sm-8">
                                                <button type="button" class="btn btn-secondary w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#GantiFileModal">Ganti File</button>
                                            </div>

                                            <div class="modal fade" id="GantiFileModal" tabindex="-1" aria-labelledby="GantiFileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="GantiFileModalLabel">Surat Pengantar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body w-100">
                                                            <label for="surat-pengantar" class="py-5 w-100 justify-content-center my-3 cursor-pointer text-primary">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <h1 id="icon-plus" class="text-center"><i class="fa-solid fa-square-plus"></i></h1>
                                                                        <h5 id="pilih-file" class="text-center">Pilih File</h5>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="updatePreviewFile(event)"><i class="fas fa-chevron-left"></i>&ensp;Kembali</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

        let updateSuratPengantar = function(event) {
            let file_pendukung = document.getElementById('surat-pengantar');
            let file_pendukung_filename = file_pendukung.files[0].name;
            let icon_plus = document.getElementById('icon-plus');
            icon_plus.classList.add('d-none')
            let pilih_file = document.getElementById('pilih-file');
            pilih_file.innerText = file_pendukung_filename;
        };

        let updatePreviewFile = function(event) {
            document.getElementById('row-preview-file').classList.add('d-none');
            document.getElementById('row-surat-pengantar').classList.remove('d-none');
        }
    </script>
</body>

</html>