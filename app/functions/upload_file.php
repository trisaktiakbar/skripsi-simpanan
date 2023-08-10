<?php

function uploadFile($file, $direktori)
{
    $namaFile = $file['name'];
    $tmpName = $file['tmp_name'];

    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = end($ekstensiFile);
    $ekstensiFile = strtolower($ekstensiFile);

    $namaFileBaru = time();
    $namaFileBaru .= '-';
    $namaFileBaru .= uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFile;

    move_uploaded_file($tmpName, $direktori . $namaFileBaru);
    return $namaFileBaru;
}
