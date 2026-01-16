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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Jasa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
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
        }
    </style>
</head>

<body>
    <!-- SIDEPANEL -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Profil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body text-center">
            <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
            <h6 class="fw-bold mt-3"><?= esc($username) ?></h6>
            <p class="text-muted mb-3"><?= esc($role) ?> jasa</p>
            <hr>
            <ul class="list-group list-group-flush text-start">
                <li class="list-group-item border-0">
                    <a href="<?= base_url('pengaturan') ?>" class="text-decoration-none text-dark">Pengaturan</a>
                </li>
                <li class="list-group-item border-0">
                    <a href="<?= base_url('logout') ?>" class="text-danger fw-bold text-decoration-none">Logout</a>
                </li>
            </ul>
        </div>
    </div>

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
                                <a class="nav-link active" href="<?= base_url('pencarian') ?>">Cari Jasa</a>
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

        <!-- PENCARIAN JASA -->
        <div class="container my-4 my-md-5">
            <div class="mb-4 text-center">
                <h2 class="fw-bold mb-2">Temukan Jasa Terbaik</h2>
                <p class="text-muted mb-0">Cari layanan sesuai kebutuhanmu</p>
            </div>

            <form method="get" action="<?= current_url() ?>" class="row g-2 g-md-3 mb-4">
                <div class="col-12 col-md-5">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari jasa..." value="<?= esc($keyword ?? '') ?>">
                </div>
                <div class="col-12 col-md-5">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat) ?>" <?= ($selectedKategori ?? '') === $cat ? 'selected' : '' ?>>
                                <?= esc($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>

            <!-- HASIL -->
            <?php if (empty($services)): ?>
                <!-- EMPTY STATE -->
                <div class="text-center p-5">
                    <img src="<?= base_url('assets/images/icons/empty.png') ?>" alt="No Services" style="max-width: 150px;" class="mb-3">
                    <h5 class="fw-bold">Jasa tidak ditemukan</h5>
                    <p class="text-muted">Coba kata kunci atau kategori lain</p>
                </div>
            <?php else: ?>
                <!-- SERVICES LIST -->
                <div class="row g-3 g-md-4">
                    <?php foreach ($services as $service): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <img src="<?= $service['gambar_layanan'] ? base_url('uploads/jasa/' . $service['gambar_layanan']) : base_url('assets/images/default-service.jpg') ?>" alt="<?= esc($service['judul_jasa']) ?>" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="fw-bold card-title"><?= esc($service['judul_jasa']) ?></h5>
                                    <span class="badge bg-light text-primary mb-2 w-fit"><?= esc($service['kategori']) ?></span>
                                    <p class="text-muted small flex-grow-1"><?= esc(word_limiter($service['deskripsi_jasa'], 18)) ?></p>
                                    <a href="<?= base_url('detail_jasa/' . $service['id_service']) ?>" class="btn btn-outline-primary fw-bold mt-auto">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
</body>
</html>