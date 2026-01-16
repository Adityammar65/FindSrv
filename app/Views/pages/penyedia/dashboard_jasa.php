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

    <title>Dashboard Jasa</title>
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
    <div class="container-fluid fade-in-fwd p-0">

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

        <!-- DASHBOARD JASA -->
        <div class="container my-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold">Dashboard Jasa</h5>
                <button
                    class="btn btn-primary fw-bold"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahJasa">
                    + Tambah Jasa
                </button>
            </div>

            <?php if (empty($services)): ?>
                <!-- EMPTY STATE -->
                <div class="card border-0 shadow-sm text-center p-5">
                    <img src="<?= base_url('assets/images/icons/empty.png') ?>"
                        class="mx-auto mb-3"
                        style="max-width: 150px;">

                    <h5 class="fw-bold">Belum Ada Jasa</h5>
                    <p class="text-muted">
                        Kamu belum menambahkan jasa apapun
                    </p>
                    <button
                        class="btn btn-primary fw-bold"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambahJasa">
                        Tambah Jasa
                    </button>
                </div>

            <?php else: ?>
                <!-- CARD JASA -->
                <div class="row g-4">
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <img src="<?= $service['gambar_layanan']
                                    ? base_url('uploads/jasa/' . $service['gambar_layanan'])
                                    : base_url('assets/images/default-service.jpg') ?>"
                                    class="card-img-top rounded-top-4"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="fw-bold">
                                        <?= esc($service['judul_jasa']) ?>
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        <?= esc($service['kategori']) ?>
                                    </p>
                                    <p class="flex-grow-1">
                                        <?= esc(word_limiter($service['deskripsi_jasa'], 20)) ?>
                                    </p>
                                    <div class="d-flex justify-content-between gap-2">
                                        <button
                                            class="btn btn-primary btn-sm edit-jasa-btn w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editJasaModal"
                                            data-id="<?= $service['id_service'] ?>"
                                            data-judul="<?= esc($service['judul_jasa']) ?>"
                                            data-kategori="<?= esc($service['kategori']) ?>"
                                            data-deskripsi="<?= esc($service['deskripsi_jasa']) ?>"
                                            data-gambar="<?= esc($service['gambar_layanan']) ?>"
                                        >
                                            Edit
                                        </button>
                                        <a href="<?= base_url('analytic/' . $service['id_service']) ?>"
                                        class="btn btn-primary btn-sm w-100">
                                            Analisis
                                        </a>
                                        <button
                                            class="btn btn-sm btn-danger w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#hapusJasaModal"
                                            data-id="<?= $service['id_service'] ?>"
                                            data-judul="<?= esc($service['judul_jasa']) ?>"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
</body>
                    
<!-- MODAL TAMBAH JASA -->
<div class="modal fade" id="modalTambahJasa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Jasa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form
                action="<?= base_url('jasa/simpan') ?>"
                method="post"
                enctype="multipart/form-data"
            >
                <div
                    class="modal-body jasa-scrollspy"
                    data-bs-spy="scroll"
                    data-bs-offset="0"
                    tabindex="0"
                >
                    <section id="judul">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Judul Jasa</label>
                            <input
                                type="text"
                                name="judul_jasa"
                                class="form-control"
                                required
                            >
                        </div>
                    </section>
                    <section id="kategori">
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">
                                Kategori Jasa <span class="text-muted">(Pilih maksimal 3)</span>
                            </label>

                            <div class="row">
                                <?php
                                $categories = [
                                    'Web Development',
                                    'Software Development',
                                    'Mobile App Development',
                                    'WordPress & CMS',
                                    'UI / UX Design',

                                    'Graphic Design',
                                    'Logo & Branding',
                                    'Illustration',
                                    'Motion Graphic',
                                    '3D Design',

                                    'Content Writing',
                                    'Copywriting',
                                    'Technical Writing',
                                    'Translation',

                                    'Digital Marketing',
                                    'SEO / SEM',
                                    'Social Media Management',
                                    'Business Consulting',

                                    'Video Editing',
                                    'Voice Over',
                                    'Audio Production',

                                    'Data Entry',
                                    'Virtual Assistant',
                                    'Customer Support',
                                    'Project Management',
                                ];

                                foreach ($categories as $cat):
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="kategori[]"
                                                value="<?= $cat ?>"
                                                id="cat-<?= md5($cat) ?>"
                                            >
                                            <label class="form-check-label" for="cat-<?= md5($cat) ?>">
                                                <?= $cat ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </section>
                    <section id="deskripsi">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Deskripsi Jasa</label>
                            <textarea
                                name="deskripsi_jasa"
                                rows="6"
                                class="form-control"
                                required
                            ></textarea>
                        </div>
                    </section>
                    <section id="gambar">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Gambar Jasa (Opsional)</label>
                            <input
                                type="file"
                                name="gambar_layanan"
                                class="form-control"
                                accept="image/*"
                            >
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary fw-bold px-4">
                        Simpan Jasa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT JASA -->
