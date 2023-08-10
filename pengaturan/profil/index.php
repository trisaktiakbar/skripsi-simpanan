<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');
include('../../app/functions/upload_file.php');

$username = $_SESSION['login'];
$result_user = query("SELECT * FROM user WHERE username = '$username' LIMIT 1")[0];
$nama_depan = $result_user['nama_depan'];
$nama_belakang = $result_user['nama_belakang'];
$tempat_lahir = $result_user['tempat_lahir'];
$tanggal_lahir = $result_user['tanggal_lahir'];
$foto = $result_user['foto'];

if (isset($_POST['submit'])) {
    $nama_depan = $_POST['nama-depan'];
    $nama_belakang = $_POST['nama-belakang'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];

    if ($_FILES['foto-profil']['name'] !== "") {
        $foto = uploadFile($_FILES['foto-profil'], '../../app/data/foto/profil-user/');
    }

    mysqli_query($conn, "UPDATE user SET
    nama_depan = '$nama_depan',
    nama_belakang = '$nama_belakang',
    tempat_lahir = '$tempat_lahir',
    tanggal_lahir = '$tanggal_lahir',
    foto = '$foto'
    WHERE username = '$username'
    ");

    header("Refresh: 0");
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
    <title>SIMPANAN | Profil</title>
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
                    <h1 class="mt-4">Profil</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Pengaturan</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>

                    <div class="card mb-5 pb-1 card-border-bottom-primary">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="foto-profil" class="form-label">Foto Profil</label>
                                                    <div>
                                                        <label for="foto-profil" class="w-100">
                                                            <div class="text-center">
                                                                <img src="<?= $result_user['foto'] === "" ? $BASE_URL . "assets/img/foto-preview.png" : $BASE_URL . "app/data/foto/profil-user/" . $result_user['foto'] ?>" alt="<?= $username ?>" id="foto-preview" class="object-fit-cover w-100 rounded-3 border border-1 mb-3 cursor-pointer">
                                                            </div>
                                                        </label>
                                                        <input type="file" onchange="previewImage(event)" accept="image/*" class="form-control" id="foto-profil" name="foto-profil">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-4">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Username" value="<?= $username ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label for="nama-depan" class="form-label">Nama Depan</label>
                                                    <input type="text" class="form-control" id="nama-depan" name="nama-depan" aria-describedby="nama-depan" value="<?= $nama_depan ?>" placeholder="Nama Depan">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-4">
                                                    <label for="nama-belakang" class="form-label">Nama Belakang</label>
                                                    <input type="text" class="form-control" id="nama-belakang" name="nama-belakang" aria-describedby="nama-belakang" value="<?= $nama_belakang ?>" placeholder="Nama Belakang">
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
                                                    <input type="date" class="form-control" id="tanggal-lahir" name="tanggal-lahir" aria-describedby="tanggal-lahir" value="<?= $tanggal_lahir ?>">
                                                </div>
                                            </div>
                                            <div class="col text-end">
                                                <button type="button" onclick="window.location.replace('<?= $BASE_URL ?>')" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i></button>
                                                <button type="submit" id="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                            </form>
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
        const nav_collapse_pengaturan = document.getElementById('nav-collapse-pengaturan');
        nav_collapse_pengaturan.classList.remove('collapsed');
        nav_collapse_pengaturan.classList.add('active');
        nav_collapse_pengaturan.setAttribute('aria-expanded', true);

        const collapse_layout_pengaturan = document.getElementById('collapse-layout-pengaturan');
        collapse_layout_pengaturan.classList.add('show');

        const nav_link_profil = document.getElementById('nav-link-profil');
        nav_link_profil.classList.add('active');

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