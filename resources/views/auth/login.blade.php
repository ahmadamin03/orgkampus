<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | OrgKampus</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316', // Orange
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                            950: '#431407',
                        },
                        darkbg: {
                            950: '#09090b', // Zinc-950
                            900: '#121214', // Zinc-900 custom
                            800: '#1e1e24', // Zinc-800 custom
                            700: '#2a2a30',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'pulse-glow': 'pulseGlow 5s infinite alternate ease-in-out',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        pulseGlow: {
                            '0%': { opacity: '0.2', transform: 'scale(1) translate(0px, 0px)' },
                            '50%': { opacity: '0.4', transform: 'scale(1.08) translate(10px, -10px)' },
                            '100%': { opacity: '0.2', transform: 'scale(1) translate(0px, 0px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
        }
        /* Custom scrollbar just in case */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b;
        }
        ::-webkit-scrollbar-thumb {
            background: #2a2a30;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }
    </style>
</head>
<body class="h-full bg-darkbg-950 text-zinc-100 flex items-stretch overflow-hidden">

    <div class="w-full grid grid-cols-12 min-h-screen">
        
        <!-- SISI KIRI: Branding Visual (Hidden on Mobile/Tablet) -->
        <div class="hidden lg:flex lg:col-span-5 relative overflow-hidden bg-black flex-col justify-between p-12 select-none border-r border-zinc-900">
            <!-- Glowing Background Orbs -->
            <div class="absolute top-[-10%] left-[-10%] w-[80%] h-[80%] rounded-full bg-brand-500/10 blur-[130px] animate-pulse-glow pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[70%] h-[70%] rounded-full bg-orange-700/10 blur-[120px] animate-pulse-glow pointer-events-none" style="animation-delay: 2.5s;"></div>
            
            <!-- Logo / Top Info -->
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center shadow-lg shadow-brand-500/35">
                    <i class="fa-solid fa-graduation-cap text-lg text-white"></i>
                </div>
                <span class="text-xl font-bold tracking-wider uppercase text-white">Org<span class="text-brand-500">Kampus</span></span>
            </div>

            <!-- Middle Text content -->
            <div class="space-y-6 relative z-10 my-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-semibold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-ping"></span>
                    Sistem Dasbor Terbaru v2.0
                </div>
                <h2 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight">
                    Kelola Kampus dengan <span class="bg-gradient-to-r from-brand-400 to-amber-500 bg-clip-text text-transparent">Lebih Efisien</span>
                </h2>
                <p class="text-zinc-400 text-base leading-relaxed max-w-md">
                    Portal terpadu untuk mengelola organisasi, kegiatan akademik, dan administrasi kemahasiswaan dalam satu dasbor modern yang cepat dan responsif.
                </p>
            </div>

            <!-- Bottom Credits -->
            <div class="text-xs text-zinc-500 relative z-10">
                &copy; 2026 OrgKampus. Hak Cipta Dilindungi.
            </div>
        </div>

        <!-- SISI KANAN: Form Login -->
        <div class="col-span-12 lg:col-span-7 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-darkbg-950 relative overflow-y-auto">
            <!-- Background Radial Glow -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-zinc-900/40 via-zinc-950 to-zinc-950 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] rounded-full bg-brand-500/[0.04] blur-[100px] pointer-events-none"></div>

            <!-- Top Logo for Mobile -->
            <div class="lg:hidden absolute top-8 left-8 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap text-sm text-white"></i>
                </div>
                <span class="text-base font-bold text-white">Org<span class="text-brand-500">Kampus</span></span>
            </div>

            <!-- Card Form Container -->
            <div class="w-full max-w-[420px] bg-darkbg-900/40 backdrop-blur-md border border-zinc-800/80 rounded-2xl p-8 sm:p-10 shadow-2xl relative z-10 animate-fade-in-up">
                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-white tracking-tight">Selamat Datang Kembali</h3>
                    <p class="text-zinc-400 text-sm mt-1.5">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 flex items-start gap-3 animate-fade-in-up">
                        <i class="fa-solid fa-triangle-exclamation mt-0.5 text-base flex-shrink-0 text-red-400"></i>
                        <div class="text-xs sm:text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email input -->
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-zinc-300 mb-2">
                            Email Akademik
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input
                                type="email"
                                name="email"
                                class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-4 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200"
                                placeholder="nama@kampus.ac.id"
                                required
                            >
                        </div>
                    </div>

                    <!-- Password input -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-xs sm:text-sm font-semibold text-zinc-300">
                                Password
                            </label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-500">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full bg-black/40 border border-zinc-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 text-white rounded-xl pl-10 pr-11 py-3 text-sm placeholder-zinc-600 outline-none transition-all duration-200"
                                placeholder="Masukkan Password"
                                required
                            >
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-zinc-500 hover:text-brand-500 transition-colors"
                                title="Tampilkan Password"
                            >
                                <i class="fa-solid fa-eye text-sm" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot option -->
                    <div class="flex justify-between items-center pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-zinc-800 bg-black text-brand-500 focus:ring-brand-500/20 focus:ring-offset-darkbg-900 focus:ring-2 accent-brand-500"
                            >
                            <span class="text-xs text-zinc-400 hover:text-zinc-300 transition-colors">Ingat saya</span>
                        </label>

                        <a href="#" class="text-xs text-brand-500 hover:text-brand-400 font-semibold transition-colors">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full mt-4 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold py-3 rounded-xl shadow-lg shadow-brand-600/15 hover:shadow-brand-500/30 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Masuk ke Dasbor</span>
                        <i class="fa-solid fa-arrow-right-to-bracket text-sm"></i>
                    </button>
                </form>

            </div>
        </div>

    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon class
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                togglePassword.setAttribute('title', 'Sembunyikan Password');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                togglePassword.setAttribute('title', 'Tampilkan Password');
            }
        });
    </script>
</body>
</html>