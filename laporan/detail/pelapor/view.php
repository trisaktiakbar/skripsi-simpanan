<?php

include('../../../app/functions/base_url.php');
include('../../../app/functions/db_connect.php');
include('../../../app/functions/query.php');
include('../../../app/functions/user_auth.php');
include('../../../app/functions/upload_file.php');


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

$result_pelapor = mysqli_query($conn, "SELECT * FROM pelapor WHERE kode_laporan = '$kode_laporan' AND id = '$id' LIMIT 1");

if (!mysqli_fetch_assoc($result_pelapor)) {
    header('Location: ..');
} else {
    $result_pelapor = query("SELECT * FROM pelapor WHERE kode_laporan = '$kode_laporan' AND id = '$id' LIMIT 1")[0];

    $nama_lengkap = $result_pelapor['nama_lengkap'];
    $tempat_lahir = $result_pelapor['tempat_lahir'];
    $tanggal_lahir = $result_pelapor['tanggal_lahir'];
    $domisili = $result_pelapor['domisili'];
    $foto = $result_pelapor['foto'];
}


if (isset($_POST['submit'])) {
    $nama_lengkap = $_POST['nama-lengkap'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];
    $domisili = $_POST['domisili'];

    if ($_FILES['foto']['name'] !== '') {
        if ($_FILES['foto']) {
            $foto = uploadFile($_FILES['foto'], '../../../app/data/foto/pelapor/');
        }
    }

    mysqli_query(
        $conn,
        "UPDATE pelapor SET
        nama_lengkap = '$nama_lengkap',
        tempat_lahir = '$tempat_lahir',
        tanggal_lahir = '$tanggal_lahir',
        domisili = '$domisili',
        foto = '$foto'
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
    <title>SIMPANAN | Tambah Pelapor</title>
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
                    <h1 class="mt-4">Detail Pelapor</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none"><?= $judul_laporan ?></a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none">Pelapor</a></li>
                        <li class="breadcrumb-item active"><?= $nama_lengkap ?></li>
                    </ol>

                    <div class="card mb-5 pb-4 card-border-bottom-primary">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="foto" class="form-label">Foto Pelapor</label>
                                                    <div>
                                                        <label for="foto" class="w-100">
                                                            <div class="text-center">
                                                                <img id="foto-preview" src="<?= $foto === '' ? $BASE_URL . 'assets/img/foto-preview.png' : $BASE_URL . 'app/data/foto/pelapor/' . $result_pelapor['foto'] ?>" alt="" class="w-100 object-fit-cover w-100 rounded-3 border border-1 mb-3 cursor-pointer">
                                                            </div>
                                                        </label>
                                                        <input type="file" class="form-control" onchange="previewImage(event)" accept="image/*" id="foto" name="foto">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-4">
                                                    <label for="nama-lengkap" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="nama-lengkap" name="nama-lengkap" aria-describedby="nama-lengkap" placeholder="Nama Lengkap" value="<?= $nama_lengkap ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label for="tempat-lahir" class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempat-lahir" name="tempat-lahir" aria-describedby="tempat-lahir" value="<?= $tempat_lahir ?>" placeholder="Kota/Kabupaten">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="tanggal-lahir" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal-lahir" name="tanggal-lahir" <?= $tanggal_lahir != "0001-01-01" ? "value=$tanggal_lahir" : "" ?> aria-describedby="tanggal-lahir">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-4">
                                                            <label for="domisili" class="form-label">Domisili</label>
                                                            <input type="text" class="form-control" id="domisili" name="domisili" aria-describedby="domisili" value="<?= $domisili ?>" placeholder="Kota/Kabupaten">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-end">
                                                <a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i></a>
                                                <button type="submit" class="btn btn-primary" id="submit" name="submit">Simpan Perubahan</button>
                                            </div>
                                        </div>
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