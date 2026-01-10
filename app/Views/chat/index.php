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

    <title>Chat</title>
    <style>
        .chat-box {
            height: 400px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 15px;
        }
        .user { text-align: right; }
        .provider { text-align: left; }
        .bubble {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            max-width: 70%;
        }
        .user .bubble {
            background: #0d6efd;
            color: white;
        }
        .provider .bubble {
            background: #e9ecef;
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
            <img src="<?= $profilePhoto ?>" alt="User Profile" class="rounded-circle mb-3" width="80" height="80" style="object-fit: cover;">
            <h6 class="fw-bold"><?= esc($username) ?></h6>
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

    <!-- NAVBAR & CONTENT -->
    <div class="container-fluid p-0 fade-in-fwd">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light fw-bold">
            <div class="container-fluid ps-3 ps-md-5 pe-3 pe-md-5 py-2 py-md-3">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-md-5 px-md-5" id="navbarSupportedContent">
                    <?php if ($role === 'penyedia'): ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                            <li class="nav-item d-flex flex-row align-items-center justify-content-between">
                                <a class="nav-link" aria-current="page" href="#">Beranda</a>
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
                                <a class="nav-link active" href="<?= base_url('chat') ?>">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('riwayat') ?>">Riwayat</a>
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
                                <a class="nav-link active" href="<?= base_url('chat') ?>">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('riwayat') ?>">Riwayat</a>
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

        <div class="container mt-4">
            <div class="row g-4">
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold">
                                    <?= esc($order['judul_jasa']) ?>
                                </h5>

                                <p class="mb-1 small text-muted">
                                    Penyedia: <strong><?= esc($order['username_penyedia']) ?></strong>
                                </p>

                                <p class="small flex-grow-1">
                                    <?= esc($order['deskripsi_permintaan']) ?>
                                </p>

                                <span class="badge bg-warning text-dark mb-3 align-self-start">
                                    <?= esc($order['status_pesanan']) ?>
                                </span>

                                <!-- HANYA CHAT -->
                                <a href="<?= base_url('chat/view/' . $order['id_order']) ?>" class="btn btn-sm btn-primary w-100">
                                    Chat Penyedia
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>

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
</body>
</html>
