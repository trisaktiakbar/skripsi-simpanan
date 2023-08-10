<?php

include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/date_formatter.php');
include('../../app/functions/base_url.php');
include('../../app/functions/user_auth.php');
include('../../app/functions/domain_name.php');
require_once "./../../vendor/dompdf/autoload.inc.php";

$code = $_GET['id'];
$result_laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($result_laporan)) {
    header('Location: ..');
}

$result_laporan = query("SELECT * FROM laporan WHERE qr_code = '$code' LIMIT 1")[0];

$kode_laporan = $result_laporan['id'];
$result_pelapor = query("SELECT * FROM pelapor WHERE kode_laporan = '$kode_laporan'");
$result_tersangka = query("SELECT * FROM tersangka WHERE kode_laporan = '$kode_laporan'");
$result_barang_bukti = query("SELECT * FROM barang_bukti WHERE kode_laporan = '$kode_laporan'");

$path = '../../app/data/qr-code/' . $result_laporan['qr_code'] . '.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$tes = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPANAN</title>
    <style type="text/css">
        body{
            margin: 50px;
            margin-top: 20px;
        }
        p {
            text-align: justify;
            line-height: 1.5;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
        }

        li{
            margin-top: 16px;
        }

        th,
        td {
            border: 0;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>Laporan Pengaduan Tindak Pidana</h2>
    <p>Laporan pengaduan kasus tindak pidana <b>' . $result_laporan['judul_laporan'] . '</b> telah dikonfirmasi oleh pihak kepolisian Polres Mamuju dan sedang diproses. Adapun pihak <b>Pelapor</b> dalam pengaduan kasus tindak pidana ini adalah sebagai berikut :</p>
    <ol>';

foreach ($result_pelapor as $pelapor) {
    $tes .= '
<li>
<table>
    <tr>
        <td style="padding-top:0;">Nama Pelapor</td>
        <td style="padding-top:0;">:&ensp;<b>' . $pelapor['nama_lengkap'] . '</b></td>
    </tr>
    <tr>
        <td>Tempat Lahir</td>
        <td>:&ensp;<b>' . ($pelapor['tempat_lahir'] ? $pelapor['tempat_lahir'] : '-') . '</b></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:&ensp;<b>' . ($pelapor['tanggal_lahir'] != '0001-01-01' ? dateFormatter($pelapor['tanggal_lahir']) : '-') . '</b></td>
    </tr>
    <tr>
        <td style="padding-bottom:16px;">Domisili</td>
        <td style="padding-bottom:16px;">:&ensp;<b>' . ($pelapor['domisili'] ? $pelapor['domisili'] : '-') . '</b></td>
    </tr>

</table>
</li>
';
}

$tes .= '</ol>

    <p>Adapun pihak yang menjadi <b>Tersangka</b> dalam kasus tindak pidana ini sebagai berikut:</p>
    <ol>';

foreach ($result_tersangka as $tersangka) {
    $tes .= '
    <li>
    <table>
        <tr>
            <td style="padding-top:0;">Nama Tersangka</td>
            <td style="padding-top:0;">:&ensp;<b>' . $tersangka['nama_lengkap'] . '</b></td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>:&ensp;<b>' . ($tersangka['tempat_lahir'] ? $tersangka['tempat_lahir'] : '-') . '</b></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:&ensp;<b>' . ($tersangka['tanggal_lahir'] != '0001-01-01' ? dateFormatter($tersangka['tanggal_lahir'] . ' 00') : '-') . '</b></td>
        </tr>
        <tr>
            <td style="padding-bottom:16px;">Domisili</td>
            <td style="padding-bottom:16px;">:&ensp;<b>' . ($tersangka['domisili'] ? $tersangka['domisili'] : '-') . '</b></td>
        </tr>

    </table>
    </li>
    ';
}

$tes .= '</ol>

    <p>Dari pihak <b>Pelapor</b>, telah dikumpulkan beberapa keterangan untuk mendukung jalannya proses kasus yang sedang berjalan. Adapun beberapa keterangan yang didapatkan adalah sebagai berikut :</p>
    <p style="margin-left: 30px;"><i>'  . $result_laporan['keterangan'] . '</i></p>

    <p>Beberapa barang bukti yang ditemukan, yaitu :</p>
    <table style="width: 100%;">

        <tr>
            <th style="border: 1px solid #000;">Nama Barang Bukti</th>
            <th style="border: 1px solid #000;">Kuantitas / Jumlah</th>
            <th style="border: 1px solid #000;">Keterangan</th>
        </tr>';

foreach ($result_barang_bukti as $barang_bukti) {
    $tes .=
        '<tr>
        <td style="border: 1px solid #000; text-align:center">' . $barang_bukti['nama_barang_bukti'] . '</td>
        <td style="border: 1px solid #000; text-align:center">' . ($barang_bukti['kuantitas'] == 0 ? "-" : $barang_bukti['kuantitas']) . '</td>
        <td style="border: 1px solid #000;">' . $barang_bukti['keterangan'] . '</td>
    </tr>';
}

$tes .= '</table>
    <p style="font-size:8pt; text-align:right; line-height:1.2; margin-top:30px">Untuk informasi lebih lanjut, scan melalui laman resmi<br><a style="color:#007BFF">' . $DOMAIN_NAME . '/scan/qr-code</a> atau gunakan <b>Google Lens</b></p>
    <img align="right" src="' . $base64 . '">
</body>

</html>
';

use Dompdf\Dompdf;

$pdf = new Dompdf();

$pdf->loadHtml($tes);

$pdf->setPaper('A4');

$pdf->render();

$pdf->stream("test.pdf", array("Attachment" => false));

exit(0);
