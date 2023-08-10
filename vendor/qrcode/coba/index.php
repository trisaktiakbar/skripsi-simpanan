<?php
include('../qrlib.php');

$PNG_TEMP_DIR ='temp/';
if(!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);

$filename = $PNG_TEMP_DIR . 'test.png';

$codeString = 'mentormahasiswaindonesia.com';

QRcode::png($codeString, $filename);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<img src="temp/test.png" alt="" srcset="">
</body>
</html>