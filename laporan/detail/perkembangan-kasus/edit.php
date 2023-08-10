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

$result_perkembangan_kasus = mysqli_query($conn, "SELECT * FROM perkembangan_kasus WHERE id = '$id' AND kode_laporan = '$kode_laporan' LIMIT 1");
if (!mysqli_fetch_assoc($result_perkembangan_kasus)) {
    header('Location: ..');
} else {
    $result_perkembangan_kasus = query("SELECT * FROM perkembangan_kasus WHERE id = '$id' AND kode_laporan = '$kode_laporan' LIMIT 1")[0];
}

$judul = $result_perkembangan_kasus['judul'];
$deskripsi = $result_perkembangan_kasus['deskripsi'];

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query(
        $conn,
        "UPDATE perkembangan_kasus SET
        judul = '$judul',
        deskripsi = '$deskripsi'
        WHERE kode_laporan = '$kode_laporan'
        AND id = '$id'"
    );
    header("Location: view.php?id=$code&get=$id");
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
                    <h1 class="mt-4">Sunting Perkembangan Kasus</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none"><?= $judul_laporan ?></a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail?id=<?= $code ?>" class="text-decoration-none">Perkembangan Kasus</a></li>
                        <li class="breadcrumb-item active"><a href="<?= $BASE_URL ?>laporan/detail/perkembangan-kasus/view.php?id=<?= $code ?>&get=<?= $id ?>" class="text-decoration-none"><?= $result_perkembangan_kasus['judul'] ?></a></li>
                        <li class="breadcrumb-item active">Sunting</li>
                    </ol>

                    <div class="card mb-5">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <label for="judul" class="form-label">Judul</label>
                                            <input type="text" class="form-control" id="judul" name="judul" aria-describedby="judul" value="<?= $judul ?>" placeholder="Judul">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" aria-describedby="deskripsi" placeholder="Deskripsi" rows="10"><?= $deskripsi ?></textarea>
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
    </script>
</body>

</html>