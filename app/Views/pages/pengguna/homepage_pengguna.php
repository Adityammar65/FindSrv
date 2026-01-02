<?php
$session = session();

$username = $session->get('username');
$email    = $session->get('email');
$photo    = $session->get('foto_profil');

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

    <title>Beranda</title>
</head>

<div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Profil Pengguna</h5>
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
        <p class="text-muted"><?= esc($email) ?></p>

        <hr>

        <ul class="list-group list-group-flush text-start">
            <li class="list-group-item">
                <a href="<?= base_url('profile') ?>" class="text-decoration-none text-dark">
                    Profil Saya
                </a>
            </li>
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
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light fw-bold" style="width: 100%;">
            <div class="container-fluid mx-5">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-5 px-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cari Jasa</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Riwayat</a>
                        </li>
                    </ul>
                    <form class="d-flex mx-5 px-5">
                        <input class="form-control me-2" type="search" placeholder="Cari Jasa" aria-label="Cari Jasa" style="width: 300px;">
                        <button class="btn fw-bold btn-primary px-4" type="submit">Cari</button>
                    </form>
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

        <!-- BANNER -->
        <div class="img-container my-4">
            <img src="<?= base_url('assets/images/homepage/homepage_illustration.jpg') ?>">
            <div class="fade-text">
                <p>Selamat Datang di FindSrv!</p>
                <p class="fs-4 my-3">Akses berbagai layanan profesional dengan proses yang cepat dan aman</p>
            </div>
        </div>

        <h3 class="text-center m-0 py-5 glass-bg">Fitur Unggulan untuk Mendukung Proses Kerja yang Aman dan Efisien</h3>

        <!-- FEATURING CARD -->
        <div class="row description mx-3 my-5">
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/terpercaya.jpg') ?>" class="rounded-start">
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
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/profesional.jpg') ?>" class="rounded-start">
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
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/komunikasi.jpg') ?>" class="rounded-start">
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

        <!-- BUSINESS PROCESS -->
        <div class="business-process my-5">
            <h3 class="text-center glass-bg py-5 mb-5">Bagaimana FindSrv Bekerja</h3>
            <p class="text-center fs-4 fw-bold text-primary">Proses mudah untuk menemukan layanan profesional sesuai kebutuhan Anda</p>

            <div class="container d-flex flex-row justify-content-center my-5">
                <div class="card card-process bg-primary bg-gradient mx-4 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">1</h3>
                        <h5 class="card-title">Cari Jasa</h5>
                        <p class="card-text">Temukan layanan jasa sesuai kebutuhan Anda</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient mx-4 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">2</h3>
                        <h5 class="card-title">Review Penyedia Jasa</h5>
                        <p class="card-text">Review profil dan ulasan penyedia jasa</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient mx-4 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">3</h3>
                        <h5 class="card-title">Diskusi dan Pesan</h5>
                        <p class="card-text">Lakukan komunikasi dan negosiasi sebelum melakukan pemesanan</p>
                    </div>
                </div>
                <div class="card card-process bg-primary bg-gradient mx-4 py-2" style="width: 18rem;">
                    <div class="card-body text-center text-light">
                        <h3 class="fw-bold my-3">4</h3>
                        <h5 class="card-title">Selesaikan dan Ulas</h5>
                        <p class="card-text">Terima hasil dan beri ulasan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CALL TO ACTION -->
        <section class="bg-primary bg-gradient text-white py-5">
            <div class="container text-center">
                <h3 class="fw-bold mb-3">
                    Siap Menemukan Jasa Profesional Terbaik?
                </h3>
                <p class="mb-4 fs-5">
                    Temukan layanan yang cepat, aman, dan terpercaya hanya di FindSrv
                </p>
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-light btn-lg fw-bold px-4 cta-card">
                        Jelajahi dan Cari Jasa Sekarang
                    </a>
                </div>
            </div>
        </section>

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
                            <li><a href="#" class="text-decoration-none text-muted">Beranda</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Rekomendasi</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Jelajahi Jasa</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4">
                        <h6 class="fw-bold">Bantuan</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none text-muted">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Kebijakan Privasi</a></li>
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