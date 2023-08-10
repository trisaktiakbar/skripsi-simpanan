<?php

include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/admin_auth.php');

$current_username = $_SESSION['login'];

if (isset($_POST['submit'])) {

    $nama_depan = $_POST['nama-depan'];
    $nama_belakang = $_POST['nama-belakang'];
    $username = $_POST['username'];
    $username = strtolower($username);
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn, $password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $hak_akses = $_POST['hak-akses'];

    // Cek Username Exist
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");

    if (mysqli_fetch_assoc($result)) {
        $error_msg = "Username telah terdaftar di sistem... Silahkan gunakan username yang lain";
    } else {
        mysqli_query(
            $conn,
            "INSERT INTO user (
            nama_depan,
            nama_belakang,
            username,
            password,
            hak_akses,
            tanggal_lahir,
            tempat_lahir,
            foto
        ) VALUES (
            '$nama_depan',
            '$nama_belakang',
            '$username',
            '$password',
            '$hak_akses',
            '1970-01-01',
            '',
            ''
        )"
        );
        header("Refresh: 0");
    }
}

$users = query("SELECT * FROM user WHERE username != '$current_username'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Kelola Admin</title>
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
                    <h1 class="mt-4">Kelola Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kelola Admin</li>
                    </ol>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#formRegisterModal"><i class="fas fa-plus"></i> Tambah Admin</button>

                    <div class="modal fade" id="formRegisterModal" tabindex="-1" aria-labelledby="formRegisterModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="formRegisterModalLabel">Tambah Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <?php if (isset($error_msg)) : ?>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="alert alert-danger" role="alert">
                                                        <?= $error_msg ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nama-depan" class="form-label">Nama Lengkap</label>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-3">
                                                        <input type="text" class="form-control" id="nama-depan" name="nama-depan" placeholder="Nama Depan" required>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <input type="text" class="form-control" id="nama-belakang" name="nama-belakang" placeholder="Nama Belakang">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="hak-akses">Hak Akses</label>
                                                <select name="hak-akses" class="form-select" id="hak-akses">
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                    <option value="pegawai">Pegawai</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="50" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="8" maxlength="50" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 card-border-bottom-primary">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Hak Akses</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Hak Akses</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($users as $user) : $i++ ?>
                                        <tr class="text-center">
                                            <td scope="col" class="align-middle"><?= $i ?></td>
                                            <td class="align-middle"><?= $user['nama_depan'] . ' ' . $user['nama_belakang'] ?></td>
                                            <td class="align-middle"><?= $user['username'] ?></td>
                                            <td class="align-middle text-capitalize"><?= $user['hak_akses'] ?></td>
                                            <td class="align-middle">
                                                <button data-bs-toggle="modal" data-bs-target="#<?= $user['username'] ?>DetailModal" title="Lihat" class="btn btn-sm btn-success m-1"><i class="fas fa-eye"></i></button>
                                                <button onclick="window.location.href = '<?= $BASE_URL ?>kelola-admin/edit.php?user=<?= $user['username'] ?>'" title="Sunting" class="btn btn-sm btn-warning m-1 text-white" <?= $user['hak_akses'] === "admin" ? "disabled" : "" ?>><i class="fas fa-pen"></i></button>
                                                <button data-bs-toggle="modal" data-bs-target="#<?= $user['username'] ?>DeleteModal" title="Hapus" class="btn btn-sm btn-danger m-1" <?= $user['hak_akses'] === "admin" ? "disabled" : "" ?>><i class="fas fa-trash"></i></button>
                                            </td>

                                            <div class="modal fade" id="<?= $user['username'] ?>DetailModal" tabindex="-1" aria-labelledby="<?= $user['username'] ?>DetailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="<?= $user['username'] ?>DetailModalLabel">Detail Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <img src="<?= $user['foto'] == '' ? $BASE_URL . 'assets/img/foto-preview.png' : $BASE_URL . 'app/data/foto/profil-user/' . $user['foto'] ?>" alt="" class="w-100 mb-4 px-3 object-fit-cover" style="max-height: 40vh;">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3 text-end">
                                                                    Nama Lengkap :
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <b><?= $user['nama_depan'] . ' ' . $user['nama_belakang'] ?></b>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3 text-end">
                                                                    Username :
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <b><?= $user['username'] ?></b>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3 text-end">
                                                                    Hak Akses :
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <b><?= ucwords($user['hak_akses']) ?></b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-chevron-left"></i>&ensp;Kembali</button>
                                                            <button type="button" class="btn btn-warning text-white"><i class="fas fa-pen"></i>&ensp;Sunting</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="<?= $user['username'] ?>DeleteModal" tabindex="-1" aria-labelledby="<?= $user['username'] ?>DeleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="<?= $user['username'] ?>DeleteModalLabel">Detail Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin ingin menghapus pengguna dengan username <b><?= $user['username'] ?></b> ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="button" class="btn btn-danger" onclick="window.location.replace('<?= $BASE_URL ?>kelola-admin/delete.php?user=<?= $user['username'] ?>')"><i class="fas fa-trash"></i>&ensp;Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script>
        const nav_link_kelola_admin = document.getElementById('nav-link-kelola-admin');
        nav_link_kelola_admin.classList.add('active');

        <?php if (isset($error_msg)) : ?>
            const formRegisterModal = new bootstrap.Modal(document.getElementById('formRegisterModal'), {
                keyboard: false
            })
            formRegisterModal.show()
        <?php endif ?>
    </script>
</body>

</html>