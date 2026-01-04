<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Syarat & Ketentuan</title>
</head>
<body class="bg-light overflow-hidden fade-in-fwd">
    <div class="container-fluid vh-100 d-flex align-items-center">
        <div class="row shadow-lg rounded-4 overflow-hidden bg-white">
            <aside class="col-md-4 col-lg-3 bg-primary text-white p-4">
                <h5 class="fw-bold mb-4">Pengaturan</h5>
                
                <!-- SIDEMENU -->
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold sidebar-item" href="<?= base_url('pengaturan') ?>">
                            Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white opacity-75 sidebar-item" href="<?= base_url('kebijakan') ?>">
                            Kebijakan Privasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white opacity-75 sidebar-item active" href="#">
                            Syarat & Ketentuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white opacity-75 sidebar-item" href="<?= base_url('bantuan') ?>">
                            Pusat Bantuan
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="col-md-8 col-lg-9 p-5">
                <h4 class="fw-bold mb-4">Syarat & Ketentuan</h4>
                <div class="col-12">
                    <p>
                        FindSrv merupakan platform yang mempertemukan penyedia jasa dan
                        konsumen. Setiap pengguna wajib memberikan data yang akurat serta
                        bertanggung jawab atas keamanan akun pribadinya.
                    </p>

                    <p>
                        Pengguna dilarang melakukan penipuan, mengunggah konten melanggar
                        hukum, atau menyalahgunakan sistem komunikasi di luar transaksi jasa
                        yang sah.
                    </p>

                    <p>
                        FindSrv bertindak sebagai fasilitator dan tidak bertanggung jawab atas
                        kualitas pekerjaan maupun sengketa antara penyedia jasa dan konsumen,
                        namun tetap menyediakan dukungan pelanggan untuk membantu proses
                        transaksi.
                    </p>

                    <p>
                        Seluruh pembayaran wajib dilakukan melalui sistem resmi FindSrv.
                        Platform berhak menangguhkan atau menghapus akun yang melanggar aturan.
                        Dengan menggunakan layanan ini, pengguna tunduk pada hukum Indonesia
                        serta menyetujui perubahan kebijakan yang dapat diperbarui sewaktu-waktu.
                    </p>
                </div>

                <div class="col-12">
                    <a class="btn btn-primary fw-bold mb-3 mx-3 px-5 py-2 my-3" 
                        href="<?= $user['role'] === 'penyedia'
                            ? base_url('/home_penyedia')
                            : base_url('/home_pengguna'); ?>" 
                        role="button">
                            Kembali
                    </a>
                </div>                
            </main>
        </div>
    </div>
</body>
</html>
