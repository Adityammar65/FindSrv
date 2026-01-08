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

    <title>Daftar Pesanan</title>
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
                <a class="navbar-brand" href="#">
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
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard Jasa  </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Daftar Pesanan</a>
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

        <h3 class="fw-bold my-4 mx-5">Pesanan Masuk</h3>

        <!-- DASHBOARD PESANAN -->
        <div class="row g-4 m-4">
            <?php foreach ($orders as $order): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">
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
                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-sm btn-primary w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#chatModal"
                                    data-order="<?= $order['id_order'] ?>"
                                    data-user="<?= esc($order['username_pemesan']) ?>">
                                    Chat
                                </button>
                                <a href="<?= base_url('order/status/' . $order['id_order']) ?>"
                                class="btn btn-sm btn-primary w-100">
                                    Update Status
                                </a>
                            </div>
                            <button
                                class="btn btn-sm btn-success mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#hargaModal"
                                data-order="<?= $order['id_order'] ?>">
                                Tetapkan Harga
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
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
                            <li><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">Dashboard Jasa</a></li>
                            <li><a href="#" class="text-decoration-none text-muted">Daftar Pesanan</a></li>
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
            
<!-- CHAT -->
<div class="modal fade" id="chatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form method="post" action="<?= base_url('chat/send') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Chat Pemesan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_order" id="chatOrderId">

                    <textarea name="pesan"
                              class="form-control"
                              rows="4"
                              placeholder="Tulis pesan..."
                              required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button class="btn btn-primary">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL PENETAPAN HARGA -->
<div class="modal fade" id="hargaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="post" action="<?= base_url('order/setHarga') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tetapkan Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_order" id="hargaOrderId">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /* =======================
        CHAT MODAL HANDLER
        ======================= */
        const chatModal = document.getElementById('chatModal');
        const chatOrderInput = document.getElementById('chatOrderId');

        if (chatModal && chatOrderInput) {
            chatModal.addEventListener('show.bs.modal', (event) => {
                const btn = event.relatedTarget;
                const orderId = btn.getAttribute('data-order');

                chatOrderInput.value = orderId;

                const chatBox = document.getElementById('chatBox');
                if (chatBox) {
                    chatBox.innerHTML =
                        '<p class="text-muted small text-center">Memuat chat...</p>';
                }
            });
        }


        /* =======================
        HARGA MODAL HANDLER
        ======================= */
        const hargaModal = document.getElementById('hargaModal');
        const hargaOrderInput = document.getElementById('hargaOrderId');

        if (hargaModal && hargaOrderInput) {
            hargaModal.addEventListener('show.bs.modal', (event) => {
                const btn = event.relatedTarget;
                const orderId = btn.getAttribute('data-order');

                hargaOrderInput.value = orderId;
            });
        }

    });

</script>

</html>