<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Pengaturan</title>
</head>

<body class="bg-light overflow-hidden">
    <div class="container-fluid vh-100 d-flex align-items-center">
        <div class="row shadow-lg rounded-4 overflow-hidden bg-white">
            <aside class="col-md-4 col-lg-3 bg-primary text-white p-4">
                <h5 class="fw-bold mb-4">Pengaturan</h5>

                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <span class="nav-link text-white fw-semibold sidebar-item active">
                            Profil Saya
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white opacity-75 sidebar-item">
                            Keamanan
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white opacity-75 sidebar-item">
                            Notifikasi
                        </span>
                    </li>
                </ul>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="col-md-8 col-lg-9 p-5">
                <h4 class="fw-bold mb-4">Edit Profil</h4>

                <form
                    action="<?= base_url('pengaturan/update') ?>"
                    method="post"
                    enctype="multipart/form-data"
                    class="row g-4"
                >

                    <!-- PROFILE -->
                    <div class="col-12 d-flex align-items-center gap-4">
                        <img
                            src="<?= $user['foto_profil']
                                ? base_url('uploads/profile/' . $user['foto_profil'])
                                : base_url('assets/images/icons/profile.png'); ?>"
                            alt="Foto Profil"
                            class="rounded-circle border border-primary"
                            width="90"
                            height="90"
                            style="object-fit: cover;"
                        >

                        <div>
                            <label class="form-label mb-1">Foto Profil</label>
                            <input
                                type="file"
                                name="foto_profil"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    <!-- USERNAME -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="<?= esc($user['username']) ?>"
                            required
                        >
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= esc($user['email']) ?>"
                            required
                        >
                    </div>

                    <!-- PASSWORD -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Password Baru
                            <small class="text-muted">(opsional)</small>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak diganti"
                        >
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="col-12">
                        <button
                            type="submit"
                            class="btn btn-primary px-5 py-2 rounded-3 fw-bold"
                        >
                            Simpan Perubahan
                        </button>
                        <a class="btn btn-primary fw-bold mb-3 mx-3 px-5 py-2 my-3" 
                            href="<?= $user['role'] === 'penyedia'
                                ? base_url('/home_penyedia')
                                : base_url('/home_pengguna'); ?>" 
                            role="button">
                                Kembali
                        </a>
                    </div>

                </form>
            </main>

        </div>
    </div>
</body>
</html>
