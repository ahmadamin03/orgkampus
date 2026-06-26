<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terlalu Banyak Percobaan | OrgKampus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12', 950: '#431407' },
                        darkbg: { 950: '#09090b', 900: '#121214', 800: '#1e1e24', 700: '#2a2a30' }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #09090b; }
    </style>
</head>
<body class="h-full bg-darkbg-950 text-zinc-100 flex items-center justify-center p-6">
    <div class="w-full max-w-md text-center space-y-6">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center">
            <i class="fa-solid fa-hourglass-end text-2xl text-red-400"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-white">429</h1>
        <h2 class="text-xl font-semibold text-zinc-200">Terlalu Banyak Percobaan</h2>
        <p class="text-zinc-400 text-sm leading-relaxed">
            Terlalu banyak permintaan pendaftaran dari alamat ini. Silakan tunggu beberapa saat sebelum mencoba lagi.
        </p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-brand-600/15">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Pendaftaran</span>
        </a>
    </div>
</body>
</html>
