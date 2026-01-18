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
    <title>Daftar Pesanan</title>

    <!-- Bootstrap 5 CSS -->
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
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            h5 {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            .card {
                border-radius: 0.5rem !important;
            }

            .card-body {
                padding: 1rem;
            }

            .top-content {
                flex-direction: column;
                gap: 0.75rem;
            }

            .left-content {
                width: 100%;
            }

            .right-content {
                width: 100%;
            }

            .right-content img {
                width: 100% !important;
                height: 120px !important;
                object-fit: cover;
            }

            .card-body .d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .card-body .btn {
                width: 100%;
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }

            .btn-sm {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }

            .dropdown {
                width: 100%;
            }

            .dropdown .btn {
                width: 100%;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.35rem 0.5rem;
            }

            .card-title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            p {
                font-size: 0.85rem;
                margin-bottom: 0.25rem;
            }

            .small {
                font-size: 0.75rem;
            }

            .mb-1 {
                margin-bottom: 0.25rem;
            }

            .mb-3 {
                margin-bottom: 0.75rem;
            }

            .gap-2 {
                gap: 0.5rem;
            }

            .modal-sm {
                --bs-modal-width: 90vw;
                max-width: 90vw;
            }

            .modal-dialog-centered {
                min-height: calc(var(--bs-modal-width) * 0.5);
            }

            .modal-body input {
                font-size: 0.9rem;
            }

            .form-label {
                font-size: 0.85rem;
                margin-bottom: 0.25rem;
            }

            .row.g-3 {
                --bs-gutter-x: 0.75rem;
                --bs-gutter-y: 0.75rem;
            }

            .col-12 {
                padding-left: 0.375rem;
                padding-right: 0.375rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            h5 {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .card-title {
                font-size: 0.9rem;
            }

            .btn-sm {
                padding: 0.35rem 0.5rem;
                font-size: 0.75rem;
            }

            .right-content img {
                height: 100px !important;
            }

            p, .small {
                font-size: 0.8rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.4rem;
            }

            .gap-2 {
                gap: 0.35rem;
            }

            .top-content {
                gap: 0.5rem;
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
                                <a class="nav-link active" href="<?= base_url('daftar_pesanan') ?>">Daftar Pesanan</a>
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

        <!-- PESANAN MASUK -->
        <h5 class="fw-bold m-4 mx-5">Pesanan Masuk</h5>
         <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                Kamu belum memiliki pesanan.
            </div>
        <?php else: ?>
        <div class="container my-4">
            <div class="row g-3 g-md-4">
                <?php foreach ($orders as $order): ?>
                    <div class="col-12 col-md-6 col-lg-4 <?php if ($order['status_pesanan'] === 'dibatalkan' || $order['status_pesanan'] === 'selesai') echo 'd-none'; ?>">
                        <div class="card h-100 shadow-sm border-0 rounded-4">
                            <div class="card-body d-flex flex-column">
                                <div class="top-content d-flex flex-row">
                                    <div class="left-content d-flex flex-column">
                                        <h5 class="fw-bold card-title">
                                            <?= esc($order['judul_jasa']) ?>
                                        </h5>
                                        <p class="mb-1 small text-muted">
                                            Pemesan: <strong><?= esc($order['username_pemesan']) ?></strong>
                                        </p>
                                        <p class="small flex-grow-1">
                                            <?= esc($order['deskripsi_permintaan']) ?>
                                        </p>
                                        <span class="badge bg-warning text-dark mb-3 align-self-start">
                                            <?= esc($order['status_pesanan']) ?>
                                        </span>
                                    </div>
                                    <div class="right-content">
                                        <img src="<?= base_url('uploads/jasa/' . $order['gambar_layanan']) ?>" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px;" alt="Gambar Layanan">
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('chat/view/' . $order['id_order']) ?>" class="btn btn-sm btn-primary w-100">
                                        Chat Pemesan
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary w-100 dropdown-toggle" type="button" id="dropdownStatus<?= $order['id_order'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                            Update Status
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownStatus<?= $order['id_order'] ?>">
                                            <li>
                                                <form action="<?= base_url('order/status/' . $order['id_order']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="dalam proses">
                                                    <button type="submit" class="dropdown-item bg-warning" onclick="return confirm('Ubah status menjadi Dalam Proses?')">
                                                        <span class="text-dark">Dalam Proses</span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="<?= base_url('order/status/' . $order['id_order']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="dropdown-item bg-success" onclick="return confirm('Ubah status menjadi Selesai?')">
                                                        <span class="text-light">Selesai</span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="<?= base_url('order/status/' . $order['id_order']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="dibatalkan">
                                                    <button type="submit" class="dropdown-item bg-danger" onclick="return confirm('Ubah status menjadi Dibatalkan?')">
                                                        <span class="text-light">Dibatalkan</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#hargaModal" data-order="<?= $order['id_order'] ?>">
                                    Tetapkan Harga
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
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

    <!-- MODAL PENETAPAN HARGA -->
    <div class="modal fade" id="hargaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form method="post" id="hargaForm" action="">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Tentukan Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required placeholder="Contoh: 500000">
                        <small class="text-muted">Masukkan harga dalam Rupiah</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const hargaModal = document.getElementById('hargaModal');
        hargaModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const orderId = button.getAttribute('data-order');
            const form = document.getElementById('hargaForm');
            form.action = '<?= base_url("order/setHarga/") ?>' + orderId;
        });
    </script>
</body>
</html>
