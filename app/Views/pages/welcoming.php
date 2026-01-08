<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FindSrv - Platform untuk menemukan dan menawarkan jasa profesional">
    <meta name="theme-color" content="#0d6efd">

    <!-- STYLESHEET & SCRIPTS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Selamat Datang di FindSrv!</title>

    <style>
        /* Mobile Responsive Enhancements */
        .jumbotron h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
        }

        .jumbotron p {
            font-size: clamp(0.95rem, 2.5vw, 1.25rem);
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        #welcome-footer ul {
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0;
        }

        #welcome-footer img {
            width: 60px;
            height: 60px;
        }

        /* Tablet Responsive (≤ 768px) */
        @media (max-width: 768px) {
            .jumbotron {
                margin: 2rem 1rem !important;
                padding: 2rem !important;
            }

            .btn-container {
                flex-direction: column;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }

            #welcoming-btn {
                width: 100%;
                margin: 0 !important;
            }

            #welcome-footer img {
                width: 55px;
                height: 55px;
            }
        }

        /* Mobile Responsive (≤ 576px) */
        @media (max-width: 576px) {
            .jumbotron {
                margin: 1rem 0.5rem !important;
                padding: 1.5rem !important;
            }

            .jumbotron h1 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            .jumbotron hr {
                margin: 2rem 0 !important;
            }

            .jumbotron p.lead {
                margin-bottom: 1rem;
            }

            #welcome-footer {
                margin-top: 1.5rem;
            }

            #welcome-footer img {
                width: 50px;
                height: 50px;
            }

            #welcome-footer ul li {
                padding: 0 0.5rem !important;
            }
        }

        /* Extra Small Mobile (≤ 400px) */
        @media (max-width: 400px) {
            .jumbotron {
                padding: 1rem !important;
            }

            #welcoming-btn {
                padding: 0.625rem 1.5rem;
                font-size: 1rem;
            }

            #welcome-footer img {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <div>
        <div class="container fade-in-fwd">
            
            <!-- JUMBOTRON -->
            <div class="jumbotron m-5 p-5 text-center">
                <h1 class="display-4 fw-bold py-4">
                    Selamat Datang!
                </h1>
                
                <p class="lead fw-bold">
                    FindSrv, sebuah ruang yang hadir untuk membantu Anda tetap produktif
                </p>
                
                <p class="lead fw-bold">
                    Jelajahi keterampilan dan potensi yang Anda miliki secara profesional!
                </p>
                
                <p class="lead fw-bold">
                    Bangun pengalaman nyata, hasilkan penghasilan dari keahlianmu, dan mulai perjalanan kariermu hari ini!
                </p>
                
                <hr class="my-5" style="height: 2px;">
                
                <div class="btn-container">
                    <a class="btn btn-primary btn-lg fw-bold mx-4" 
                       href="<?= base_url('login') ?>" 
                       role="button" 
                       id="welcoming-btn">
                        Login
                    </a>
                    
                    <a class="btn btn-primary btn-lg fw-bold mx-4" 
                       href="<?= base_url('register') ?>" 
                       role="button" 
                       id="welcoming-btn">
                        Register
                    </a>
                </div>
            </div>

            <!-- FOOTER -->
            <div id="welcome-footer">
                <ul class="d-flex flex-row justify-content-center list-unstyled">
                    <li class="px-4">
                        <a href="#" 
                           aria-label="GitHub" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <img src="<?= base_url('assets/images/icons/github.png') ?>" 
                                 alt="GitHub Icon">
                        </a>
                    </li>
                    
                    <li class="px-4">
                        <a href="#" 
                           aria-label="LinkedIn" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <img src="<?= base_url('assets/images/icons/linkedin.png') ?>" 
                                 alt="LinkedIn Icon">
                        </a>
                    </li>
                    
                    <li class="px-4">
                        <a href="#" 
                           aria-label="Instagram" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <img src="<?= base_url('assets/images/icons/instagram.png') ?>" 
                                 alt="Instagram Icon">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>