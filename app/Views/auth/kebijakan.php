<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Kebijakan Privasi</title>
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
                        <a class="nav-link text-white opacity-75 sidebar-item active" href="#">
                            Kebijakan Privasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold sidebar-item" href="<?= base_url('syarat_ketentuan') ?>">
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
                <h4 class="fw-bold mb-4">Kebijakan Privasi</h4>
                <div class="col-12">
                    <p>
                        <strong>Kebijakan Privasi FindSrv (Januari 2026)</strong> mengatur bahwa
                        platform FindSrv mengumpulkan data identitas pribadi, portofolio
                        <em>Penyedia Jasa</em>, serta data teknis seperti alamat IP dan
                        <em>cookies</em> untuk memfasilitasi transaksi jasa yang aman.
                    </p>

                    <p>
                        Informasi tersebut digunakan secara eksklusif untuk
                        <strong>pengelolaan akun, pemrosesan pembayaran, dan peningkatan
                        layanan</strong>. FindSrv menjamin bahwa data pengguna tidak akan
                        diperjualbelikan kepada pihak ketiga, kecuali untuk kebutuhan
                        operasional atau kewajiban hukum.
                    </p>

                    <p>
                        Meskipun FindSrv menerapkan standar keamanan teknis yang ketat,
                        pengguna diharapkan memahami bahwa transmisi data melalui internet
                        tetap memiliki risiko.
                    </p>

                    <p>
                        Pengguna memiliki hak penuh untuk
                        <strong>mengakses, memperbarui, atau menghapus data pribadi</strong>
                        mereka. Dengan menggunakan layanan FindSrv, pengguna menyatakan
                        persetujuan terhadap seluruh prosedur pengolahan data serta
                        pembaruan kebijakan di masa mendatang.
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
