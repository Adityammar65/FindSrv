<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <title>Register</title>
</head>
<body>
    <div class="glass-bg d-flex justify-content-center align-items-center">
        <div class="container fade-in-fwd">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 glow" id="auth">
                    <form action="<?= base_url('auth/saveRegister') ?>" method="post" class="d-flex flex-column">
                        <label class="fw-bold">Username</label>
                        <input name="username" type="text" class="form-control my-2" placeholder="Username" required>
                        <label class="fw-bold">Email</label>
                        <input name="email" type="email" class="form-control my-2" placeholder="Email" required>
                        <label class="fw-bold">Password (8 karakter)</label>
                        <input name="password" type="password" class="form-control my-2" placeholder="Password" required>
                        <label class="fw-bold">Daftar Sebagai</label>
                        <select name="role" class="form-select my-2" required>
                            <option value="penyedia">Penyedia Jasa</option>
                            <option value="pengguna">Pengguna Jasa</option>
                        </select>
                        <button type="submit" class="btn btn-success my-3 fw-bold">Daftar</button>
                        <a class="btn btn-danger fw-bold mb-3" href="<?= base_url() ?>" role="button">Batal</a>
                    </form>
                    <p class="text-center fw-bold mt-2">Sudah punya akun?<a href="<?= base_url('login') ?>" class="fw-bold px-2">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>