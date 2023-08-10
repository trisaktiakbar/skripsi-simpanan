<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/pegawai_auth.php');
include('../../app/functions/detail_date_formatter.php');
include('../../app/functions/date_formatter.php');

$username = $_SESSION['login'];

$kode_user = query("SELECT id FROM user WHERE username = '$username' LIMIT 1")[0]['id'];

$result_absensi = query("SELECT * FROM absensi INNER JOIN user ON absensi.kode_user = user.id WHERE user.username = '$username' AND DATE(absensi.check_in) = CURDATE()");

if ($result_absensi) {
    $check_in_out = "Check Out";
    $result_absensi = $result_absensi[0];

    if ($result_absensi['check_out'] !== null) {
        $check_in_out = "Gagal Memproses Absensi";
    }
} else {
    $check_in_out = "Check In";
}

if ($check_in_out == "Check In") {
    mysqli_query($conn, "INSERT INTO absensi(kode_user) VALUES ($kode_user)");
} else if ($check_in_out == "Check Out") {
    mysqli_query($conn, "UPDATE absensi SET check_out = CURRENT_TIMESTAMP() WHERE DATE(check_in) = CURDATE()");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPANAN | Absensi</title>
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('../../nav/navbar.php') ?>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"><?= $check_in_out ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.replace('<?= $BASE_URL ?>absensi/riwayat')"></button>
                </div>
                <div class="modal-body">
                    <?php if ($check_in_out == "Check In" || $check_in_out == "Check Out") : ?>
                        Record Anda berhasil disimpan
                    <?php endif ?>

                    <?php if ($check_in_out == "Gagal Memproses Absensi") : ?>
                        <p class="text-center">
                            Anda sudah melakukan <b>Check In</b> dan <b>Check Out</b> hari ini.
                        </p>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.replace('<?= $BASE_URL ?>absensi/riwayat')" data-bs-dismiss="modal">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('modal'), {
            keyboard: false
        })

        modal.show();
    </script>
</body>

</html>