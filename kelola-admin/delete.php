<?php

include('../app/functions/db_connect.php');
include('../app/functions/base_url.php');
include('../app/functions/admin_auth.php');

$username = $_GET['user'];

$result = mysqli_query($conn, "SELECT username FROM user WHERE username='$username' AND NOT hak_akses='admin'");

if (!mysqli_fetch_assoc($result)) {
    header('Location: index.php');
} else {
    mysqli_query($conn, "DELETE FROM user WHERE username = '$username' AND NOT hak_akses='admin'");
    header('Location: index.php');
}
