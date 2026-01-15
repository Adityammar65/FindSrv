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
    <style>
        /* Responsive styles for mobile devices */
        @media (max-width: 768px) {
            .list-group {
                margin: 0 0.5rem;
                padding: 0 0.5rem;
            }
            .list-group-item p {
                font-size: 0.8rem;
            }
            .list-group-item h6 {
                font-size: 0.9rem;
            }
            h3 {
                margin: 1rem;
                font-size: 1.5rem;
            }
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
            <h6 class="fw-bold"><?= esc($username) ?></h6>
            <p class="text-muted"><?= esc($role) ?> jasa</p>
            <hr>
            <ul class="list-group list-group-flush text-start">
                <li class="list-group-item">
                    <a href="<?= base_url('pengaturan') ?>" class="text-decoration-none text-dark">Pengaturan</a>
                </li>
                <li class="list-group-item">
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
                                <a class="nav-link active" href="<?= base_url('riwayat') ?>">Riwayat Pesanan</a>
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
                                <a class="nav-link active" href="<?= base_url('riwayat') ?>">Riwayat Pesanan</a>
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

        <h5 class="fw-bold m-4 mx-5">Riwayat Pesanan</h5>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                Kamu belum memiliki riwayat pesanan.
            </div>
        <?php else: ?>
            <div class="container mt-4">
                <div class="row">
                    <?php foreach ($orders as $order): ?>
                    <div class="col-12 mb-3">
                        <a href="<?= base_url('chat/detail/' . $order['id_order']) ?>" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-3 h-100">
                                <div class="card-body p-3 d-flex flex-column">                                    
                                    <!-- Chat Info -->
                                    <div class="flex-grow-1">
                                        <div class="top-content d-flex flex-row align-items-center">
                                            <h6 class="fw-bold text-dark m-0">
                                                <?= esc($order['judul_jasa']) ?>
                                            </h6>
                                            <span class="badge <?php if ($order['status_pesanan'] === 'dalam proses') echo 'bg-warning text-dark mx-2'; elseif ($order['status_pesanan'] === 'selesai') echo 'bg-success mx-2'; else echo 'bg-danger mx-2'; ?>">
                                                <?= ucfirst($order['status_pesanan']) ?>
                                            </span>
                                            <small class="text-dark">
                                                <?= date('d M Y', strtotime($order['tanggal_order'])) ?>
                                            </small>
                                        </div>
                                        <p class="small fw-bold text-dark mb-1">
                                            <?php if ($role === 'pengguna'): ?>
                                                Penyedia: <?= esc($order['username_penyedia']) ?>
                                            <?php else: ?>
                                                Pelanggan: <?= esc($order['username_pencari']) ?>
                                            <?php endif; ?>
                                        </p>
                                        <div class="col-md-6 text-center my-2 d-flex justify-content-between align-items-center flex-row">
                                            <img src="<?= $order['gambar_layanan'] ? base_url('uploads/jasa/' . $order['gambar_layanan']) : base_url('assets/images/default-service.jpg') ?>" class="img-fluid rounded" style="height:90px; width:50%; object-fit:cover;">
                                            <p class="text-dark fw-bold">Total Harga: 
                                                <?php if ($order['harga_jasa'] !== null) echo number_format($order['harga_jasa'], 0, ',', '.'); 
                                                elseif ($order['status_pesanan'] === 'dibatalkan') echo 'Pesanan Dibatalkan';
                                                else echo 'Harga Belum ditetapkan'; ?>
                                            </p>
                                        </div>
                                        <p class="small text-dark mb-2">
                                            Deskripsi pesanan:
                                            <?= esc(substr($order['deskripsi_permintaan'], 0, 50)) ?><?= strlen($order['deskripsi_permintaan']) > 50 ? '...' : '' ?>
                                        </p>
                                    </div>
                                    <?php if ($role === 'pengguna'): ?>
                                        <div class="bottom-content d-flex justify-content-end">
                                            <a href="<?= base_url('detail_jasa/' . $order['id_service']) ?>" class="btn btn-outline-primary btn-sm w-50 mt-2 mx-1">Lihat Jasa</a>
                                            <?php if ($order['status_pesanan'] === 'dalam proses'): ?>
                                                <a href="<?= base_url('chat/view/' . $order['id_order']) ?>" class="btn btn-primary btn-sm w-25 mt-2 mx-1">Chat Penyedia</a>
                                                <a href="<?= base_url('order/batalkan/' . $order['id_order']) ?>" class="btn btn-danger btn-sm w-25 mt-2 mx-1">Batalkan Pesanan</a>
                                            <?php elseif ($order['status_pesanan'] === 'selesai'): ?>
                                                <a href="<?= base_url('ulasan/tambah/' . $order['id_order']) ?>" class="btn btn-success btn-sm w-25 mt-2 mx-1">Beri Ulasan</a>
                                                <a href="<?= base_url('pencarian') ?>" class="btn btn-secondary btn-sm w-25 mt-2 mx-1">Pesan Lagi</a>
                                            <?php else: ?>
                                                <button class="btn btn-danger btn-sm w-50 mt-2 mx-1" disabled>Dibatalkan</button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

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