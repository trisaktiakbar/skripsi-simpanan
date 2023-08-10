<?php

require('vendors/qr-code-scanner-main/vendor/autoload.php');
include('../app/functions/domain_name.php');
include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/date_formatter.php');

if (!isset($_GET['id'])) header('Location: qr-code');

$code = $_GET['id'];

$result_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($result_laporan)) {
    header("Location: qr-code?id=$code");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIMPANAN | Tentang Sistem</title>
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.css" />
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/css/style.css" />
</head>

<body id="deskripsi-kasus">
    <div class="container-scroller">

        <?php include('nav/navbar.php') ?>

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="container">
                    <div class="content-wrapper">

                        <div class="row mt-md-5 mt-lg-0 pt-md-5 pt-lg-0">
                            <div class="col-lg-12 mt-md-5 mt-lg-0 pt-md-3 pt-lg-0 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body sale-visit-statistics-border pb-5">


                                        <div class="row align-items-center">
                                            <div class="col-lg-8 order-lg-last">
                                                <h4 class="card-title text-primary">Tentang Sistem</h4>
                                                <p class="card-description mt-4">
                                                    Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran (SIMPANAN) merupakan sistem informasi yang digunakan untuk manajemen data pengaduan masyarakat terkait tindak pidana dan pelanggaran di Kantor Kepolisian Resort (Polres) Mamuju Tengah. Pemanfaatan teknologi berbasis web yang dibangun melalui sistem ini turut andil dalam mewujudkan keterbukaan informasi bagi masyarakat, khususnya dalam pemantauan kasus yang ditangani oleh Polres Mamuju Tengah.
                                                </p>
                                            </div>
                                            <div class="col-lg-4">
                                                <img class="w-100" src="<?= $BASE_URL ?>assets/img/vector-1.png" alt="" srcset="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-md-5 mt-lg-0 pt-md-5 pt-lg-0">
                            <div class="col-lg-12 mt-md-5 mt-lg-0 pt-md-3 pt-lg-0 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body sale-visit-statistics-border pb-5">
                                        <div class="row align-items-center">
                                            <div class="col-lg-8">
                                                <h4 class="card-title text-primary">Pemantauan Perkembangan Kasus Berbasis QR Code</h4>
                                                <p class="card-description mt-4">
                                                    Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran Berbasis QR Code merupakan suatu sistem yang memungkinkan masyarakat untuk memantau perkembangan kasus yang dilaporkan melalui QR Code. Dengan memindai QR Code menggunakan smartphone, pengguna kemudian akan diarahkan ke suatu halaman web yang menampilkan informasi dari kasus yang telah dilaporkan seperti deskripsi tindak pidana atau pelanggaran, data diri pelapor, data diri tersangka, serta informasi terkait perkembangan dari kasus tersebut.</p>
                                            </div>
                                            <div class="col-lg-4">
                                                <img class="w-100" src="<?= $BASE_URL ?>assets/img/vector-3.png" alt="" srcset="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include('footer/footer.php') ?>
            </div>
        </div>
    </div>
    <script src="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.js"></script>
    <script src="<?= $BASE_URL ?>scan/js/template.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/justgage.js"></script>
    <script>
        function toggleNav() {
            document.getElementById('nav').classList.toggle('header-toggled');
        }

        document.getElementById('nav-deskripsi-kasus').setAttribute('href', '<?= $BASE_URL ?>scan?id=<?= $code ?>')
        document.getElementById('nav-pihak-terlibat').setAttribute('href', '<?= $BASE_URL ?>scan?id=<?= $code ?>#pihak-terlibat')
        document.getElementById('nav-barang-bukti').setAttribute('href', '<?= $BASE_URL ?>scan?id=<?= $code ?>#barang-bukti')
        document.getElementById('nav-perkembangan-kasus').setAttribute('href', '<?= $BASE_URL ?>scan?id=<?= $code ?>#perkembangan-kasus')
    </script>

</body>

</html>