<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Beranda</title>
</head>
<body>
    <div class="container-fluid fade-in-fwd p-0">
        
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fw-bold" style="width: 100%;">
            <div class="container-fluid mx-5 my-3">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/icons/logo.png') ?>" style="width: 80px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-5 px-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Rekomendasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Jelajahi Jasa</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Riwayat</a>
                        </li>
                    </ul>
                    <form class="d-flex mx-5 px-5">
                        <input class="form-control me-2" type="search" placeholder="Cari Jasa" aria-label="Cari Jasa">
                        <button class="btn fw-bold btn-primary" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- BANNER -->
        <div class="img-container my-4">
            <img src="<?= base_url('assets/images/homepage/homepage_illustration.jpg') ?>">
            <div class="fade-text">
                <p>Selamat Datang di FindSrv</p>
                <p class="fs-4">Akses berbagai layanan profesional dengan proses yang cepat dan aman</p>
            </div>
        </div>

        <h3 class="text-center m-0 py-5">Fitur Unggulan untuk Mendukung Proses Kerja yang Aman dan Efisien</h3>

        <!-- FEATURING CARD -->
        <div class="row description mx-3 my-5">
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/terpercaya.jpg') ?>" class="rounded-start">
                    <div class="card rounded-end">
                        <div class="card-body">
                            <h5 class="card-title">Terpercaya</h5>
                            <p class="card-text">
                                Platform ini dirancang untuk menyediakan layanan yang aman, transparan, dan dapat dipercaya,
                                sehingga Anda dapat menggunakan jasa dengan tenang dan percaya diri.
                            </p>
                        </div>
                    </div>
                </div>             
            </div>
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/profesional.jpg') ?>" class="rounded-start">
                    <div class="card rounded-end">
                        <div class="card-body">
                            <h5 class="card-title">Profesional</h5>
                            <p class="card-text">
                                Nikmati layanan jasa dengan standar kerja yang terstruktur, efisien, dan berorientasi pada hasil,
                                didukung perencanaan yang matang, komunikasi yang jelas, serta komitmen pada kualitas dan ketepatan waktu.
                            </p>
                        </div>
                    </div>
                </div>             
            </div>
            <div class="col-4">
                <div class="card-media">
                    <img src="<?= base_url('assets/images/homepage/komunikasi.jpg') ?>" class="rounded-start">
                    <div class="card rounded-end">
                        <div class="card-body">
                            <h5 class="card-title">Komunikasi</h5>
                            <p class="card-text">
                                Platform ini dirancang dengan sistem komunikasi yang jelas dan terstruktur, 
                                memungkinkan proses negosiasi berlangsung lebih efektif, transparan, dan efisien.
                            </p>
                        </div>
                    </div>
                </div>             
            </div>
        </div>
    </div>
</body>
</html>