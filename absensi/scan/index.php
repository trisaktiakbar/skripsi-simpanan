<?php

include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/pegawai_auth.php');
include('../../app/functions/detail_date_formatter.php');
include('../../app/functions/date_formatter.php');

$username = $_SESSION['login'];

$result_absensi = query("SELECT * FROM absensi INNER JOIN user ON absensi.kode_user = user.id WHERE user.username = '$username' AND DATE(absensi.check_in) = CURDATE()");

if ($result_absensi) {
    $check_in_out = "Check Out";
    $result_absensi = $result_absensi[0];

    if ($result_absensi['check_out'] !== null) {
        $check_in_out = "Gagal Memproses Absensi";
    }
} else {
    $check_in_out = "Check In";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIMPANAN | Absen</title>
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('../../nav/navbar.php') ?>
    <main>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"><?= $check_in_out ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.replace('<?= $BASE_URL ?>absensi/riwayat')"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($check_in_out == "Check In") : ?>
                            Yakin ingin melakukan check in hari ini <b><?= dateFormatter(date('Y-m-d')) ?></b> ?
                        <?php endif ?>

                        <?php if ($check_in_out == "Check Out") : ?>
                            Yakin ingin melakukan check out ? Anda check in hari ini pada pukul <b><?= detailDateFormatter($result_absensi['check_in']) ?></b>.
                        <?php endif ?>

                        <?php if ($check_in_out == "Gagal Memproses Absensi") : ?>
                            <p class="text-center">
                                Anda sudah melakukan <b>Check In</b> dan <b>Check Out</b> hari ini.
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.location.replace('<?= $BASE_URL ?>absensi/riwayat')" data-bs-dismiss="modal">Batal</button>
                        <button id="play" type="button" class="btn btn-primary" data-bs-dismiss="modal">Ya</button>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($check_in_out !== "Gagal Memproses Absensi") : ?>
            <div class="container-fluid px-4 pt-3 mt-5">
                <div class="row">
                    <div class="col">
                        <h1 class="text-center my-3">Absensi</h1>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-8 col-sm-10">
                        <div class="well w-100" style="position: relative;display: inline-block;">
                            <canvas class="w-100 bg-dark" id="webcodecam-canvas"></canvas>
                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                        </div>

                        <div class="mb-3">
                            <select class="form-select text-capitalize" id="camera-select"></select>
                        </div>
                        <div class="form-group">
                            <button title="Mulai Scan" class="btn btn-primary w-100" type="button" data-toggle="tooltip">Mulai Scan</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>
        <?php endif ?>
    </main>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?= $BASE_URL ?>js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/filereader.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/qrcodelib.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/webcodecamjs.js"></script>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('modal'), {
            keyboard: false
        })

        modal.show();

        document.getElementById('sidebarToggle').remove();

        <?php if ($check_in_out !== "Gagal Memproses Absensi") : ?>
                (function(undefined) {
                    "use strict";

                    function Q(el) {
                        if (typeof el === "string") {
                            var els = document.querySelectorAll(el);
                            return typeof els === "undefined" ? undefined : els.length > 1 ? els : els[0];
                        }
                        return el;
                    }
                    var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
                    var scannerLaser = Q(".scanner-laser"),
                        scannedImg = Q("#scanned-img"),
                        play = Q("#play");

                    var args = {
                        autoBrightnessValue: 100,
                        resultFunction: function(res) {
                            [].forEach.call(scannerLaser, function(el) {
                                fadeOut(el, 0.5);
                                setTimeout(function() {
                                    fadeIn(el, 0.5);
                                }, 300);
                            });
                            window.location.replace(res.code + "/proses.php");
                            return;
                        },
                        getDevicesError: function(error) {
                            var p, message = "Error detected with the following parameters:\n";
                            for (p in error) {
                                message += p + ": " + error[p] + "\n";
                            }
                            alert(message);
                        },
                        getUserMediaError: function(error) {
                            var p, message = "Error detected with the following parameters:\n";
                            for (p in error) {
                                message += p + ": " + error[p] + "\n";
                            }
                            alert(message);
                        },
                        cameraError: function(error) {
                            var p, message = "Error detected with the following parameters:\n";
                            if (error.name == "NotSupportedError") {
                                var ans = confirm("Your browser does not support getUserMedia via HTTP!\n(see: https:goo.gl/Y0ZkNV).\n You want to see github demo page in a new window?");
                                if (ans) {
                                    window.open("https://andrastoth.github.io/webcodecamjs/");
                                }
                            } else {
                                for (p in error) {
                                    message += p + ": " + error[p] + "\n";
                                }
                                alert(message);
                            }
                        },
                        cameraSuccess: function() {

                        }
                    };
                    var decoder = new WebCodeCamJS("#webcodecam-canvas").buildSelectMenu("#camera-select", "environment|back").init(args);

                    play.addEventListener("click", function() {
                        if (!decoder.isInitialized()) {} else {
                            decoder.play();
                        }
                    }, false);

                    var getZomm = setInterval(function() {
                        var a;
                        try {
                            a = decoder.getOptimalZoom();
                        } catch (e) {
                            a = 0;
                        }
                        if (!!a && a !== 0) {
                            Page.changeZoom(a);
                            clearInterval(getZomm);
                        }
                    }, 500);

                    function fadeOut(el, v) {
                        el.style.opacity = 1;
                        (function fade() {
                            if ((el.style.opacity -= 0.1) < v) {
                                el.style.display = "none";
                                el.classList.add("is-hidden");
                            } else {
                                requestAnimationFrame(fade);
                            }
                        })();
                    }

                    function fadeIn(el, v, display) {
                        if (el.classList.contains("is-hidden")) {
                            el.classList.remove("is-hidden");
                        }
                        el.style.opacity = 0;
                        el.style.display = display || "block";
                        (function fade() {
                            var val = parseFloat(el.style.opacity);
                            if (!((val += 0.1) > v)) {
                                el.style.opacity = val;
                                requestAnimationFrame(fade);
                            }
                        })();
                    }
                    document.querySelector("#camera-select").addEventListener("change", function() {
                        if (decoder.isInitialized()) {
                            decoder.stop().play();
                        }
                    });
                }).call(window.Page = window.Page || {});

        <?php else : ?>
            document.getElementById('play').addEventListener('click', () => window.location.href = '<?= $BASE_URL ?>absensi/riwayat')
        <?php endif ?>
    </script>
</body>

</html>