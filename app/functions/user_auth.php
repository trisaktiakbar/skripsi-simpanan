<?php

session_start();

if (!isset($_SESSION["login"]) || ($_SESSION['status'] !== 'admin' && $_SESSION['status'] !== 'user')) {
    if ($_SESSION['status'] === 'pegawai') {
        header("Location: " . $BASE_URL . "absensi/riwayat");
    } else {
        header("Location: " . $BASE_URL . "login");
    }
    exit;
}
