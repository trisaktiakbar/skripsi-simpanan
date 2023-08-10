<?php

include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');

session_start();

$username = "";
$password = "";

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $username = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username, hak_akses FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // Check cookie & username
    if ($username === hash('sha256', $row['username'])) {
        $_SESSION['login'] = $row['username'];
        $_SESSION['status'] = $row['hak_akses'];
    }
}


if (isset($_SESSION['login'])) {
    header('Location: ..');
    exit;
}



if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $username = strtolower($username);
    $password = $_POST["password"];
    $hak_akses = $_POST["hak_akses"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"]) && $hak_akses == $row["hak_akses"]) {

            // set session
            $_SESSION['login'] = $row['username'];
            $_SESSION['status'] = $row['hak_akses'];

            // set remember
            if (isset($_POST['remember'])) {
                // make cookie
                setcookie('id', $row['id'], time() + 2147483647);
                setcookie('key', hash('sha256', $row['username']), time() + 2147483647);
            }

            header("Location: ..");
            exit;
        } else {
            $error = "Periksa kembali username dan password Anda !";
        }
    } else {
        $error = "Periksa kembali username dan password Anda !";
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
    <title>SIMPANAN | Log In</title>
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body::before {
            background-color: rgba(255, 255, 255, 0);
        }
    </style>
</head>

<body class="bg-size-cover" style="background-image: url('../assets/img/bg.jpg'); background-position:bottom">

    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Gagal Login !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $error ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary bg-opacity-75">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center mt-5">
                            <div class="col-lg-5">
                                <div class="card mt-4 pb-4 card-border-bottom-danger">
                                    <div class="card-header">
                                        <h3 class="text-center fw-bold text-primary mt-4">SIMPANAN</h3>
                                        <h5 class="text-muted text-center mb-4 fw-normal">Log Into Your Account</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="hak_akses" name="hak_akses" aria-label="Login sebagai">
                                                    <option value="admin" selected>Admin</option>
                                                    <option value="user" selected>User</option>
                                                    <option value="pegawai">Pegawai</option>
                                                </select>
                                                <label for="floatingSelect">Login sebagai</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username" name="username" type="text" value="<?= $username ?>" placeholder="Username" />
                                                <label for="username">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" type="password" value="<?= $password ?>" placeholder="Password" />
                                                <label for="password">Password</label>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="remember" />
                                                    <label class="form-check-label" for="remember">Remember Password</label>
                                                </div>
                                                <button type="submit" id="submit" name="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php include('../footer/footer.php') ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/scripts.js"></script>
    <script>
        document.getElementById('footer').classList.replace('bg-light', 'bg-danger')
        // document.getElementById('footer').classList.add('bg-opacity-75')
        document.getElementById('footer-copyright').classList.replace('text-muted', 'text-white')
        document.getElementById('footer-text').classList.replace('text-muted', 'text-white')

        const alertModal = new bootstrap.Modal(document.getElementById('alertModal'), {
            keyboard: false
        })

        <?php if (isset($error)) : ?>
            alertModal.show();
        <?php endif ?>
    </script>
</body>

</html>