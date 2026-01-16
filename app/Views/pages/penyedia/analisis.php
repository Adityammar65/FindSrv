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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.js" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                                <a class="nav-link" aria-current="page" href="<?= base_url('home_penyedia') ?>">Beranda</a>
                                <button type="button" class="btn p-0 d-md-none" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas" aria-controls="profileOffcanvas">
                                    <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                </button>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= base_url('dashboard') ?>">Dashboard Jasa</a>
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

        <div class="container my-3">
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

            <!-- RATINGS SECTION WITH SCROLLSPY -->
            <div class="row mt-5 mb-4">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Ulasan Pelanggan</h5>
                </div>
            </div>

            <div class="row" data-bs-spy="scroll" data-bs-target="#ratingsSidebar" data-bs-offset="0" tabindex="0">
                <div class="col-md-12">
                    <?php if (empty($ratings)): ?>
                        <div class="alert alert-secondary">
                            Belum ada ulasan untuk jasa ini. Mulai dapatkan ulasan dari pelanggan Anda!
                        </div>
                    <?php else: ?>
                        <?php foreach ($ratings as $index => $rating): ?>
                            <div id="rating<?= $index ?>" class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <h6 class="fw-bold mb-1"><?= esc($rating['username']) ?></h6>
                                        <div class="text-warning mb-2">
                                            <?php for ($i = 0; $i < $rating['skor_bintang']; $i++): ?>
                                                ★
                                            <?php endfor; ?>
                                            <?php for ($i = $rating['skor_bintang']; $i < 5; $i++): ?>
                                                ☆
                                            <?php endfor; ?>
                                            <small class="text-muted ms-2">
                                                <?= date('d M Y', strtotime($rating['tanggal_ulasan'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        <?= esc($rating['ulasan_teks']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center mt-4">
            <div class="col-4">
                <a href="<?= base_url('dashboard') ?>"
                class="btn btn-primary w-100">
                    Kembali
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="bg-dark mt-3 pt-5 fade-in-fwd">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 mb-4">
                        <img src="<?= base_url('assets/images/icons/logo_light.png') ?>" alt="Logo" style="width: 90px;">
                        <p class="text-light mt-3">FindSrv adalah platform yang menghubungkan pengguna dengan penyedia jasa profesional secara aman dan terpercaya.</p>
                    </div>
                    <div class="col-12 col-md-2 mb-4">
                        <h6 class="fw-bold text-light">Menu</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('home_pengguna') ?>" class="text-decoration-none text-light">Beranda</a></li>
                            <?php if ($role === 'pengguna'): ?>
                                <li><a href="<?= base_url('pencarian') ?>" class="text-decoration-none text-light">Cari Jasa</a></li>
                            <?php else: ?>
                                <li><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-light">Dashboard Jasa</a></li>
                                <li><a href="<?= base_url('daftar_pesanan') ?>" class="text-decoration-none text-light">Daftar Pesanan</a></li>
                            <?php endif; ?>
                            <li><a href="<?= base_url('riwayat') ?>" class="text-decoration-none text-light">Riwayat</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="fw-bold text-light">Bantuan</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?= base_url('bantuan') ?>" class="text-decoration-none text-light">Pusat Bantuan</a></li>
                            <li><a href="<?= base_url('syarat_ketentuan') ?>" class="text-decoration-none text-light">Syarat & Ketentuan</a></li>
                            <li><a href="<?= base_url('kebijakan') ?>" class="text-decoration-none text-light">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="fw-bold text-light">Kontak</h6>
                        <p class="text-light mb-1">Email: support@findsrv.id</p>
                        <p class="text-light">Instagram: @findsrv.id</p>
                    </div>
                </div>
                <hr class="border border-white">
                <div class="text-center text-light pb-3">© 2025 FindSrv. All rights reserved.</div>
            </div>
        </footer>
    </div>

    <style>
        /* SCROLLSPY STYLING */
        #ratingsSidebar {
            max-height: 600px;
            overflow-y: auto;
        }

        #ratingsSidebar .list-group-item {
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        #ratingsSidebar .list-group-item.active {
            background-color: #e7f3ff;
            border-left-color: #0d6efd;
            border-radius: 0;
        }

        #ratingsSidebar .list-group-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        /* SCROLLBAR STYLING */
        #ratingsSidebar::-webkit-scrollbar {
            width: 6px;
        }

        #ratingsSidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #ratingsSidebar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #ratingsSidebar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        @media (max-width: 768px) {
            #ratingsSidebar {
                margin-bottom: 20px;
            }
        }
    </style>
</body>
</html>