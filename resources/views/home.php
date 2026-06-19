<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Organisasi Kampus</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .landing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        .landing-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 80px 2rem 0;
            background: radial-gradient(circle at center, #1e1e1e 0%, #121212 100%);
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .hero-title span {
            color: var(--primary-color);
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 650px;
            margin-bottom: 3rem;
            line-height: 1.6;
        }
        .hero-actions {
            display: flex;
            gap: 1.5rem;
        }
        .btn-large {
            padding: 0.85rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-actions { flex-direction: column; width: 100%; max-width: 300px; gap: 1rem; }
            .btn-large { width: 100%; }
        }
    </style>
</head>
<body class="landing-body" style="background-color: var(--bg-dark); color: var(--text-main); font-family: 'Inter', sans-serif; margin: 0;">
    <header class="landing-header">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap text-primary" style="font-size: 1.5rem;"></i> 
            <span class="text-primary" style="font-weight: 700; font-size: 1.5rem; margin-left: 0.5rem;">Org</span><span style="font-weight: 700; font-size: 1.5rem;">Kampus</span>
        </div>
        <div class="header-actions">
            <a href="index.php?route=login" class="btn btn-outline" style="margin-right: 0.5rem; border-radius: 6px;">Sign In</a>
            <a href="index.php?route=signup" class="btn btn-primary" style="border-radius: 6px;">Sign Up</a>
        </div>
    </header>

    <section class="landing-hero">
        <h1 class="hero-title">Kelola Organisasi Kampus<br>Lebih <span>Modern & Efisien</span></h1>
        <p class="hero-subtitle">Platform lengkap untuk manajemen anggota, program kerja, kas keuangan, dan arsip dokumen dalam satu tempat.</p>
        <div class="hero-actions">
            <a href="index.php?route=signup" class="btn btn-primary btn-large">Mulai Sekarang</a>
            <a href="index.php?route=login" class="btn btn-outline btn-large">Sign In</a>
        </div>
    </section>
</body>
</html>
