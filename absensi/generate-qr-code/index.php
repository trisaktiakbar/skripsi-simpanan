<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');
include('../../app/functions/detail_date_formatter.php');
include('../../app/functions/domain_name.php');
include('../../app/functions/presence.php');
include('../../vendor/qrcode/qrlib.php');

$PNG_TEMP_DIR = '../../app/data/qr-absensi/';
if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
$filename = $PNG_TEMP_DIR . $presence_id . '.png';
$codeString = $DOMAIN_NAME . '/absensi/scan/proses.php?id=' . $presence_id . '&key=' . $presence_key;

QRcode::png($codeString, $filename);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Generate QR Code</title>
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
                    <h1 class="mt-4">Generate QR Code</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Absensi</a></li>
                        <li class="breadcrumb-item active">Generate QR Code</li>
                    </ol>

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="card mb-2 d-none" id="card-qr-absensi">
                                <div class="card-body p-0">
                                    <img class="rounded-3 w-100" alt="QR Code" src="<?= $filename ?>">
                                </div>
                            </div>
                            <a id="generate" class="btn btn-primary w-100">Generate QR Code</a>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script>
        const nav_collapse_absensi = document.getElementById('nav-collapse-absensi');
        nav_collapse_absensi.classList.remove('collapsed');
        nav_collapse_absensi.classList.add('active');
        nav_collapse_absensi.setAttribute('aria-expanded', true);

        const collapse_layout_absensi = document.getElementById('collapse-layout-absensi');
        collapse_layout_absensi.classList.add('show');

        const nav_link_generate_qr_code = document.getElementById('nav-link-generate-qr-code');
        nav_link_generate_qr_code.classList.add('active');

        const btn_generate = document.getElementById('generate');

        btn_generate.addEventListener('click', () => {
            document.getElementById('card-qr-absensi')
                .classList.remove('d-none');

            btn_generate.classList.replace('btn-primary', 'btn-success');
            btn_generate.innerHTML = '<i class="fa-regular fa-circle-down"></i>&ensp;Download';
            btn_generate.setAttribute('href', '<?= $BASE_URL ?>app/data/qr-absensi/<?= $presence_id ?>.png');
            btn_generate.setAttribute('download', 'SIMPANAN - QR Code - Absensi.png');

        })
    </script>
</body>

</html>