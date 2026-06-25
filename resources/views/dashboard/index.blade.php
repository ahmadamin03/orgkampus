@extends('layouts.dashboard')

@section('title', 'Dasbor Utama')
@section('page_title', 'Dasbor Utama')

@section('content')
<!-- STATS ROW -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
        <div class="space-y-1">
            <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Total Anggota</span>
            <h3 class="text-3xl font-extrabold text-white">{{ $totalMembers }}</h3>
            <span class="text-xs text-brand-500 font-medium">Terdaftar di sistem</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-500 shadow-md shadow-brand-500/5">
            <i class="fa-solid fa-users text-xl"></i>
        </div>
    </div>

    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
        <div class="space-y-1">
            <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Program Kerja</span>
            <h3 class="text-3xl font-extrabold text-white">{{ $totalProkers }}</h3>
            <span class="text-xs text-brand-500 font-medium">Rencana & terlaksana</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-500 shadow-md shadow-brand-500/5">
            <i class="fa-solid fa-clipboard-list text-xl"></i>
        </div>
    </div>

    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
        <div class="space-y-1">
            <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Event Kampus</span>
            <h3 class="text-3xl font-extrabold text-white">{{ $totalEvents }}</h3>
            <span class="text-xs text-brand-500 font-medium">Kepanitiaan aktif</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-500 shadow-md shadow-brand-500/5">
            <i class="fa-solid fa-calendar-days text-xl"></i>
        </div>
    </div>

    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
        <div class="space-y-1">
            <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Arsip Surat</span>
            <h3 class="text-3xl font-extrabold text-white">{{ $totalSurats }}</h3>
            <span class="text-xs text-brand-500 font-medium">Surat masuk & keluar</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-500 shadow-md shadow-brand-500/5">
            <i class="fa-solid fa-file-invoice text-xl"></i>
        </div>
    </div>
</div>

<!-- KAS BALANCES & CORE PANEL -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-gradient-to-br from-zinc-950 to-darkbg-900 border border-zinc-900 rounded-2xl p-6 shadow-xl flex flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-32 h-32 rounded-full bg-brand-500/10 blur-2xl"></div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-zinc-400 font-medium">Saldo Kas Organisasi</span>
                <i class="fa-solid fa-vault text-brand-500 text-lg"></i>
            </div>
            <div>
                <h2 class="text-3xl font-black tracking-tight text-white">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </h2>
                <p class="text-xs text-zinc-500 mt-1">Saldo mutasi kas gabungan terkini</p>
            </div>
        </div>

        <div class="pt-6 border-t border-zinc-900 mt-6 flex items-center justify-between text-xs">
            <a href="{{ route('keuangans.index') }}" class="text-brand-500 hover:text-brand-400 font-semibold flex items-center gap-1.5 transition-colors">
                <span>Kelola Keuangan Kas</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <span class="text-zinc-500">IDR (Rupiah)</span>
        </div>
    </div>

    <div class="lg:col-span-2 bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
                <h3 class="text-md font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-tasks text-brand-500"></i>
                    <span>Tugas Berjalan Terkini</span>
                </h3>
                <span class="text-xs bg-brand-500/10 text-brand-400 px-2 py-0.5 rounded-full font-semibold">Tugas Aktif</span>
            </div>
            
            <div class="divide-y divide-zinc-900 overflow-hidden">
                @php
                    $activeTasks = \App\Models\Tugas::with(['proker', 'assignee'])
                        ->where('status', 'Ongoing')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                @forelse($activeTasks as $task)
                <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-zinc-200 truncate">{{ $task->title }}</h4>
                            <p class="text-[10px] text-zinc-500 truncate">{{ $task->proker->name }} &middot; {{ $task->assignee?->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>
                    @if($task->due_date)
                    <span class="text-[10px] text-zinc-500 flex-shrink-0 ml-2">{{ date('d M', strtotime($task->due_date)) }}</span>
                    @endif
                </div>
                @empty
                <div class="py-6 text-center text-zinc-500">
                    <i class="fa-solid fa-check-double text-2xl text-zinc-700 mb-2 block"></i>
                    <span class="text-sm">Belum ada tugas atau proker yang sedang berjalan.</span>
                </div>
                @endforelse
            </div>
        </div>
        <div class="pt-4 border-t border-zinc-900 mt-4 text-right">
            <a href="{{ route('prokers.index') }}" class="text-xs text-brand-500 hover:text-brand-400 font-semibold flex items-center justify-end gap-1.5 transition-colors">
                <span>Lihat Seluruh Proker</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- BOTTOM DATA TABLES -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
            <h3 class="text-md font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-arrow-right-arrow-left text-brand-500"></i>
                <span>Mutasi Kas Terbaru</span>
            </h3>
            <i class="fa-solid fa-receipt text-zinc-600"></i>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase">
                        <th class="pb-2">Tanggal</th>
                        <th class="pb-2">Kategori</th>
                        <th class="pb-2 text-right">Jumlah</th>
                        <th class="pb-2 text-center">Tipe</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-900">
                    @forelse($recentTransactions as $tx)
                    <tr>
                        <td class="py-3 text-xs text-zinc-400">{{ date('d M', strtotime($tx->date)) }}</td>
                        <td class="py-3 text-xs text-zinc-300">{{ $tx->category }}</td>
                        <td class="py-3 text-xs text-right font-semibold {{ $tx->type == 'Pemasukan' ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $tx->type == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                        </td>
                        <td class="py-3 text-center">
                            <span class="text-[10px] px-2 py-0.5 rounded-full {{ $tx->type == 'Pemasukan' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $tx->type }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-zinc-500 text-xs">
                            Belum ada riwayat transaksi mutasi kas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-zinc-900 pb-3">
            <h3 class="text-md font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-folder-closed text-brand-500"></i>
                <span>Arsip Surat Terbaru</span>
            </h3>
            <i class="fa-solid fa-file-shield text-zinc-600"></i>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase">
                        <th class="pb-2">Nomor & Tanggal</th>
                        <th class="pb-2">Perihal</th>
                        <th class="pb-2">Tipe</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-900">
                    @forelse($recentLetters as $letter)
                    <tr>
                        <td class="py-3 text-xs">
                            <span class="text-zinc-200 font-semibold">{{ $letter->nomor_surat }}</span>
                            <span class="text-zinc-500 block">{{ date('d M Y', strtotime($letter->tanggal)) }}</span>
                        </td>
                        <td class="py-3 text-xs text-zinc-300">{{ $letter->perihal }}</td>
                        <td class="py-3">
                            <span class="text-[10px] px-2 py-0.5 rounded-full {{ $letter->type == 'Masuk' ? 'bg-blue-500/10 text-blue-400' : 'bg-purple-500/10 text-purple-400' }}">
                                {{ $letter->type }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-zinc-500 text-xs">
                            Belum ada arsip surat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