<div class="modal fade" id="editJasaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <form id="editJasaForm" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul_jasa" id="editJudul" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">
                            Kategori Jasa <span class="text-muted">(Pilih maksimal 3)</span>
                        </label>
                        <div class="row">
                            <?php
                            $categories = [
                                'Web Development',
                                'Software Development',
                                'Mobile App Development',
                                'WordPress & CMS',
                                'UI / UX Design',

                                'Graphic Design',
                                'Logo & Branding',
                                'Illustration',
                                'Motion Graphic',
                                '3D Design',

                                'Content Writing',
                                'Copywriting',
                                'Technical Writing',
                                'Translation',

                                'Digital Marketing',
                                'SEO / SEM',
                                'Social Media Management',
                                'Business Consulting',

                                'Video Editing',
                                'Voice Over',
                                'Audio Production',

                                'Data Entry',
                                'Virtual Assistant',
                                'Customer Support',
                                'Project Management',
                            ];

                            foreach ($categories as $cat):
                            ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kategori[]"
                                            value="<?= $cat ?>"
                                            id="cat-<?= md5($cat) ?>"
                                        >
                                        <label class="form-check-label" for="cat-<?= md5($cat) ?>">
                                            <?= $cat ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi_jasa"
                                  id="editDeskripsi"
                                  rows="5"
                                  class="form-control"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar</label>
                        <img id="previewGambar"
                             class="img-fluid mb-2 rounded"
                             style="max-height:120px; display:none;">
                        <input type="file"
                               name="gambar_layanan"
                               class="form-control"
                               accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS JASA -->
<div class="modal fade" id="hapusJasaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <form id="hapusJasaForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">
                        Hapus Jasa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        Apakah kamu yakin ingin menghapus jasa
                        <strong id="hapusJudul"></strong>?
                        <br>
                        <span class="text-muted">Tindakan ini tidak bisa dibatalkan.</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/* =========================
   MODAL EDIT JASA
========================= */
const editModal = document.getElementById('editJasaModal');

editModal.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;

    const id        = btn.getAttribute('data-id');
    const judul     = btn.getAttribute('data-judul');
    const deskripsi = btn.getAttribute('data-deskripsi');
    const kategori  = btn.getAttribute('data-kategori');
    const gambar    = btn.getAttribute('data-gambar');

    const form = document.getElementById('editJasaForm');
    form.action = `<?= base_url('jasa/edit') ?>/${id}`;

    document.getElementById('editJudul').value = judul ?? '';
    document.getElementById('editDeskripsi').value = deskripsi ?? '';

    document
        .querySelectorAll('#editJasaModal input[name="kategori[]"]')
        .forEach(cb => cb.checked = false);

    if (kategori) {
        kategori.split(',').forEach(kat => {
            const checkbox = document.querySelector(
                `#editJasaModal input[value="${kat.trim()}"]`
            );
            if (checkbox) checkbox.checked = true;
        });
    }

    const preview = document.getElementById('previewGambar');
    if (gambar) {
        preview.src = `<?= base_url('uploads/jasa') ?>/${gambar}`;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

/* =========================
   MODAL HAPUS JASA
========================= */
const hapusModal = document.getElementById('hapusJasaModal');

hapusModal.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;

    const id    = btn.getAttribute('data-id');
    const judul = btn.getAttribute('data-judul');

    const form = document.getElementById('hapusJasaForm');
    form.action = `<?= base_url('jasa/hapus') ?>/${id}`;

    document.getElementById('hapusJudul').textContent = judul ?? '';
});
</script>

</html>