<?php

include('../app/functions/db_connect.php');
include('../app/functions/base_url.php');
include('../app/functions/query.php');
include('../app/functions/upload_file.php');
include('../app/functions/admin_auth.php');

?>

<?php

$username = $_GET['user'];

$result = mysqli_query($conn, "SELECT username FROM user WHERE username='$username' AND NOT hak_akses='admin'");

if (!mysqli_fetch_assoc($result)) {
    header('Location: index.php');
}

$user = query("SELECT * FROM user WHERE username='$username' LIMIT 1")[0];

$username = $user['username'];
$nama_depan = $user['nama_depan'];
$nama_belakang = $user['nama_belakang'];
$tempat_lahir = $user['tempat_lahir'];
$tanggal_lahir = $user['tanggal_lahir'];
$hak_akses = $user['hak_akses'];
$foto = $user['foto'];

if (isset($_POST['submit'])) {
    $nama_depan = $_POST['nama-depan'];
    $nama_belakang = $_POST['nama-belakang'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];
    $hak_akses = $_POST['hak-akses'];

    if ($_FILES['foto']['name'] !== "") {
        $foto = uploadFile($_FILES['foto'], '../app/data/foto/profil-user/');
    }

    mysqli_query($conn, "UPDATE user SET
    nama_depan='$nama_depan',
    nama_belakang='$nama_belakang',
    tempat_lahir='$tempat_lahir',
    tanggal_lahir='$tanggal_lahir',
    hak_akses='$hak_akses',
    foto='$foto'
    WHERE username='$username'");

    header('Location: index.php');
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
    <title>SIMPANAN | Edit Pengguna</title>
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
                    <h1 class="mt-4">Edit Pengguna</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>kelola-admin" class="text-decoration-none">Kelola Admin</a></li>
                        <li class="breadcrumb-item active">Edit Pengguna</li>
                    </ol>

                    <div class="card mb-5 card-border-bottom-primary">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="foto" class="form-label">Foto Profil</label>
                                                    <div>
                                                        <label for="foto" class="w-100">
                                                            <div class="text-center">
                                                                <img id="foto-preview" src="<?= $foto == '' ? $BASE_URL . 'assets/img/foto-preview.png' : $BASE_URL . 'app/data/foto/profil-user/' . $foto ?>" alt="" class="object-fit-cover w-100 rounded-3 border border-1 mb-3 cursor-pointer">
                                                            </div>
                                                        </label>
                                                        <input type="file" accept="image/*" onchange="previewImage(event)" class="form-control" id="foto" name="foto">
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
                                                    <input type="text" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Username" value="<?= $username ?>" disabled>
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
                                                    <input type="date" class="form-control" id="tanggal-lahir" name="tanggal-lahir" value="<?= $tanggal_lahir ?>" aria-describedby="tanggal-lahir">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-4">
                                                    <label for="hak-akses" class="form-label">Hak Akses</label>
                                                    <select name="hak-akses" class="form-select" id="hak-akses">
                                                        <option value="user">User</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-end">
                                                <a href="<?= $BASE_URL ?>kelola-admin" class="btn btn-secondary"><i class="fa-solid fa-chevron-left"></i>&ensp;Kembali</a>
                                                <button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>&ensp;Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
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
    <script>
        const nav_link_kelola_admin = document.getElementById('nav-link-kelola-admin');
        nav_link_kelola_admin.classList.add('active');

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