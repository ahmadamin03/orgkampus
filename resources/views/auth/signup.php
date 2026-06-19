<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Sistem Manajemen Organisasi Kampus</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">

    <div class="card login-card" style="max-width: 450px;">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap text-primary"></i> <span class="text-primary">Org</span>Kampus
        </div>
        <p>Buat akun kepengurusan baru</p>

        <form action="index.php?route=signup&action=process" method="POST">
            <div class="form-group" style="text-align: left;">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" name="name" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="form-group" style="text-align: left;">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan Nomor Induk Mahasiswa" required>
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email Kampus" required>
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Buat Password" required>
            </div>

            <div class="form-group" style="text-align: left;">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.75rem;">Daftar</button>
        </form>

        <p style="margin-top: 1.5rem; font-size: 0.9rem;">
            Sudah punya akun? <a href="index.php?route=login" class="text-primary" style="font-weight: 500;">Sign In di sini</a>
        </p>
    </div>

</body>
</html>
