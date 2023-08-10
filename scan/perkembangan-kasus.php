<?php

require('vendors/qr-code-scanner-main/vendor/autoload.php');
include('../app/functions/domain_name.php');
include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/date_formatter.php');

if (!isset($_GET['id']) || !isset($_GET['get'])) header('Location: qr-code');

$code = $_GET['id'];
$id = $_GET['get'];

$result_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($result_laporan)) {
    header("Location: qr-code?id=$code");
}

$kode_laporan = query("SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1")[0]['id'];

$result_perkembangan_kasus = mysqli_query($conn, "SELECT * FROM perkembangan_kasus WHERE kode_laporan = '$kode_laporan' AND id='$id' LIMIT 1");
if (!mysqli_fetch_assoc($result_perkembangan_kasus)) {
    header('Location: qr-code?id=$code');
}

$result_perkembangan_kasus = query("SELECT * FROM perkembangan_kasus WHERE kode_laporan = '$kode_laporan' AND id='$id' LIMIT 1")[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIMPANAN | Detail Perkembangan Kasus</title>
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

                        <div class="row mt-md-5 mt-lg-0 pt-md-5 pt-lg-0" style="min-height: 70vh;">
                            <div class="col-lg-12 mt-md-5 mt-lg-0 pt-md-3 pt-lg-0 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body sale-visit-statistics-border pb-5">
                                        <h4 class="card-title"><button type="button" class="btn btn-outline-primary me-3 btn-sm btn-icon-text icon-lg"><i class="mdi mdi-chevron-left btn-icon-prepend"></i>Kembali</button> Detail Perkembangan Kasus</h4>

                                        <p class="mt-5"><b><?= $result_perkembangan_kasus['judul'] ?></b></p>
                                        <p class="card-description mt-4">
                                            <?= $result_perkembangan_kasus['deskripsi'] ?>
                                        </p>

                                        <div class="badge badge-success my-5 p-3"> Ditambahkan pada <b><?= dateFormatter($result_perkembangan_kasus['created_at']) ?></b>, Terakhir diperbarui pada <b><?= dateFormatter($result_perkembangan_kasus['updated_at']) ?></b></div>

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
        document.getElementById('nav-deskripsi-kasus').setAttribute('href', '<?= $BASE_URL ?>scan/index.php?id=<?= $code ?>#deskripsi-kasus')
        document.getElementById('nav-pihak-terlibat').setAttribute('href', '<?= $BASE_URL ?>scan/index.php?id=<?= $code ?>#pihak-terlibat')
        document.getElementById('nav-barang-bukti').setAttribute('href', '<?= $BASE_URL ?>scan/index.php?id=<?= $code ?>#barang-bukti')
        document.getElementById('nav-perkembangan-kasus').setAttribute('href', '<?= $BASE_URL ?>scan/index.php?id=<?= $code ?>#perkembangan-kasus')
        document.getElementById('nav-tentang-sistem').setAttribute('href', '<?= $BASE_URL ?>scan/tentang-sistem.php?id=<?= $code ?>')
    </script>

</body>

</html>