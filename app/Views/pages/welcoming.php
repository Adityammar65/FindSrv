<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Selamat Datang di FindSrv!</title>
</head>

<body>
    <div>
        <div class="container fade-in-fwd">
            
            <!-- JUMBOTRON -->
            <div class="jumbotron m-5 p-5 text-center">
                <h1 class="display-4 fw-bold py-4">Selamat Datang!</h1>
                <p class="lead fw-bold">FindSrv, sebuah ruang yang hadir untuk membantu Anda tetap produktif</p>
                <p class="lead fw-bold">Jelajahi keterampilan dan potensi yang Anda miliki secara profesional!</p>
                <p class="lead fw-bold">Bangun pengalaman nyata, hasilkan penghasilan dari keahlianmu, dan mulai perjalanan kariermu hari ini!</p>
                <hr class="my-5" style="height: 2px;">
                <a class="btn btn-primary btn-lg fw-bold mx-4" href="<?= base_url('login') ?>" role="button" id="welcoming-btn">Login</a>
                <a class="btn btn-primary btn-lg fw-bold mx-4" href="<?= base_url('register') ?>" role="button" id="welcoming-btn">Register</a>
            </div>

            <!-- FOOTER -->
            <div id="welcome-footer">
                <ul class="d-flex flex-row justify-content-center list-unstyled">
                    <li class="px-4">
                        <a href="#"><img src="<?= base_url('assets/images/icons/github.png') ?>" style="width: 60px;"></a>
                    </li>
                    <li class="px-4">
                        <a href="#"><img src="<?= base_url('assets/images/icons/linkedin.png') ?>" style="width: 60px;"></a>
                    </li>
                    <li class="px-4">
                        <a href="#"><img src="<?= base_url('assets/images/icons/instagram.png') ?>" style="width: 60px;"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>