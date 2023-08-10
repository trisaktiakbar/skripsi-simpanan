<?php

use Zxing\QrReader;

$scan_result = '';

if (isset($_FILES['qr-code'])) {
    $filename = $_FILES["qr-code"]["name"];
    $filetype = $_FILES["qr-code"]["type"];
    $filetemp = $_FILES["qr-code"]["tmp_name"];
    $filesize = $_FILES["qr-code"]["size"];

    $filetype = explode("/", $filetype);
    if ($filetype[0] !== "image") {
        $msg = "File type is invalid: " . $filetype[1];
    } elseif ($filesize > 5242880) {
        $msg = "File size is too big. Maximum size is 5 MB.";
    } else {
        $newfilename = md5(rand() . time()) . $filename;
        move_uploaded_file($filetemp, "temp/qr-code/" . $newfilename);

        $qrScan = new QrReader("temp/qr-code/" . $newfilename);
        $msg = "Success";
        $scan_result = $qrScan->text();

        header("Location: $scan_result");
    }
}

?>

<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid bg-primary">
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">

                <div class="container">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo text-danger" href="#">
                            <h3 class="h2 fw-semibold text-white">SIMPANAN (Sistem Informasi Pengaduan Tindak Pidana)</h3>
                        </a>
                        <a class="navbar-brand brand-logo-mini" href="index.html">
                            <h3 class="h2 fw-semibold text-white">SIMPANAN</h3>
                        </a>
                    </div>
                </div>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </div>
    </nav>

    <nav class="bottom-navbar" id="nav">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item">
                    <a class="nav-link" id="nav-deskripsi-kasus" onclick="toggleNav()" href="#deskripsi-kasus">
                        <i class="mdi mdi-file-document-box menu-icon"></i>
                        <span class="menu-title">Deskripsi Kasus</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#pihak-terlibat" id="nav-pihak-terlibat" onclick="toggleNav()" class="nav-link">
                        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                        <span class="menu-title">Pihak Terlibat</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#barang-bukti" id="nav-barang-bukti" onclick="toggleNav()" class="nav-link">
                        <i class="mdi mdi-briefcase menu-icon"></i>
                        <span class="menu-title">Barang Bukti</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#perkembangan-kasus" id="nav-perkembangan-kasus" onclick="toggleNav()" class="nav-link">
                        <i class="mdi mdi-finance menu-icon"></i>
                        <span class="menu-title">Perkembangan Kasus</span>
                    </a>
                </li>
                <li class="nav-item">
                    <button id="nav-scan-qrcode" class="nav-link btn btn-white mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="mdi mdi-qrcode-scan menu-icon"></i>
                        <span class="menu-title">Scan QR Code</span>
                    </button>
                </li>
                <li class="nav-item">
                    <a href="<?= $BASE_URL ?>scan/tentang-sistem.php?id=<?= $code ?>" class="nav-link" id="nav-tentang-sistem">
                        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        <span class="menu-title">Tentang Sistem</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    <button type="button" class="btn btn-link btn-lg">
                        <label for="qr-code">
                            <h1 class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                    <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z" />
                                    <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z" />
                                    <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z" />
                                    <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z" />
                                    <path d="M12 9h2V8h-2v1Z" />
                                </svg>
                            </h1>
                            <h3>Scan Now</h3>
                        </label>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="post" id="submitQrCode" enctype="multipart/form-data">
    <input type="file" accept="image/*" onchange="submitQrCode()" id="qr-code" name="qr-code" class="d-none">
</form>

<script>
    function submitQrCode() {
        document.getElementById('submitQrCode').submit();
    }
</script>