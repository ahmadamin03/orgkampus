<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrgKampus - Sistem Manajemen Organisasi</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23ea580c'/%3E%3Cstop offset='100%25' stop-color='%23f59e0b'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='32' height='32' rx='6' fill='url(%23g)'/%3E%3Ctext x='16' y='22' font-size='18' font-weight='800' text-anchor='middle' fill='white' font-family='system-ui'%3EO%3C/text%3E%3C/svg%3E">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('components.tailwind-config')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #09090b; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #09090b; }
        ::-webkit-scrollbar-thumb { background: #2a2a30; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #ea580c; }

        .glass-nav {
            background: rgba(9, 9, 11, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="text-zinc-100 min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Background Effects -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-20%] left-[-10%] w-[70vw] h-[70vw] rounded-full bg-brand-600/10 blur-[120px] animate-pulse-glow"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60vw] h-[60vw] rounded-full bg-amber-500/10 blur-[120px] animate-pulse-glow" style="animation-delay: 2s;"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center shadow-lg shadow-brand-500/30">
                    <i class="fa-solid fa-graduation-cap text-lg text-white"></i>
                </div>
                <span class="text-xl font-bold tracking-wider uppercase text-white">Org<span class="text-brand-500">Kampus</span></span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-300">
                <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                <a href="#tentang" class="hover:text-white transition-colors">Tentang</a>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors px-4 py-2">Sign In</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/10 px-5 py-2.5 rounded-full transition-all">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center pt-32 pb-20 relative z-10">
        <div class="max-w-7xl mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Hero Text -->
            <div class="space-y-8 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs sm:text-sm font-semibold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                    Sistem Manajemen Organisasi #1
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.1] tracking-tight">
                    Kelola <span class="bg-gradient-to-r from-brand-400 to-amber-400 bg-clip-text text-transparent">Organisasi</span><br>
                    Lebih Efisien
                </h1>

                <p class="text-lg text-zinc-400 leading-relaxed max-w-xl">
                    Satu platform terintegrasi untuk mengelola anggota, program kerja, keuangan, hingga persuratan. Tinggalkan cara lama, beralih ke digital.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-bold px-8 py-4 rounded-full shadow-xl shadow-brand-500/20 hover:shadow-brand-500/40 transition-all hover:-translate-y-1 flex items-center gap-2">
                        Mulai Sekarang Gratis
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-full font-bold text-white bg-zinc-900 border border-zinc-800 hover:bg-zinc-800 transition-all flex items-center gap-2">
                        Preview Demo
                    </a>
                </div>
            </div>

            <!-- Hero Image / Visual -->
            <div class="relative lg:h-[600px] flex items-center justify-center animate-float">
                <!-- Abstract Dashboard Mockup -->
                <div class="w-full max-w-lg aspect-square relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-600/30 to-amber-500/30 rounded-3xl rotate-6 scale-105 blur-md"></div>
                    <div class="absolute inset-0 bg-darkbg-900 border border-zinc-800 rounded-3xl shadow-2xl overflow-hidden flex flex-col">
                        <!-- Mockup Header -->
                        <div class="h-12 border-b border-zinc-800 bg-zinc-950 flex items-center px-4 gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                        </div>
                        <!-- Mockup Body -->
                        <div class="flex-1 p-6 grid grid-cols-2 gap-4">
                            <div class="col-span-2 bg-zinc-950 rounded-xl h-24 border border-zinc-800/50 flex items-center p-4 gap-4">
                                <div class="w-12 h-12 rounded-lg bg-brand-500/20"></div>
                                <div class="space-y-2 flex-1">
                                    <div class="h-3 w-1/3 bg-zinc-800 rounded-full"></div>
                                    <div class="h-2 w-1/4 bg-zinc-800/50 rounded-full"></div>
                                </div>
                            </div>
                            <div class="bg-zinc-950 rounded-xl h-32 border border-zinc-800/50 p-4 space-y-3">
                                <div class="w-8 h-8 rounded-full bg-amber-500/20"></div>
                                <div class="h-2 w-3/4 bg-zinc-800 rounded-full"></div>
                                <div class="h-2 w-1/2 bg-zinc-800/50 rounded-full"></div>
                            </div>
                            <div class="bg-zinc-950 rounded-xl h-32 border border-zinc-800/50 p-4 space-y-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-500/20"></div>
                                <div class="h-2 w-3/4 bg-zinc-800 rounded-full"></div>
                                <div class="h-2 w-1/2 bg-zinc-800/50 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -right-6 top-20 bg-darkbg-800 border border-zinc-700 p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Tugas Selesai</div>
                            <div class="text-xs text-zinc-400">Baru saja diperbarui</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Features Overview -->
    <section id="fitur" class="py-24 bg-zinc-950 relative z-10 border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 space-y-4">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">5 Fitur Unggulan</h2>
                <p class="text-zinc-400 max-w-2xl mx-auto">Semua yang Anda butuhkan untuk menjalankan roda organisasi kampus ada dalam satu genggaman.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-darkbg-900 border border-zinc-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Database Anggota</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed">Kelola data seluruh pengurus, riwayat jabatan, dan informasi kontak dalam satu direktori aman.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-darkbg-900 border border-zinc-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clipboard-list-check"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Program Kerja & Tugas</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed">Rencanakan proker, delegasikan tugas, dan pantau progres pelaksanaannya secara real-time.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-darkbg-900 border border-zinc-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-calendar-star"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Kepanitiaan Event</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed">Bentuk susunan panitia per kegiatan secara spesifik dan atur kolaborasi dengan mudah.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-darkbg-900 border border-zinc-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Arsip Persuratan</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed">Catat nomor surat masuk dan keluar secara rapi tanpa takut dokumen hilang atau terselip.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-darkbg-900 border border-zinc-800 p-8 rounded-3xl hover:border-brand-500/50 transition-colors group lg:col-span-2">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Keuangan Transparan</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed">Buku kas digital untuk mencatat iuran anggota, dana masuk, hingga laporan pengeluaran operasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang -->
    <section id="tentang" class="py-24 relative z-10">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Tentang OrgKampus</h2>
            <p class="text-zinc-400 leading-relaxed max-w-2xl mx-auto">
                OrgKampus adalah platform manajemen organisasi kampus berbasis web yang dirancang untuk membantu
                himpunan mahasiswa, UKM, dan badan eksekutif mengelola anggota, program kerja, keuangan, surat-menyurat,
                dan acara secara digital dan terintegrasi.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-8 border-t border-zinc-900 relative z-10 text-center">
        <p class="text-zinc-500 text-sm">&copy; 2026 OrgKampus. All rights reserved.</p>
    </footer>

</body>
</html>
