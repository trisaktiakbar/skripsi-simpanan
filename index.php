<?php

include('app/functions/base_url.php');
include('app/functions/db_connect.php');
include('app/functions/query.php');
include('app/functions/user_auth.php');
include('app/functions/date_formatter.php');

$result_jumlah_laporan = query("SELECT status, COUNT(*) AS count FROM laporan GROUP BY status");

$jumlah_belum_diproses = 0;
$jumlah_sementara_proses = 0;
$jumlah_selesai = 0;

foreach ($result_jumlah_laporan as $jumlah_laporan) {
    if ($jumlah_laporan['status'] == "belum diproses") {
        $jumlah_belum_diproses = $jumlah_laporan['count'];
    } else if ($jumlah_laporan['status'] == "sementara proses") {
        $jumlah_sementara_proses = $jumlah_laporan['count'];
    } else if ($jumlah_laporan['status'] == "selesai") {
        $jumlah_selesai = $jumlah_laporan['count'];
    }
}

$result_laporan_masuk = query("SELECT * , DATEDIFF(created_at, CURDATE()) AS date FROM laporan");
$date = date('Y-m-d');

$result_statistics = [];
for ($i = -6; $i <= 0; $i++) {
    $result_statistics[$i]['count'] = 0;
    $result_statistics[$i]['day'] = date('D', strtotime($i . ' day', strtotime($date)));;
}

foreach ($result_laporan_masuk as $laporan_masuk) {
    if ($laporan_masuk['date'] >= -6 && $laporan_masuk['date'] <= 0) {
        $result_statistics[$laporan_masuk['date']]['count']++;
    }
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
    <title>SIMPANAN | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('nav/navbar.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <?php include('nav/sidenav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main class="mb-5">
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4 .card-border-bottom-normal">
                                <div class="card-body text-center">
                                    <h1 class="display-1"><?= $jumlah_belum_diproses + $jumlah_sementara_proses + $jumlah_selesai ?></h1>
                                    <p>Semua Laporan</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= $BASE_URL ?>laporan">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4 .card-border-bottom-normal">
                                <div class="card-body text-center">
                                    <h1 class="display-1"><?= $jumlah_belum_diproses ?></h1>
                                    <p>Belum Diproses</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= $BASE_URL ?>laporan/unprocessed.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body text-center">
                                    <h1 class="display-1"><?= $jumlah_sementara_proses ?></h1>
                                    <p>Sementara Proses</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= $BASE_URL ?>laporan/on-processing.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body text-center">
                                    <h1 class="display-1"><?= $jumlah_selesai ?></h1>
                                    <p>Laporan Selesai</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= $BASE_URL ?>laporan/completed.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card my-4 card-border-bottom-primary">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Statistik Laporan Diterima (Berdasarkan Waktu)
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                <div class="card-footer small text-muted">Last Updated&ensp;<?= dateFormatter($date) ?></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card my-4 card-border-bottom-danger">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Statistik Keseluruhan Laporan (Berdasarkan Status)
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
                                <div class="card-footer small text-muted">Last Updated&ensp;<?= dateFormatter($date) ?></div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include('footer/footer.php') ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#292b2c";

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: [
                    <?php foreach ($result_jumlah_laporan as $jumlah_laporan) {
                        echo "\"" . ucwords($jumlah_laporan['status']) . "\",";
                    } ?>
                ],
                datasets: [{
                    data: [
                        <?php foreach ($result_jumlah_laporan as $jumlah_laporan) {
                            echo $jumlah_laporan['count'] . ",";
                        } ?>
                    ],

                    backgroundColor: [
                        <?php foreach ($result_jumlah_laporan as $jumlah_laporan) {
                            if ($jumlah_laporan['status'] === "belum diproses") {
                                echo "'#dc3545',";
                            } else if ($jumlah_laporan['status'] === "sementara proses") {
                                echo "'#ffc107',";
                            } else if ($jumlah_laporan['status'] === "selesai") {
                                echo "'#28a745',";
                            }
                        } ?>
                    ],


                }, ],
            },
        });

        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php foreach ($result_statistics as $statistics) {
                        echo '"' . $statistics['day'] . '", ';
                    } ?>
                ],
                datasets: [{
                    label: "Jumlah Laporan",
                    backgroundColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(255,193,7,1)"],
                    borderColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(255,193,7,1)"],
                    data: [
                        <?php foreach ($result_statistics as $statistics) {
                            echo $statistics['count'] . ', ';
                        } ?>
                    ],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'day'
                        },
                        gridLines: {
                            display: false
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            stepSize: 1
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        document.getElementById('nav-link-dashboard').classList.add('active');
    </script>
</body>

</html>