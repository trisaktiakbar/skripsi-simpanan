<?php

session_start();

if (!isset($_SESSION["login"]) && ($_SESSION['status'] !== 'admin' || $_SESSION['status'] !== 'user' || $_SESSION['status'] !== 'pegawai')) {
    header("Location: " . $BASE_URL . "login");
    exit;
}
