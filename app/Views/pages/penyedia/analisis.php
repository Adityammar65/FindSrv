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

    <title>Analisis Jasa</title>
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
                <a class="navbar-brand" href="<?= base_url('home_penyedia') ?>">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-5 px-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home_penyedia') ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('dashboard') ?>">Dashboard Jasa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('daftar_pesanan') ?>">Daftar Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Riwayat</a>
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

        <div class="container my-4">
            <div class="mb-4">
                <h4 class="fw-bold mb-1">Analisis Jasa</h4>
                <small class="text-muted">
                    Data performa jasa Anda
                </small>
            </div>

            <!-- DETAIL JASA -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <img src="<?= base_url('uploads/jasa/' . $service['gambar_layanan']) ?>"
                                class="img-fluid rounded"
                                alt="Gambar Jasa">
                        </div>
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-1">
                                <?= esc($service['judul_jasa']) ?>
                            </h5>
                            <div class="mb-2">
                                <span class="badge bg-primary me-2">
                                    <?= esc($service['kategori']) ?>
                                </span>
                            </div>
                            <p class="text-muted small mb-0">
                                <?= esc(word_limiter($service['deskripsi_jasa'], 25)) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ANALYTIC -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <small class="text-muted">Jumlah Dilihat</small>
                            <h2 class="fw-bold text-primary mb-0">
                                <?= $analytic['jumlah_dilihat'] ?? 0 ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <small class="text-muted">Jumlah Pesanan</small>
                            <h2 class="fw-bold text-success mb-0">
                                <?= $analytic['jumlah_pesanan'] ?? 0 ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center">
            <div class="col-4">
                <a href="<?= base_url('dashboard') ?>"
                class="btn btn-primary w-100">
                    Kembali
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="bg-light mt-5 pt-5 fade-in-fwd">
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
                            <li><a href="<?= base_url('home_penyedia') ?>" class="text-decoration-none text-muted">Beranda</a></li>
                            <li><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">Dashboard Jasa</a></li>
                            <li><a href="<?= base_url('daftar_pesanan') ?>" class="text-decoration-none text-muted">Daftar Pesanan</a></li>
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