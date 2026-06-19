<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Organisasi Kampus</title>
    <!-- Use direct path for simple HTML static files or relative if hosted -->
    <!-- Let's use relative path correctly from resources/views/auth/ to public/css/ -->
    <link rel="stylesheet" href="/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">

    <div class="card login-card">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap text-primary"></i> <span class="text-primary">Org</span>Kampus
        </div>
        <p>Masuk ke akun kepengurusan Anda</p>

        <form action="index.php?route=login&action=process" method="POST">
            <div class="form-group" style="text-align: left;">
                <label for="email" class="form-label">Email / NIM</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email atau NIM" required>
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.75rem;">Masuk</button>
        </form>

        <p style="margin-top: 1.5rem; font-size: 0.9rem;">
            Belum punya akun? <a href="index.php?route=signup" class="text-primary" style="font-weight: 500;">Sign Up di sini</a>
        </p>
    </div>

</body>
</html>
