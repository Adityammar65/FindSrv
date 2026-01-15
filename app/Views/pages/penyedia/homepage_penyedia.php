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
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Beranda</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
        @media (max-width: 768px) {
            .navbar-brand img {
                width: 60px !important;
            }
            .navbar {
                padding: 0.75rem 0 !important;
            }
            .img-container {
                width: 95%;
            }
            .fade-text {
                font-size: 1.5rem;
                max-width: 45%;
            }
            .description .row {
                flex-direction: column;
            }
            .description .col-md-4 {
                width: 100% !important;
                margin-bottom: 1.5rem;
            }
            .business-process .container {
                flex-direction: column !important;
                align-items: center;
            }
            .business-process .card {
                margin: 1rem 0 !important;
                width: 100% !important;
                max-width: 20rem;
            }
        }
        @media (max-width: 576px) {
            .img-container {
                width: 100%;
            }
            .fade-text {
                font-size: 1.2rem;
                max-width: 50%;
                left: 3%;
            }
            .card-media {
                flex-direction: column;
            }
            .card-media img {
                width: 100%;
                border-radius: 0.375rem 0.375rem 0 0 !important;
            }
            .card-media .card {
                border-radius: 0 0 0.375rem 0.375rem !important;
            }
            h3.glass-bg {
                font-size: 1.5rem;
            }
            .business-process p.fs-4 {
                font-size: 1.1rem !important;
            }
        }
    </style>
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
    <div class="container-fluid fade-in-fwd p-0">
        
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light fw-bold">
            <div class="container-fluid ps-3 ps-md-5 pe-3 pe-md-5">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-md-5 px-md-5" id="navbarSupportedContent">
                    <?php if ($role === 'penyedia'): ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-6 fs-md-1">
                            <li class="nav-item d-flex flex-row align-items-center justify-content-between">
                                <a class="nav-link active" aria-current="page" href="<?= base_url('home_penyedia') ?>">Beranda</a>
                                <button type="button" class="btn p-0 d-md-none" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                                    <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                </button>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard Jasa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('daftar_pesanan') ?>">Daftar Pesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('riwayat') ?>">Riwayat Pesanan</a>
                            </li>
                        </ul>
                        <div class="profile-sidepanel ms-5">
                            <button type="button" class="btn p-0 d-none d-lg-block" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                                <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="70" height="70" style="object-fit: cover;">
                            </button>
                        </div>
                    <?php else: ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-6 fs-md-1">
                            <li class="nav-item d-flex flex-row align-items-center justify-content-between">
                                <a class="nav-link" aria-current="page" href="<?= base_url('home_pengguna') ?>">Beranda</a>
                                <button type="button" class="btn p-0 d-md-none" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                                    <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                </button>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('pencarian') ?>">Cari Jasa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('chat') ?>">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('riwayat') ?>">Riwayat Pesanan</a>
                            </li>
                        </ul>
                        <form action="<?= base_url('pencarian') ?>" method="get" class="d-flex mb-2 mb-lg-0 w-auto">
                            <input class="form-control me-2 w-100" type="search" placeholder="Cari Jasa" aria-label="Cari Jasa" name="keyword" style="width: auto; min-width: 150px;">
                            <button class="btn fw-bold btn-primary" type="submit">Cari</button>
                        </form>
                        <div class="profile-sidepanel ms-5">
                            <button type="button" class="btn p-0 d-none d-lg-block" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                                <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="70" height="70" style="object-fit: cover;">
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- BANNER -->
        <div class="img-container my-4">
            <img src="<?= base_url('assets/images/homepage/homepage_illustration_penyedia.jpeg') ?>" alt="Ilustrasi Homepage Penyedia">
            <div class="fade-text">
                <p>Selamat Datang di FindSrv!</p>
                <p class="fs-4 my-3">Punya keahlian menarik? Yuk, tawarkan jasa Anda di FindSrv dan nikmati kemudahan bertransaksi secara aman dengan konsumen</p>
            </div>
        </div>

        <h3 class="text-center m-0 py-5 glass-bg">Fitur Unggulan untuk Mendukung Proses Kerja yang Aman dan Efisien</h3>

        <!-- FEATURING CARD -->
        <div class="description mx-3 my-4 my-md-5">
            <div class="row g-3 g-md-4">
                <div class="col-12 col-md-4">
                    <div class="card-media">
                        <img src="<?= base_url('assets/images/homepage/terpercaya.jpg') ?>" class="rounded-start" alt="Terpercaya" style="height: 100%; object-fit: cover;">
                        <div class="card rounded-end">
                            <div class="card-body">
                                <h5 class="card-title">Terpercaya</h5>
                                <p class="card-text">
                                    Platform ini dirancang untuk menyediakan layanan yang aman, transparan, dan dapat dipercaya,
                                    sehingga Anda dapat menggunakan jasa dengan tenang dan percaya diri.
                                </p>
                            </div>
                        </div>
                    </div>             
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-media">
                        <img src="<?= base_url('assets/images/homepage/profesional.jpg') ?>" class="rounded-start" alt="Profesional" style="height: 100%; object-fit: cover;">
                        <div class="card rounded-end">
                            <div class="card-body">
                                <h5 class="card-title">Profesional</h5>
                                <p class="card-text">
                                    Nikmati layanan jasa dengan standar kerja yang terstruktur, efisien, dan berorientasi pada hasil,
                                    didukung perencanaan yang matang, komunikasi yang jelas, serta komitmen pada kualitas dan ketepatan waktu.
                                </p>
                            </div>
                        </div>
                    </div>             
                </div>
                <div class="col-12 col-md-4">
                    <div class="card-media">
                        <img src="<?= base_url('assets/images/homepage/komunikasi.jpg') ?>" class="rounded-start" alt="Komunikatif" style="height: 100%; object-fit: cover;">
                        <div class="card rounded-end">
                            <div class="card-body">
                                <h5 class="card-title">Komunikatif</h5>
                                <p class="card-text">
                                    Platform ini dirancang dengan sistem komunikasi yang jelas dan terstruktur, 
                                    memungkinkan proses negosiasi berlangsung lebih efektif, transparan, dan efisien.
                                </p>
                            </div>
                        </div>
                    </div>             
                </div>
            </div>
        </div>

        <!-- BUSINESS PROCESS -->
        <div class="business-process my-4 my-md-5">
            <h3 class="text-center glass-bg py-4 py-md-5 mb-4 mb-md-5">Bagaimana FindSrv Bekerja</h3>
            <p class="text-center fs-6 fs-md-5 fw-bold text-primary mb-4 mb-md-5">Proses mudah untuk menawarkan layanan profesional Anda</p>

            <div class="container d-flex flex-column flex-md-row justify-content-center">
                <div class="card card-process bg-primary bg-gradient m-2 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">1</h3>
                        <h5 class="card-title">Lengkapi Profilmu</h5>
                        <p class="card-text">Tampilkan keahlian terbaik Anda dengan unggah jasa untuk menarik minat konsumen</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient m-2 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">2</h3>
                        <h5 class="card-title">Buat Penawaran</h5>
                        <p class="card-text">Tentukan jenis layanan, harga, dan estimasi waktu kerja yang transparan</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient m-2 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">3</h3>
                        <h5 class="card-title">Diskusi dan Negosiasi</h5>
                        <p class="card-text">Diskusikan detail proyek dan lakukan negosiasi dengan konsumen melalui fitur chat</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient m-2 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">4</h3>
                        <h5 class="card-title">Selesaikan dan Terima Ulasan</h5>
                        <p class="card-text">Serahkan hasil pekerjaan dan terima pembayaran serta ulasan dari konsumen</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <section class="bg-primary bg-gradient text-white py-4 py-md-5">
            <div class="container text-center">
                <h3 class="fw-bold mb-3">
                    Siap Mengembangkan Karier Profesional Anda?                
                </h3>
                <p class="mb-4 fs-6 fs-md-5">
                    Tawarkan keahlian Anda dan jangkau lebih banyak konsumen di FindSrv
                </p>
                <div class="d-flex justify-content-center">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-light btn-lg fw-bold px-4 cta-card">
                        Unggah Jasa Sekarang
                    </a>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-light mt-5 pt-5 fade-in-fwd">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 mb-4">
                        <img src="<?= base_url('assets/images/icons/logo.png') ?>" alt="Logo" style="width: 90px;">
                        <p class="text-muted mt-3">FindSrv adalah platform yang menghubungkan pengguna dengan penyedia jasa profesional secara aman dan terpercaya.</p>
                    </div>
                    <div class="col-12 col-md-2 mb-4">
                        <h6 class="fw-bold">Menu</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('home_pengguna') ?>" class="text-decoration-none text-muted">Beranda</a></li>
                            <?php if ($role === 'pengguna'): ?>
                                <li><a href="<?= base_url('pencarian') ?>" class="text-decoration-none text-muted">Cari Jasa</a></li>
                            <?php else: ?>
                                <li><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">Dashboard Jasa</a></li>
                                <li><a href="<?= base_url('daftar_pesanan') ?>" class="text-decoration-none text-muted">Daftar Pesanan</a></li>
                            <?php endif; ?>
                            <li><a href="<?= base_url('chat') ?>" class="text-decoration-none text-muted">Chat</a></li>
                            <li><a href="<?= base_url('riwayat') ?>" class="text-decoration-none text-muted">Riwayat</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="fw-bold">Bantuan</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('bantuan') ?>" class="text-decoration-none text-muted">Pusat Bantuan</a></li>
                            <li><a href="<?= base_url('syarat_ketentuan') ?>" class="text-decoration-none text-muted">Syarat & Ketentuan</a></li>
                            <li><a href="<?= base_url('kebijakan') ?>" class="text-decoration-none text-muted">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="fw-bold">Kontak</h6>
                        <p class="text-muted mb-1">Email: support@findsrv.id</p>
                        <p class="text-muted">Instagram: @findsrv.id</p>
                    </div>
                </div>
                <hr>
                <div class="text-center text-muted pb-3">© 2025 FindSrv. All rights reserved.</div>
            </div>
        </footer>
    </div>
</body>
</html>