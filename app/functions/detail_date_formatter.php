<?php

function detailDateFormatter($timestamp)
{
    $result_full = explode(" ", $timestamp);
    $result_time = $result_full[1];
    $result_time = explode(":", $result_time);
    $result_time = $result_time[0] . ":" . $result_time[1];

    $result_date = $result_full[0];
    $result_date = explode("-", $result_date);
    switch ($result_date[1]) {
        case "01":
            $bulan = "Januari";
            break;
        case "02":
            $bulan = "Februari";
            break;
        case "03":
            $bulan = "Maret";
            break;
        case "04":
            $bulan = "April";
            break;
        case "05":
            $bulan = "Mei";
            break;
        case "06":
            $bulan = "Juni";
            break;
        case "07":
            $bulan = "Juli";
            break;
        case "08":
            $bulan = "Agustus";
            break;
        case "09":
            $bulan = "September";
            break;
        case "10":
            $bulan = "Oktober";
            break;
        case "11":
            $bulan = "November";
            break;
        case "12":
            $bulan = "Desember";
            break;
        default:
            $bulan = "";
            break;
    }

    $result = $result_date[2] . " " . $bulan . " " . $result_date[0] . ", " . $result_time;
    return $result;
}
