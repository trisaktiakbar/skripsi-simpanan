<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id', '', time() - 3600, '/simpanan/login');
setcookie('key', '', time() - 3600, '/simpanan/login');

header('Location: ../../login');

exit;
