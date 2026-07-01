<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | OrgKampus</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23ea580c'/%3E%3Cstop offset='100%25' stop-color='%23f59e0b'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='32' height='32' rx='6' fill='url(%23g)'/%3E%3Ctext x='16' y='22' font-size='18' font-weight='800' text-anchor='middle' fill='white' font-family='system-ui'%3EO%3C/text%3E%3C/svg%3E">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('components.tailwind-config')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #09090b; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #09090b; }
        ::-webkit-scrollbar-thumb { background: #2a2a30; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #ea580c; }
    </style>
</head>
<body class="h-full bg-darkbg-950 text-zinc-100 flex items-stretch overflow-hidden">

    <div class="w-full grid grid-cols-12 min-h-screen">
        
        <!-- SISI KIRI: Branding Visual (Hidden on Mobile/Tablet) -->
        <div class="hidden lg:flex lg:col-span-5 relative overflow-hidden bg-black flex-col justify-between p-12 select-none border-r border-zinc-900">
            <div class="absolute top-[-10%] left-[-10%] w-[80%] h-[80%] rounded-full bg-brand-500/10 blur-[130px] animate-pulse-glow pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[70%] h-[70%] rounded-full bg-orange-700/10 blur-[120px] animate-pulse-glow pointer-events-none" style="animation-delay: 2.5s;"></div>
            
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center shadow-lg shadow-brand-500/35">
                    <i class="fa-solid fa-graduation-cap text-lg text-white"></i>
                </div>
                <span class="text-xl font-bold tracking-wider uppercase text-white">Org<span class="text-brand-500">Kampus</span></span>
            </div>

            <div class="space-y-6 relative z-10 my-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-semibold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-ping"></span>
                    Bergabung Sekarang
                </div>
                <h2 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight">
                    Mulai Perjalanan <span class="bg-gradient-to-r from-brand-400 to-amber-500 bg-clip-text text-transparent">Organisasi Anda</span>
                </h2>
                <p class="text-zinc-400 text-base leading-relaxed max-w-md">
                    Daftarkan akun untuk mulai mengelola anggota, program kerja, keuangan, hingga administrasi persuratan dalam satu platform terpadu.
                </p>
            </div>

            <div class="text-xs text-zinc-500 relative z-10">
                &copy; 2026 OrgKampus. Hak Cipta Dilindungi.
            </div>
        </div>

        <!-- SISI KANAN: Form Register -->
        <div class="col-span-12 lg:col-span-7 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-darkbg-950 relative overflow-y-auto">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-zinc-900/40 via-zinc-950 to-zinc-950 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full bg-brand-500/[0.04] blur-[100px] pointer-events-none"></div>

            <div class="lg:hidden absolute top-8 left-8 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap text-sm text-white"></i>
                </div>
                <span class="text-base font-bold text-white">Org<span class="text-brand-500">Kampus</span></span>
            </div>

            <div class="w-full max-w-[420px] bg-darkbg-900/40 backdrop-blur-md border border-zinc-800/80 rounded-2xl p-8 sm:p-10 shadow-2xl relative z-10 animate-fade-in-up my-auto">
                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-white tracking-tight">Buat Akun Baru</h3>
                    <p class="text-zinc-400 text-sm mt-1.5">Isi data di bawah ini untuk mendaftar akun.</p>
                </div>

                <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                                <div class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">Nama Organisasi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <input type="text" name="organization_name" class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-4 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200" placeholder="Contoh: Himpunan Mahasiswa Teknik" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="name" class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-4 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200" placeholder="John Doe" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">Email Akademik</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="email" name="email" class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-4 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200" placeholder="nama@kampus.ac.id" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" id="password" class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-11 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200" placeholder="Min. 8 karakter, huruf besar/kecil & angka" required>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-500 hover:text-brand-500 transition-colors">
                                <i class="fa-solid fa-eye text-sm" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password_confirmation" class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-4 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200" placeholder="Ketik ulang password" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold py-3 rounded-xl shadow-lg shadow-brand-600/15 hover:shadow-brand-500/30 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Daftar Sekarang</span>
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <span class="text-sm text-zinc-400">Sudah punya akun? </span>
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-500 hover:text-brand-400 transition-colors">Masuk di sini</a>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
