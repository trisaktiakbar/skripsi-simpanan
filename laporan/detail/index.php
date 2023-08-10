<?php

include('../../app/functions/db_connect.php');
include('../../app/functions/base_url.php');
include('../../app/functions/upload_file.php');
include('../../app/functions/query.php');
include('../../app/functions/user_auth.php');
include('../../app/functions/detail_date_formatter.php');
include('../../app/functions/date_formatter.php');

$code = $_GET['id'];
$result_laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE qr_code='$code'");

if (!mysqli_fetch_assoc($result_laporan)) {
    header('Location: ..');
} else {
    $result_laporan = query("SELECT * FROM laporan WHERE qr_code='$code'")[0];
}

$result_pelapor = query("SELECT * FROM pelapor WHERE kode_laporan = " . $result_laporan['id']);
$result_tersangka = query("SELECT * FROM tersangka WHERE kode_laporan = " . $result_laporan['id']);
$result_barang_bukti = query("SELECT * FROM barang_bukti WHERE kode_laporan = " . $result_laporan['id']);
$result_perkembangan_kasus = query("SELECT * FROM perkembangan_kasus WHERE kode_laporan = " . $result_laporan['id']);

if (isset($_POST['submit'])) {
    $status = $_POST['radioStatus'];
    mysqli_query(
        $conn,
        "UPDATE laporan SET status = '$status' WHERE qr_code = '$code'"
    );
    header("Refresh: 0");
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
    <title>SIMPANAN | Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= $BASE_URL ?>css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include('../../nav/navbar.php') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <?php include('../../nav/sidenav.php') ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $BASE_URL ?>laporan" class="text-decoration-none">Laporan</a></li>
                        <li class="breadcrumb-item active"><?= $result_laporan['judul_laporan'] ?></li>
                    </ol>

                    <div class="card mb-4 p-lg-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col">
                                            <h3><?= $result_laporan['judul_laporan'] ?></h3>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <a href="<?= $BASE_URL ?>laporan" class=" mb-1 btn btn-success btn-sm"><i class="fas fa-chevron-left"></i>&ensp;Kembali</a>
                                            <a href="<?= $BASE_URL ?>laporan/edit?id=<?= $code ?>" class=" mb-1 btn btn-warning btn-sm"><i class="fas fa-pen"></i>&ensp;Sunting</a>

                                            <button class="btn btn-danger btn-sm dropdown-toggle mb-1" type="button" id="dropdownPrint" data-bs-toggle="dropdown" aria-expanded="false">
                                                Cetak
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownPrint">
                                                <li><a class="dropdown-item" href="<?= $BASE_URL ?>laporan/detail/cetak.php?id=<?= $code ?>"><i class="far fa-file"></i>&ensp;Laporan</a></li>
                                                <li><a class="dropdown-item" href="<?= $BASE_URL ?>app/data/file/surat-pengantar/<?= $result_laporan['surat_pengantar'] ?>"><i class="fa-regular fa-file-lines"></i>&ensp;Surat Pengantar</a></li>
                                            </ul>

                                            <button class=" mb-1 btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="modal" data-bs-target="#ubahStatusModal" title="Ubah Status">Ubah Status&ensp;</button>

                                            <div class="modal fade" id="ubahStatusModal" tabindex="-1" aria-labelledby="ubahStatusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ubahStatusModalLabel">Status Laporan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="modal-body px-lg-5">
                                                                <div class="form-check my-2">
                                                                    <input class="form-check-input" type="radio" name="radioStatus" value="belum diproses" id="radioStatus1" <?= $result_laporan['status'] === "belum diproses" ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="radioStatus1">
                                                                        Belum Diproses
                                                                    </label>
                                                                </div>
                                                                <div class="form-check my-2">
                                                                    <input class="form-check-input" type="radio" name="radioStatus" value="sementara proses" id="radioStatus2" <?= $result_laporan['status'] === "sementara proses" ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="radioStatus2">
                                                                        Sementara Proses
                                                                    </label>
                                                                </div>
                                                                <div class="form-check my-2">
                                                                    <input class="form-check-input" type="radio" name="radioStatus" value="selesai" id="radioStatus3" <?= $result_laporan['status'] === "selesai" ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="radioStatus3">
                                                                        Selesai
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" id="submit" name="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i>&ensp;Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <p class="small text-muted">Laporan diterima pada <b><?= detailDateFormatter($result_laporan['created_at']) ?></b>, Terakhir diperbarui pada <b><?= detailDateFormatter($result_laporan['updated_at']) ?></b></p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <p><?= $result_laporan['keterangan'] ?></p>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <p class="text-muted small">Status : <span class="badge rounded-pill px-2 <?= $result_laporan['status'] === "belum diproses" ? "bg-danger" : ($result_laporan['status'] === "sementara proses" ? "bg-warning text-dark" : "bg-success") ?>"><?= ucwords($result_laporan['status']) ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                    <img class="w-100" src="<?= $BASE_URL ?>app/data/qr-code/<?= $result_laporan['qr_code'] ?>.png" alt="<?= $result_laporan['judul_laporan'] ?>">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="card border-warning mb-4">
                                        <div class="card-header border-warning bg-warning">
                                            <i class="fas fa-user-shield"></i>
                                            Entri Perkembangan Kasus
                                        </div>
                                        <div class="card-body px-lg-5">
                                            <a href="<?= $BASE_URL ?>laporan/detail/perkembangan-kasus/tambah.php?id=<?= $code ?>" class="btn btn-warning btn-sm mb-3"><i class="fas fa-plus"></i>&ensp;Tambah</a>

                                            <table class="table-striped" id="datatablesSimple">
                                                <thead>
                                                    <tr>

                                                        <th>Judul</th>
                                                        <th>Tanggal</th>
                                                        <th>Terakhir Diperbarui</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>

                                                        <th>Judul</th>
                                                        <th>Tanggal</th>
                                                        <th>Terakhir Diperbarui</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    foreach ($result_perkembangan_kasus as $perkembangan_kasus) : ?>
                                                        <tr class="text-center">

                                                            <td class="align-middle"><?= $perkembangan_kasus['judul'] ?></td>
                                                            <td class="align-middle"><?= dateFormatter($perkembangan_kasus['created_at']) ?></td>
                                                            <td class="align-middle"><?= dateFormatter($perkembangan_kasus['updated_at']) ?></td>
                                                            <td class="align-middle">
                                                                <a href="<?= $BASE_URL ?>laporan/detail/perkembangan-kasus/view.php?id=<?= $code ?>&get=<?= $perkembangan_kasus['id'] ?>" class="btn btn-sm btn-warning m-1">Lihat Detail</a>
                                                            </td>
                                                        </tr>

                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card border-primary mb-4">
                                        <div class="card-header border-primary bg-primary text-white">
                                            <i class="fas fa-user-shield"></i>
                                            Barang Bukti
                                        </div>
                                        <div class="card-body px-lg-5">
                                            <a href="<?= $BASE_URL ?>laporan/detail/barang-bukti/tambah.php?id=<?= $code ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus"></i>&ensp;Tambah</a>

                                            <table class="table-striped" id="datatablesSimple2">
                                                <thead>
                                                    <tr>

                                                        <th>Nama Barang Bukti</th>
                                                        <th>Kuantitas</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>

                                                        <th>Nama Barang Bukti</th>
                                                        <th>Kuantitas</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    foreach ($result_barang_bukti as $barang_bukti) : ?>
                                                        <tr class="text-center">

                                                            <td class="align-middle"><?= $barang_bukti['nama_barang_bukti'] ?></td>
                                                            <td class="align-middle"><?= $barang_bukti['kuantitas'] == 0 ? "-" : $barang_bukti['kuantitas'] ?></td>
                                                            <td class="align-middle">
                                                                <a href="<?= $BASE_URL ?>laporan/detail/barang-bukti/view.php?id=<?= $code ?>&get=<?= $barang_bukti['id'] ?>" class="btn btn-sm btn-primary m-1">Lihat Detail</a>
                                                                <button data-bs-toggle="modal" data-bs-target="#DeleteBarangBuktiModal<?= $barang_bukti['id'] ?>" title="Hapus" class="btn btn-sm btn-outline-primary m-1"><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>

                                                        <div class="modal fade" id="DeleteBarangBuktiModal<?= $barang_bukti['id'] ?>" tabindex="-1" aria-labelledby="DeleteBarangBuktiModal<?= $barang_bukti['id'] ?>Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="DeleteBarangBuktiModal<?= $barang_bukti['id'] ?>Label">Hapus Barang Bukti ?</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Yakin ingin menghapus barang bukti <b><?= $barang_bukti['nama_barang_bukti'] ?></b> ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="button" class="btn btn-primary" onclick="window.location.replace('<?= $BASE_URL ?>laporan/detail/barang-bukti/hapus.php?id=<?= $code ?>&get=<?= $barang_bukti['id'] ?>')"><i class="fas fa-trash"></i>&ensp;Hapus</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card border-success mb-4">
                                        <div class="card-header border-success bg-success text-white">
                                            <i class="fas fa-user-shield"></i>
                                            Pelapor
                                        </div>
                                        <div class="card-body px-lg-5">
                                            <a href="<?= $BASE_URL ?>laporan/detail/pelapor/tambah.php?id=<?= $code ?>" class="btn btn-success btn-sm mb-3"><i class="fas fa-plus"></i>&ensp; Tambah</a>

                                            <table class="table-striped" id="datatablesSimple3">
                                                <thead>
                                                    <tr>

                                                        <th>Nama Lengkap</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>

                                                        <th>Nama Lengkap</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    foreach ($result_pelapor as $pelapor) : ?>
                                                        <tr class="text-center">

                                                            <td class="align-middle"><?= $pelapor['nama_lengkap'] ?></td>
                                                            <td class="align-middle">
                                                                <a class="btn btn-sm btn-success my-1" href="<?= $BASE_URL ?>laporan/detail/pelapor/view.php?id=<?= $code ?>&get=<?= $pelapor['id'] ?>">Lihat Detail</a>
                                                                <button data-bs-toggle="modal" data-bs-target="#DeletePelaporModal<?= $pelapor['id'] ?>" title="Hapus" class="btn btn-sm btn-outline-success m-1"><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>

                                                        <div class="modal fade" id="DeletePelaporModal<?= $pelapor['id'] ?>" tabindex="-1" aria-labelledby="DeletePelaporModal<?= $pelapor['id'] ?>Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="DeletePelaporModal<?= $pelapor['id'] ?>Label">Hapus Data Pelapor ?</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Yakin ingin menghapus pelapor <b><?= $pelapor['nama_lengkap'] ?></b> ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="button" class="btn btn-success" onclick="window.location.replace('<?= $BASE_URL ?>laporan/detail/pelapor/hapus.php?id=<?= $code ?>&get=<?= $pelapor['id'] ?>')"><i class="fas fa-trash"></i>&ensp;Hapus</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card border-danger mb-4">
                                        <div class="card-header border-danger bg-danger text-white">
                                            <i class="fa-solid fa-user-pen"></i>
                                            Tersangka
                                        </div>
                                        <div class="card-body px-lg-5">
                                            <a href="<?= $BASE_URL ?>laporan/detail/tersangka/tambah.php?id=<?= $code ?>" class="btn btn-danger btn-sm mb-3"><i class="fas fa-plus"></i>&ensp; Tambah</a>
                                            <table class="table-striped" id="datatablesSimple4">
                                                <thead>
                                                    <tr>

                                                        <th>Nama Lengkap</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>

                                                        <th>Nama Lengkap</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    foreach ($result_tersangka as $tersangka) : ?>
                                                        <tr class="text-center">

                                                            <td class="align-middle"><?= $tersangka['nama_lengkap'] ?></td>
                                                            <td class="align-middle">
                                                                <a class="btn btn-sm btn-danger my-1" href="<?= $BASE_URL ?>laporan/detail/tersangka/view.php?id=<?= $code ?>&get=<?= $tersangka['id'] ?>">Lihat Detail</a>
                                                                <button data-bs-toggle="modal" data-bs-target="#DeleteTersangkaModal<?= $tersangka['id'] ?>" title="Hapus" class="btn btn-sm btn-outline-danger m-1"><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>

                                                        <div class="modal fade" id="DeleteTersangkaModal<?= $tersangka['id'] ?>" tabindex="-1" aria-labelledby="DeleteTersangkaModal<?= $tersangka['id'] ?>Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="DeleteTersangkaModal<?= $tersangka['id'] ?>Label">Hapus Data Tersangka ?</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Yakin ingin menghapus tersangka <b><?= $tersangka['nama_lengkap'] ?></b> ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="button" class="btn btn-danger" onclick="window.location.replace('<?= $BASE_URL ?>laporan/detail/tersangka/hapus.php?id=<?= $code ?>&get=<?= $tersangka['id'] ?>')"><i class="fas fa-trash"></i>&ensp;Hapus</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
            </main>
            <?php include('../../footer/footer.php') ?>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@5" crossorigin="anonymous"></script>
    <script src="<?= $BASE_URL ?>js/datatables-simple-demo.js"></script>
    <script src="<?= $BASE_URL ?>js/scripts.js"></script>

    <script>
        const nav_collapse_laporan = document.getElementById('nav-collapse-laporan');
        nav_collapse_laporan.classList.remove('collapsed');
        nav_collapse_laporan.classList.add('active');
        nav_collapse_laporan.setAttribute('aria-expanded', true);

        const collapse_layout_laporan = document.getElementById('collapse-layout-laporan');
        collapse_layout_laporan.classList.add('show');

        const nav_link_semua_laporan = document.getElementById('nav-link-semua-laporan');
        nav_link_semua_laporan.classList.add('active');
    </script>
</body>

</html>