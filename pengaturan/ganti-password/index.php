<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');

$submit_status = "";
$username = $_SESSION['login'];

$password_lama = "";
$password_baru = "";
$password_konfirmasi = "";
$refresh_status = false;

if (isset($_POST['submit'])) {
    $password_lama = $_POST['old-password'];
    $password_baru = $_POST['new-password'];
    $password_konfirmasi = $_POST['confirm-password'];
    $result_password = query("SELECT password FROM user WHERE username = '$username' LIMIT 1")[0]['password'];

    if (!password_verify($password_lama, $result_password)) {
        $submit_status = "Password yang Anda masukkan salah !";
    } else if ($password_baru !== $password_konfirmasi) {
        $submit_status = "Konfirmasi password salah !";
    } else {
        $password_hash = mysqli_real_escape_string($conn, $password_baru);
        $password_hash = password_hash($password_hash, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE user SET password = '$password_hash' WHERE username = '$username'");
        $submit_status = "Berhasil mengubah password !";
        $refresh_status = true;
    }
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
    <title>SIMPANAN | Ganti Password</title>
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
                    <h1 class="mt-4">Ganti Password</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Pengaturan</a></li>
                        <li class="breadcrumb-item active">Ganti Password</li>
                    </ol>

                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card mb-5 pb-1 card-border-bottom-primary">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-4">
                                                            <label for="old-password" class="form-label">Password Lama</label>
                                                            <input type="password" class="form-control" id="old-password" name="old-password" value="<?= $password_lama ?>" aria-describedby="old-password" placeholder="Password Lama" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-4">
                                                            <label for="new-password" class="form-label">Password Baru</label>
                                                            <input type="password" class="form-control" id="new-password" name="new-password" value="<?= $password_baru ?>" aria-describedby="new-password" placeholder="Password Baru" required minlength="8">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-4">
                                                            <label for="confirm-password" class="form-label">Konfirmasi Password Baru</label>
                                                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" value="<?= $password_konfirmasi ?>" aria-describedby="confirm-password" placeholder="Konfirmasi Password Baru" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col text-end">
                                                        <a href="#" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left"></i></a>
                                                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="alertModalLabel">Ganti Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= $submit_status ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" <?php if ($refresh_status) {
                                                                                    echo 'onclick=window.location.replace("' . $BASE_URL . 'pengaturan/ganti-password")';
                                                                                } ?> data-bs-dismiss="modal">Oke</button>

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
        const nav_collapse_pengaturan = document.getElementById('nav-collapse-pengaturan');
        nav_collapse_pengaturan.classList.remove('collapsed');
        nav_collapse_pengaturan.classList.add('active');
        nav_collapse_pengaturan.setAttribute('aria-expanded', true);

        const collapse_layout_pengaturan = document.getElementById('collapse-layout-pengaturan');
        collapse_layout_pengaturan.classList.add('show');

        const nav_link_ganti_password = document.getElementById('nav-link-ganti-password');
        nav_link_ganti_password.classList.add('active');

        <?php if ($submit_status) : ?>
            var alertModal = new bootstrap.Modal(document.getElementById('alertModal'), {
                keyboard: false
            })

            alertModal.show()
        <?php endif ?>
    </script>
</body>

</html>