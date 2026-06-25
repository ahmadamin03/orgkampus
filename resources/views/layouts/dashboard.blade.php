<!DOCTYPE html>
<html lang="id" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor') | OrgKampus</title>

    <!-- Google Fonts -->
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
                            950: '#09090b',
                            900: '#121214',
                            800: '#1e1e24',
                            700: '#2a2a30',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out forwards',
                        'fade-in-up': 'fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
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
        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e1e24;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }
    </style>
</head>
<body class="h-full text-zinc-100 flex overflow-hidden">

    <!-- SIDEBAR FOR DESKTOP -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-black border-r border-zinc-900 flex flex-col transform -translate-x-full lg:translate-x-0 lg:static lg:h-full transition-transform duration-300 ease-in-out">
        <!-- Sidebar Header / Logo -->
        <div class="h-16 flex items-center gap-3 px-6 border-b border-zinc-900 flex-shrink-0">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center shadow-lg shadow-brand-500/30">
                <i class="fa-solid fa-graduation-cap text-sm text-white"></i>
            </div>
            <span class="text-lg font-bold tracking-wider uppercase text-white">Org<span class="text-brand-500">Kampus</span></span>
        </div>

        <!-- Navigation Links (scrollable) -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1.5">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('dashboard')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-base"></i>
                    <span>Dasbor</span>
                </a>

                <!-- Manajemen Anggota -->
                <a href="{{ route('members.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('members.*')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-users w-5 text-center text-base"></i>
                    <span>Anggota</span>
                </a>

                <!-- Manajemen Program Kerja & Tugas -->
                <a href="{{ route('prokers.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('prokers.*')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-clipboard-list-check w-5 text-center text-base"></i>
                    <span>Program Kerja & Tugas</span>
                </a>

                <!-- Manajemen Event & Kepanitiaan -->
                <a href="{{ route('events.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('events.*')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-calendar-star w-5 text-center text-base"></i>
                    <span>Event & Panitia</span>
                </a>

                <!-- Manajemen Surat & Administrasi -->
                <a href="{{ route('surats.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('surats.*')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-envelope-open-text w-5 text-center text-base"></i>
                    <span>Surat & Administrasi</span>
                </a>

                <!-- Manajemen Keuangan -->
                <a href="{{ route('keuangans.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 @if(request()->routeIs('keuangans.*')) bg-brand-500/10 text-brand-400 border-l-4 border-brand-500 pl-3 @else text-zinc-400 hover:text-white hover:bg-zinc-900/60 @endif">
                    <i class="fa-solid fa-wallet w-5 text-center text-base"></i>
                    <span>Keuangan Kas</span>
                </a>
            </nav>

        <!-- User Profile Footer / Logout -->
        <div class="p-4 border-t border-zinc-900 bg-zinc-950/40 flex-shrink-0">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center font-bold text-white shadow-inner text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</h4>
                    <span class="text-xs text-zinc-500 truncate block">{{ auth()->user()->role_organisasi }}</span>
                </div>
            </div>
            <div class="text-xs text-zinc-600 px-1 mb-3 truncate">
                {{ auth()->user()->organization?->name }}
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold border border-zinc-800 hover:border-red-500/30 text-zinc-400 hover:text-red-400 hover:bg-red-500/5 transition-all duration-200">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- OVERLAY FOR MOBILE SIDEBAR -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <!-- MAIN VIEW AREA -->
    <main class="flex-1 flex flex-col min-w-0 relative h-full">
        <!-- TOP NAVBAR -->
        <header class="h-16 bg-darkbg-950 border-b border-zinc-900 flex items-center justify-between px-6 z-30">
            <div class="flex items-center gap-4">
                <button id="toggle-sidebar-btn" class="lg:hidden p-1.5 text-zinc-400 hover:text-white hover:bg-zinc-900 rounded-lg transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-white">@yield('page_title', 'Dasbor')</h1>
            </div>
            <div class="text-xs sm:text-sm text-zinc-500">
                {{ auth()->user()->organization?->name ?? 'OrgKampus' }}
            </div>
        </header>

        <!-- MAIN SCROLLABLE CONTENT -->
        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-brand-500/10 border border-brand-500/25 text-brand-400 p-4 rounded-2xl flex items-start gap-3 shadow-lg shadow-brand-500/5 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-lg mt-0.5 flex-shrink-0 text-brand-400"></i>
                    <div class="text-sm font-medium">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl flex items-start gap-3 shadow-lg animate-fade-in">
                    <i class="fa-solid fa-circle-xmark text-lg mt-0.5 flex-shrink-0 text-red-400"></i>
                    <div class="text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('toggle-sidebar-btn');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
    </script>
</body>
</html>
