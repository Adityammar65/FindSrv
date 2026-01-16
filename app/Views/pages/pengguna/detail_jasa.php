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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Detail Jasa</title>
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

    <div class="container-fluid p-0">
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

        <h3 class="my-3 mx-5 fw-bold">Detail Jasa</h3>

        <!-- DETAIL JASA -->
        <div class="row g-4 mb-4 mx-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <img src="<?= $service['gambar_layanan'] ? base_url('uploads/jasa/' . $service['gambar_layanan']) : base_url('assets/images/default-service.jpg') ?>" class="rounded-top" style="height:260px; object-fit:cover;">
                    <div class="card-body p-3">
                        <h4 class="fw-bold mb-1">
                            <?= esc($service['judul_jasa']) ?>
                        </h4>
                        <small class="text-muted">
                            oleh <strong><?= esc($service['username']) ?></strong>
                        </small>
                        <div class="mt-2 mb-3">
                            <?php foreach (explode(',', $service['kategori']) as $kat): ?>
                                <span class="badge bg-primary-subtle text-primary me-1 mb-1">
                                    <?= esc(trim($kat)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <hr class="my-2">
                        <h6 class="fw-bold mb-1">Deskripsi</h6>
                        <p class="text-muted mb-0 small" style="white-space: pre-line;">
                            <?= esc($service['deskripsi_jasa']) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 120px; z-index: 100;">
                    <div class="card-body p-3">
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="fw-bold d-block mb-2">Rating Penyedia</small>
                            <?php
                                $totalRatings = count($ratings);
                                $avgRating = 0;
                                if ($totalRatings > 0) {
                                    $totalScore = array_sum(array_column($ratings, 'skor_bintang'));
                                    $avgRating = $totalScore / $totalRatings;
                                }
                            ?>
                            <div class="text-warning mb-1">
                                <?php for ($i = 0; $i < floor($avgRating); $i++): ?>
                                    ★
                                <?php endfor; ?>
                                <?php if ($avgRating - floor($avgRating) >= 0.5): ?>
                                    ★
                                    <?php $remaining = 5 - ceil($avgRating); ?>
                                <?php else: ?>
                                    <?php $remaining = 5 - floor($avgRating); ?>
                                <?php endif; ?>
                                <?php for ($i = 0; $i < $remaining; $i++): ?>
                                    ☆
                                <?php endfor; ?>
                                <small class="text-muted ms-2">(<?= number_format($avgRating, 1) ?>)</small>
                            </div>
                            <small class="text-muted"><?= $totalRatings ?> ulasan</small>
                        </div>

                        <!-- Ratings List -->
                        <   <div class="mb-3 pb-3 border-bottom">
                                <small class="fw-bold d-block mb-2">Ulasan Pelanggan</small>
                                <div class="ratings-list" style="max-height: 200px; overflow-y: auto;">
                                    <?php foreach (array_slice($ratings, 0, 5) as $rating): ?>
                                        <div class="mb-2 pb-2 border-bottom small">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <strong class="text-dark"><?= esc($rating['username']) ?></strong>
                                                <small class="text-muted"><?= date('d M', strtotime($rating['tanggal_ulasan'])) ?></small>
                                            </div>
                                            <div class="text-warning mb-1" style="font-size: 0.9rem;">
                                                <?php for ($i = 0; $i < $rating['skor_bintang']; $i++): ?>
                                                    ★
                                                <?php endfor; ?>
                                                <?php for ($i = $rating['skor_bintang']; $i < 5; $i++): ?>
                                                    ☆
                                                <?php endfor; ?>
                                            </div>
                                            <small class="text-muted d-block" style="line-height: 1.3;">
                                                <?= esc(substr($rating['ulasan_teks'], 0, 60)) ?><?= strlen($rating['ulasan_teks']) > 60 ? '...' : '' ?>
                                            </small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if ($totalRatings > 5): ?>
                                    <small class="text-primary fw-bold d-block mt-2">+<?= $totalRatings - 5 ?> ulasan lainnya</small>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="fw-bold d-block mb-2">Ulasan Pelanggan</small>
                                <small class="text-muted">Belum ada ulasan untuk jasa ini</small>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <   Pesan Jasa
                        </button>
                        <a href="<?= base_url('pencarian') ?>" class="btn btn-primary fw-bold mt-2 w-100">
                            Kembali
                        </a>
                    </div>
                </div>
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

    <!-- MODAL PESAN JASA -->
    <div class="modal fade" id="pesanJasaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Pesan Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= base_url('order_jasa') ?>">
                    <input type="hidden" name="id_service" value="<?= $service['id_service'] ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= session()->get('username') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= session()->get('email') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Permintaan</label>
                            <textarea name="deskripsi_permintaan" class="form-control" rows="4" placeholder="Jelaskan kebutuhan Anda..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary fw-bold">
                            Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Ratings List Scrollbar */
        .ratATINGS LIST SCROLLBARrollbar {
            width: 5px;
        }

        .ratings-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        .ratings-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }

        .ratings-list::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* Responsive adjustments */
        @medESPONSIVE ADJUSTMENTS {
            .sticky-top {
                position: relative !important;
                top: auto !important;
            }
        }
    </style>
</body>
</html>