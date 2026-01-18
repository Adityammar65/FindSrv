<?php
$session = session();

$username = $session->get('username');
$role = $session->get('role');
$photo = $session->get('foto_profil');

$profilePhoto = $photo && file_exists(FCPATH . 'uploads/profile/' . $photo)
    ? base_url('uploads/profile/' . $photo)
    : base_url('assets/images/icons/profile.png');

// Get service title if available
$db = \Config\Database::connect();
if (isset($order['id_service'])) {
    $serviceQuery = $db->table('services')->where('id_service', $order['id_service'])->get()->getRowArray();
    $serviceTitle = $serviceQuery['judul_jasa'] ?? 'N/A';
} else {
    $serviceTitle = 'N/A';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Chat Pesanan</title>
    <style>
        .chat-box {
            height: 400px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .message-wrapper {
            margin-bottom: 12px;
            clear: both;
        }
        .message-wrapper.pengguna {
            text-align: right;
        }
        .message-wrapper.penyedia {
            text-align: left;
        }
        .bubble {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 12px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .message-wrapper.pengguna .bubble {
            background: #0d6efd;
            color: white;
        }
        .message-wrapper.penyedia .bubble {
            background: #e9ecef;
            color: #212529;
        }
        .time-stamp {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 4px;
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

    <!-- NAVBAR -->
    <div class="container-fluid p-0 fade-in-fwd">
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

        <div class="container mt-4">
            <div class="chat-subject d-flex justify-content-between align-items-center">
                <h5>Chat: <?= !empty($order['judul_jasa']) ? esc($order['judul_jasa']) : 'Chat Pesanan' ?></h5>
                <?php if ($role === 'penyedia'): ?>
                    <a href="<?= base_url('daftar_pesanan') ?>" class="btn btn-primary">Kembali</a>
                <?php else: ?>
                    <a href="<?= base_url('riwayat') ?>" class="btn btn-primary">Kembali</a>
                <?php endif; ?>
            </div>

            <div class="chat-box my-3" id="chatBox">
                <?php if (empty($chats)): ?>
                    <p class="text-center text-muted">Belum ada pesan. Mulai percakapan!</p>
                <?php else: ?>
                    <?php foreach ($chats as $chat): ?>
                        <!-- Message from Pengguna -->
                        <?php if (!empty($chat['pesan_pengguna'])): ?>
                            <div class="message-wrapper <?= $role === 'pengguna' ? 'pengguna' : 'penyedia' ?>">
                                <div class="bubble">
                                    <?= esc($chat['pesan_pengguna']) ?>
                                </div>
                                <?php if (!empty($chat['waktu_kirim'])): ?>
                                    <div class="time-stamp"><?= esc($chat['waktu_kirim']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Message from Penyedia -->
                        <?php if (!empty($chat['pesan_penyedia'])): ?>
                            <div class="message-wrapper <?= $role === 'penyedia' ? 'pengguna' : 'penyedia' ?>">
                                <div class="bubble">
                                    <?= esc($chat['pesan_penyedia']) ?>
                                </div>
                                <?php if (!empty($chat['waktu_kirim'])): ?>
                                    <div class="time-stamp"><?= esc($chat['waktu_kirim']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form action="<?= base_url('chat/send/' . $order['id_order']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="order_id" value="<?= $order['id_order'] ?>">
                <input type="hidden" name="user_id" value="<?= $order['id_pencari'] ?>">
                <input type="hidden" name="provider_id" value="<?= $order['id_penyedia'] ?>">

                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                    <button class="btn btn-primary px-5" type="submit">Kirim</button>
                </div>
            </form>
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

    <script>
        // Auto-scroll to bottom of chat
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>

</body>
</html>
