<?php

include('../../app/functions/domain_name.php');
include('../../app/functions/base_url.php');
include('../../app/functions/db_connect.php');
include('../../app/functions/query.php');
include('../../app/functions/date_formatter.php');

?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIMPANAN | Tentang Sistem</title>
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.css" />
    <link rel="stylesheet" href="<?= $BASE_URL ?>scan/css/style.css" />
</head>

<body class="m-0 p-0">

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    <button id="play" type="button" class="btn btn-link btn-lg text-decoration-none">
                        <div>
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
                        </div>
                    </button>
                    <div id="camera-container" class="well w-100 d-none" style="position: relative;display: inline-block;">
                        <canvas class="w-100 bg-dark" id="webcodecam-canvas"></canvas>
                        <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                    </div>

                    <div class="my-3">
                        <select class="form-select text-capitalize d-none" id="camera-select"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-size-cover" style="background-image: url('<?= $BASE_URL ?>assets/img/bg-login.jpg');">
        <div class="bg-primary bg-opacity-75 bg-gradient">
            <div class="container">
                <div class="row align-items-center" style="min-height:100vh">
                    <div class="col-12 col-lg-6 col-xl-8 py-3 mb-5">
                        <h1 class="text-white lh-base fw-bold d-none d-lg-block display-1">SIMPANAN</h1>
                        <p class="text-white card-description lh-lg fs-5"><b>Sistem Informasi Manajemen Pengaduan Tindak Pidana dan Pelanggaran (SIMPANAN)</b> Berbasis QR Code merupakan suatu sistem yang memungkinkan masyarakat untuk memantau perkembangan kasus yang dilaporkan melalui QR Code.</p>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-light text-primary btn-lg fs-5 mt-3 fw-bold shadow-lg rounded-pill">Scan Sekarang !</button>
                    </div>
                    <div class="col-12 col-sm-8 offset-sm-2 offset-lg-0 col-lg-6 col-xl-4 order-first order-lg-last">
                        <h1 class="text-white mt-5 text-center d-block d-lg-none lh-base fw-bold display-1">SIMPANAN</h1>
                        <img src="../../assets/img/vector-3.png" class="w-100 my-5" alt="Sistem Informasi Manajemen Pengaduan Tindak Pidana">
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.js"></script>
    <script src="<?= $BASE_URL ?>scan/js/template.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="<?= $BASE_URL ?>scan/vendors/justgage/justgage.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/filereader.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/qrcodelib.js"></script>
    <script src="<?= $BASE_URL ?>vendor/qrcode-reader/webcodecamjs.js"></script>
    <script>
        function submitQrCode() {
            document.getElementById('submitQrCode').submit();
        }

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
                play = Q("#play"),
                cameraContainer = Q("#camera-container"),
                cameraSelect = Q("#camera-select");

            var args = {
                autoBrightnessValue: 100,
                resultFunction: function(res) {
                    [].forEach.call(scannerLaser, function(el) {
                        fadeOut(el, 0.5);
                        setTimeout(function() {
                            fadeIn(el, 0.5);
                        }, 300);
                    });
                    window.location.replace(res.code);
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
                    play.classList.add('d-none')
                    cameraContainer.classList.remove('d-none');
                    cameraSelect.classList.remove('d-none');
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
    </script>

</body>

</html>