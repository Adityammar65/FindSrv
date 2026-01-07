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

    <title>Detail Jasa</title>
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
    <!-- DETAIL JASA -->
    <div class="container-fluid p-0">
        
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
                            <a class="nav-link" aria-current="page" href="<?= base_url('home_pengguna') ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Cari Jasa</a>
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

        <h3 class="my-3 mx-5 fw-bold">Detail Jasa</h3>

        <!-- PREVIEW JASA -->
        <div class="row g-4 mb-4 mx-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <img
                        src="<?= $service['gambar_layanan']
                            ? base_url('uploads/jasa/' . $service['gambar_layanan'])
                            : base_url('assets/images/default-service.jpg') ?>"
                        class="rounded-top"
                        style="height:260px; object-fit:cover;"
                    >
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
                            <?php endforeach ?>
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
                <div class="card border-0 shadow-sm rounded-4 sticky-top"
                    style="top: 120px; z-index: 100;">
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <small class="fw-bold d-block">Rating Penyedia</small>
                            <div class="text-warning">
                                ★★★★☆ <small class="text-muted">(4.5)</small>
                            </div>
                            <small class="text-muted">120 ulasan</small>
                        </div>
                        <button
                            class="btn btn-primary fw-bold w-100 py-2"
                            data-bs-toggle="modal"
                            data-bs-target="#pesanJasaModal"
                        >
                            Pesan Jasa
                        </button>
                        <a href="<?= base_url('pencarian') ?>"
                        class="btn btn-primary fw-bold mt-2 w-100">
                            Kembali
                        </a>
                    </div>
                </div>
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
                            <li><a href="<?= base_url('home_pengguna') ?>" class="text-decoration-none text-muted">Beranda</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Cari Jasa</a></li>
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

<!-- MODAL PESAN JASA -->
<div class="modal fade" id="pesanJasaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pesan Jasa</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= base_url('order/store') ?>">
                <input type="hidden" name="id_service" value="<?= $service['id_service'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                               class="form-control"
                               value="<?= session()->get('username') ?>"
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               class="form-control"
                               value="<?= session()->get('email') ?>"
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Permintaan</label>
                        <textarea name="deskripsi_permintaan"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Jelaskan kebutuhan Anda..."
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-primary fw-bold">
                        Lanjutkan ke Chat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>