<?php

include('../app/functions/domain_name.php');
include('../app/functions/base_url.php');
include('../app/functions/db_connect.php');
include('../app/functions/query.php');
include('../app/functions/date_formatter.php');

if (!isset($_GET['id'])) header('Location: qr-code');

$code = $_GET['id'];

$result_laporan = mysqli_query($conn, "SELECT id FROM laporan WHERE qr_code = '$code' LIMIT 1");
if (!mysqli_fetch_assoc($result_laporan)) {
  header("Location: qr-code?id=$code");
}

$result_laporan = query("SELECT * FROM laporan WHERE qr_code = '$code' LIMIT 1")[0];

$kode_laporan = $result_laporan['id'];

$result_pelapor = query("SELECT * FROM pelapor WHERE kode_laporan = '$kode_laporan'");
$result_tersangka = query("SELECT * FROM tersangka WHERE kode_laporan = '$kode_laporan'");
$result_barang_bukti = query("SELECT * FROM barang_bukti WHERE kode_laporan = '$kode_laporan'");
$result_perkembangan_kasus = query("SELECT * FROM perkembangan_kasus WHERE kode_laporan = '$kode_laporan'");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>SIMPANAN | QR Code Scan</title>
  <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/mdi/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.css" />
  <link rel="stylesheet" href="<?= $BASE_URL ?>scan/css/style.css" />
</head>

<body id="deskripsi-kasus">
  <div class="container-scroller">

    <?php include('nav/navbar.php') ?>

    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="container">
          <div class="content-wrapper">

            <div class="row mt-md-5 mt-lg-0 pt-md-5 pt-lg-0">
              <div class="col-lg-9 mt-md-5 mt-lg-0 pt-md-3 pt-lg-0 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                  <div class="card-body sale-diffrence-border">
                    <h4 class="card-title">Deskripsi Kasus</h4>
                    <p><b><?= $result_laporan['judul_laporan'] ?></b></p>
                    <p class="card-description">
                      <?= $result_laporan['keterangan'] ?>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 mt-md-3 mt-lg-0 grid-margin grid-margin-md-0 stretch-card">
                <div class="card">
                  <div class="card-body sale-visit-statistics-border">
                    <h4 class="h2 font-weight-bold card-title mb-1">Status</h4>
                    <p class="pb-0 mb-0 mb-2 font-weight-bold">
                    <div class="badge <?= $result_laporan['status'] === 'selesai' ? "badge-success" : ($result_laporan['status'] === 'sementara diproses' ? "badge-warning" : "badge-danger"); ?> mb-1"><?= $result_laporan['status'] ?></div>
                    </p>
                    <p class="card-description text-small text-muted" id="pihak-terlibat">Laporan ini diterima pada tanggal <b><?= dateFormatter($result_laporan['created_at']) ?></b>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body sale-visit-statistics-border pb-5">
                    <h4 class="card-title">Pihak Terlibat</h4>
                    <p><b>1. Pelapor</b></p>
                    <p class="card-description">
                      Adapun pelapor dalam kasus ini sebagai berikut : </p>
                    <div class="table-responsive py-3 mb-3">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Domisili</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0;
                          foreach ($result_pelapor as $pelapor) : $i++; ?>
                            <tr class="text-center">
                              <td><?= $i ?></td>
                              <td><?= $pelapor['nama_lengkap'] ?></td>
                              <td><?= $pelapor['tempat_lahir'] !== "" ? $pelapor['tempat_lahir'] : "-" ?></td>
                              <td><?= $pelapor['tanggal_lahir'] !== "0000-00-00" ? dateFormatter($pelapor['tanggal_lahir']) : "-" ?></td>
                              <td><?= $pelapor['domisili'] !== "" ? $pelapor['domisili'] : "-" ?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>

                    <p><b>2. Tersangka</b></p>
                    <p class="card-description">
                      Adapun tersangka dalam kasus ini sebagai berikut : </p>
                    <div class="table-responsive pt-3">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Domisili</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0;
                          foreach ($result_tersangka as $tersangka) : $i++; ?>
                            <tr class="text-center">
                              <td><?= $i ?></td>
                              <td><?= $tersangka['nama_lengkap'] ?></td>
                              <td><?= $tersangka['tempat_lahir'] !== "" ? $tersangka['tempat_lahir'] : "-" ?></td>
                              <td><?= $tersangka['tanggal_lahir'] !== "0000-00-00" ? dateFormatter($tersangka['tanggal_lahir']) : "-" ?></td>
                              <td><?= $tersangka['domisili'] !== "" ? $tersangka['domisili'] : "-" ?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                        <div id="barang-bukti"></div>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body sale-diffrence-border pb-5">
                    <h4 class="card-title">Barang Bukti</h4>
                    <p class="card-description">
                      Adapun barang bukti dalam kasus ini sebagai berikut : </p>
                    <div class="table-responsive py-3 mb-3">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Barang Bukti</th>
                            <th>Jumlah / Kuantitas</th>
                            <th>Keterangan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0;
                          foreach ($result_barang_bukti as $barang_bukti) : $i++; ?>
                            <tr>
                              <td class="text-center"><?= $i ?></td>
                              <td class="text-center"><?= $barang_bukti['nama_barang_bukti'] ?></td>
                              <td class="text-center"><?= $barang_bukti['kuantitas'] ?></td>
                              <td class="text-center"><?= $barang_bukti['keterangan'] ?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                      <div id="perkembangan-kasus"></div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="row my-4">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body sale-visit-statistics-border pb-5">
                    <h4 class="card-title">Perkembangan Kasus</h4>
                    <p class="card-description">
                      Perkembangan kasus dapat dilihat pada tabel berikut : </p>
                    <div class="table-responsive py-3 mb-3">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Tanggal Ditambahkan</th>
                            <th>Terakhir Diperbarui</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0;
                          foreach ($result_perkembangan_kasus as $perkembangan_kasus) : $i++; ?>
                            <tr>
                              <td class="text-center"><?= $i ?></td>
                              <td><?= $perkembangan_kasus['judul'] ?></td>
                              <td class="text-center"><?= dateFormatter($perkembangan_kasus['created_at']) ?></td>
                              <td class="text-center"><?= dateFormatter($perkembangan_kasus['updated_at']) ?></td>
                              <td class="text-center"><a href="<?= $BASE_URL ?>scan/perkembangan-kasus.php?id=<?= $code ?>&get=<?= $perkembangan_kasus['id'] ?>" class="btn btn-primary btn-rounded">Lihat Detail</a></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include('footer/footer.php') ?>
      </div>
    </div>
  </div>
  <script src="<?= $BASE_URL ?>scan/vendors/base/vendor.bundle.base.js"></script>
  <script src="<?= $BASE_URL ?>scan/js/template.js"></script>
  <script src="<?= $BASE_URL ?>scan/vendors/justgage/raphael-2.1.4.min.js"></script>
  <script src="<?= $BASE_URL ?>scan/vendors/justgage/justgage.js"></script>
  <script>
    function toggleNav() {
      document.getElementById('nav').classList.toggle('header-toggled');
    }
  </script>

</body>

</html>