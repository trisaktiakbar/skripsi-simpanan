<?php

include('../../../app/functions/db_connect.php');
include('../../../app/functions/query.php');
include('../../../app/functions/base_url.php');
include('../../../app/functions/user_auth.php');

$code = $_GET['id'];
$id = $_GET['get'];

$kode_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");

if (!mysqli_fetch_assoc($kode_laporan)) {
    header('Location: ..');
} else {
    $kode_laporan = query("SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1")[0]['id'];
}

$result = mysqli_query($conn, "SELECT id FROM pelapor WHERE kode_laporan='$kode_laporan' AND id='$id'");

if (!mysqli_fetch_assoc($result)) {
    header('Location: ..');
} else {
    mysqli_query($conn, "DELETE FROM pelapor WHERE kode_laporan='$kode_laporan' AND id='$id'");
    header("Location: ..?id=$code");
}
