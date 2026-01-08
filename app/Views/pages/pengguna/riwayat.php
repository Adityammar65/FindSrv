<?php
$session = session();

$username = $session->get('username');
$role = $session->get('role');
$photo = $session->get('foto_profil');

$profilePhoto = $photo && file_exists(FCPATH . 'uploads/profile/' . $photo)
    ? base_url('uploads/profile/' . $photo)
    : base_url('assets/images/icons/profile.png');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Riwayat</title>
</head>

<!-- SIDEPANEL -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body text-center">
        <img src="<?= $profilePhoto ?>"
            alt="User Profile"
            class="rounded-circle"
            width="60"
            height="60"
            style="object-fit: cover;">

        <h6 class="fw-bold"><?= esc($username) ?></h6>
        <p class="text-muted"><?= esc($role) ?> jasa</p>
        <hr>
        <ul class="list-group list-group-flush text-start">
            <li class="list-group-item">
                <a href="<?= base_url('pengaturan') ?>" class="text-decoration-none text-dark">
                    Pengaturan
                </a>
            </li>
            <li class="list-group-item">
                <a href="<?= base_url('logout') ?>" class="text-danger fw-bold text-decoration-none">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<body>
    <div class="container-fluid p-0 fade-in-fwd">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light fw-bold" style="width: 100%;">
            <div class="container-fluid mx-5">
                <a class="navbar-brand" href="<?= base_url('home_pengguna') ?>">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-5 px-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home_pengguna') ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pencarian') ?>">Cari Jasa</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Riwayat</a>
                        </li>
                    </ul>
                    <div class="profile-sidepanel">
                        <button type="button" class="btn p-0" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                            <img src="<?= $profilePhoto ?>"
                                alt="User Profile"
                                class="rounded-circle"
                                width="60"
                                height="60"
                                style="object-fit: cover;">
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <h3 class="fw-bold m-4">Riwayat Pesanan</h3>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                Kamu belum memiliki riwayat pesanan.
            </div>
        <?php else: ?>
            <div class="list-group mx-3 px-3">
            <?php foreach ($orders as $order): ?>
                <div class="list-group-item p-3 mb-2 shadow-sm border-0 rounded-3">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="<?= $order['gambar_layanan']
                                ? base_url('uploads/jasa/' . $order['gambar_layanan'])
                                : base_url('assets/images/default-service.jpg') ?>"
                                class="img-fluid rounded"
                                style="height:90px; width:100%; object-fit:cover;">
                        </div>
                        <div class="col-md-7">
                            <h6 class="fw-bold mb-1">
                                <?= esc($order['judul_jasa']) ?>
                            </h6>
                            <p class="small text-muted mb-1">
                                Tanggal:
                                <?= date('d M Y', strtotime($order['tanggal_order'])) ?>
                            </p>
                            <p class="small mb-2">
                                <?= esc($order['deskripsi_permintaan']) ?>
                            </p>
                            <span class="badge
                                <?php
                                    if ($order['status_pesanan'] === 'dalam proses') echo 'bg-warning';
                                    elseif ($order['status_pesanan'] === 'selesai') echo 'bg-success';
                                    else echo 'bg-danger';
                                ?>">
                                <?= ucfirst($order['status_pesanan']) ?>
                            </span>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="<?= base_url('detail_jasa/' . $order['id_service']) ?>"
                            class="btn btn-outline-primary btn-sm">
                                Lihat Jasa
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <?php endif; ?>

        <!-- FOOTER -->
        <footer class="bg-light mt-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 90px;">
                        <p class="text-muted mt-3">
                            FindSrv adalah platform yang menghubungkan pengguna dengan
                            penyedia jasa profesional secara aman dan terpercaya.
                        </p>
                    </div>
                    <div class="col-md-2 mb-4">
                        <h6 class="fw-bold">Menu</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('home_pengguna') ?>" class="text-decoration-none text-muted">Beranda</a></li>
                            <li><a href="<?= base_url('pencarian') ?>" class="text-decoration-none text-muted">Cari Jasa</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Riwayat</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h6 class="fw-bold">Bantuan</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('bantuan') ?>" class="text-decoration-none text-muted">Pusat Bantuan</a></li>
                            <li><a href="<?= base_url('syarat_ketentuan') ?>" class="text-decoration-none text-muted">Syarat & Ketentuan</a></li>
                            <li><a href="<?= base_url('kebijakan') ?>" class="text-decoration-none text-muted">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h6 class="fw-bold">Kontak</h6>
                        <p class="text-muted mb-1">Email: support@findsrv.id</p>
                        <p class="text-muted">Instagram: @findsrv.id</p>
                    </div>
                </div>
                <hr>
                <div class="text-center text-muted pb-3">
                    © 2025 FindSrv. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>
</html>