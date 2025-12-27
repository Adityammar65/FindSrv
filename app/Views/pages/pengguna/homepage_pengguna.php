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
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-5 px-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Rekomendasi</a>
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
        <h1>Selamat Datang!</h1>
    </div>
</body>
</html>