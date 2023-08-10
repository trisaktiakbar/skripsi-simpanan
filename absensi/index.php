<?php

include('../app/functions/domain_name.php');
include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/date_formatter.php');

?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIMPANAN | Absensi</title>
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css" />
</head>

<body class="m-0 p-0">

    <div class="bg-size-cover" style="background-image: url('<?= $BASE_URL ?>assets/img/bg-login.jpg');">
        <div class="bg-white bg-opacity-75 bg-gradient">
            <div class="container">
                <div class="row align-items-center" style="min-height:100vh">
                    <div class="col-12 col-lg-6 col-xl-8 py-3 mb-5">
                        <h1 class="text-primary lh-base fw-bold d-none d-lg-block mb-5">SIMPANAN <br><span class=" badge border border-primary text-primary rounded-pill fs-5">PRESENCE</span></h1>
                        <p class="text-primary card-description lh-lg fs-5"><b>Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran (SIMPANAN) Presence</b> merupakan suatu sistem absensi online berbasis QR Code di Polres Mamuju Tengah.</p>
                        <a href="<?= $BASE_URL ?>/absensi/scan" class="btn btn-primary btn-lg fs-5 mt-3 fw-bold shadow-lg rounded-pill">Absen Sekarang !</a>
                    </div>
                    <div class="col-12 col-sm-8 offset-sm-2 offset-lg-0 col-lg-6 col-xl-4 order-first order-lg-last">
                        <h1 class="text-primary mt-5 text-center d-block d-lg-none lh-base fw-bold display-1">SIMPANAN</h1>
                        <img src="<?= $BASE_URL ?>assets/img/vector-3.png" class="w-100 my-5" alt="Sistem Informasi Manajemen Pengaduan Tindak Pidana">
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.js"></script>
    <script src="<?= $BASE_URL ?>scan/js/template.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/justgage.js"></script>
    <script>
        function submitQrCode() {
            document.getElementById('submitQrCode').submit();
        }
    </script>

</body>

</html>