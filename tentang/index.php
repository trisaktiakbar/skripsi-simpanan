<?php
include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/user_auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Tentang</title>
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
                    <h1 class="mt-4">Tentang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tentang</li>
                    </ol>

                    <div class="card mb-5 mt-4 card-border-bottom-primary shadow">

                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-4 mb-4 px-4">
                                    <img src="<?= $BASE_URL ?>assets/img/vector-1.png" alt="" class="w-100">
                                </div>
                                <div class="col-lg-8 my-5">
                                    <h2 class="mb-3">Tentang <span class="text-primary">Sistem</span></h2>
                                    <p>Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran (SIMPANAN) merupakan sistem informasi yang digunakan untuk manajemen data pengaduan masyarakat terkait tindak pidana dan pelanggaran di Kantor Kepolisian Resort (Polres) Mamuju Tengah. Pemanfaatan teknologi berbasis web yang dibangun melalui sistem ini turut andil dalam mewujudkan keterbukaan informasi bagi masyarakat, khususnya dalam pemantauan kasus yang ditangani oleh Polres Mamuju Tengah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-5 card-border-bottom-warning shadow">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-4 order-lg-last mb-4 px-4">
                                    <img src="<?= $BASE_URL ?>assets/img/vector-2.png" alt="" class="w-100">
                                </div>
                                <div class="col-lg-8 my-5">
                                    <h2 class="text-lg-end mb-3">Pemantauan Perkembangan Kasus <span class="text-warning">Berbasis QR Code</span></h2>
                                    <p class="text-lg-end">Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran Berbasis QR Code merupakan suatu sistem yang memungkinkan masyarakat untuk memantau perkembangan kasus yang dilaporkan melalui QR Code. Dengan memindai QR Code menggunakan smartphone, pengguna kemudian akan diarahkan ke suatu halaman web yang menampilkan informasi dari kasus yang telah dilaporkan seperti deskripsi tindak pidana atau pelanggaran, data diri pelapor, data diri tersangka, serta informasi terkait perkembangan dari kasus tersebut.
                                    </p>
                                </div>
                            </div>
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
        document.getElementById('nav-link-tentang').classList.add('active');
    </script>
</body>

</html>