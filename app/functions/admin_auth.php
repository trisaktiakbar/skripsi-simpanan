<?php

session_start();

if (!isset($_SESSION["login"]) || $_SESSION['status'] !== 'admin') {
    header("Location: " . $BASE_URL . "login");
    exit;
}
