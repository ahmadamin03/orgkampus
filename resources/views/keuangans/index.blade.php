@extends('layouts.dashboard')

@section('title', 'Pembukuan Kas Keuangan')
@section('page_title', 'Keuangan Kas')

@section('content')
<div class="space-y-6">
    <!-- FINANCE STATS ROW -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Pemasukan -->
        <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
            <div class="space-y-1">
                <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Total Pemasukan</span>
                <h3 class="text-2xl font-black text-emerald-400">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                <span class="text-xs text-zinc-500 font-medium">Debit kas terakumulasi</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shadow-md shadow-emerald-500/5">
                <i class="fa-solid fa-arrow-down-left text-xl"></i>
            </div>
        </div>

        <!-- Pengeluaran -->
        <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 p-5 rounded-2xl flex items-center justify-between shadow-xl">
            <div class="space-y-1">
                <span class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">Total Pengeluaran</span>
                <h3 class="text-2xl font-black text-red-400">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                <span class="text-xs text-zinc-500 font-medium">Kredit kas terpakai</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 shadow-md shadow-red-500/5">
                <i class="fa-solid fa-arrow-up-right text-xl"></i>
            </div>
        </div>

        <!-- Saldo Bersih -->
        <div class="bg-zinc-950/90 border border-brand-500/30 p-5 rounded-2xl flex items-center justify-between shadow-2xl relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-brand-500/10 blur-xl"></div>
            
            <div class="space-y-1 z-10">
                <span class="text-xs text-zinc-400 font-semibold uppercase tracking-wider">Saldo Bersih (Kas Aktif)</span>
                <h3 class="text-2xl font-black text-white">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                <span class="text-xs text-brand-500 font-semibold">Tersedia untuk kegiatan</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-brand-500/20 z-10">
                <i class="fa-solid fa-vault text-xl"></i>
            </div>
        </div>
    </div>

    <!-- MUTASI LEDGER -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl shadow-xl">
        <!-- Controls Header -->
        <div class="p-6 border-b border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-md font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-brand-500"></i>
                    <span>Buku Mutasi Kas Organisasi</span>
                </h3>
                <p class="text-xs text-zinc-500 mt-1">Daftar transaksi arus kas keluar masuk.</p>
            </div>
            <button onclick="toggleModal('create-transaction-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-plus-circle text-xs"></i>
                <span>Catat Transaksi</span>
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase bg-zinc-950/20">
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Kategori & Keterangan</th>
                        <th class="px-6 py-3.5 text-right">Jumlah</th>
                        <th class="px-6 py-3.5 text-center">Tipe</th>
                        <th class="px-6 py-3.5">Dicatat Oleh</th>
                        <th class="px-6 py-3.5 text-right">Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-900">
                    @forelse($keuangans as $keuangan)
                    <tr class="hover:bg-zinc-900/10 transition-colors">
                        <td class="px-6 py-4 text-xs text-zinc-400">{{ date('d M Y', strtotime($keuangan->date)) }}</td>
                        <td class="px-6 py-4">
                            <h4 class="font-semibold text-zinc-200 text-sm">{{ $keuangan->category }}</h4>
                            <p class="text-xs text-zinc-500 mt-0.5">{{ $keuangan->description ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-extrabold {{ $keuangan->type == 'Pemasukan' ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $keuangan->type == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($keuangan->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $keuangan->type == 'Pemasukan' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $keuangan->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-zinc-400">{{ $keuangan->user?->name ?? 'Sistem' }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('keuangans.destroy', $keuangan) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-all" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                            <i class="fa-solid fa-money-bill-transfer text-3xl text-zinc-700 mb-2.5 block"></i>
                            <span>Belum ada transaksi mutasi kas keuangan.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= CREATE TRANSACTION MODAL ================= -->
<div id="create-transaction-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-transaction-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Catat Transaksi Kas</h3>
                <button onclick="toggleModal('create-transaction-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('keuangans.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Tipe Arus Kas</label>
                    <select name="type" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                        <option value="Pemasukan" selected>Pemasukan (Debit)</option>
                        <option value="Pengeluaran">Pengeluaran (Kredit)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Kategori Kas</label>
                    <input type="text" name="category" placeholder="Contoh: Dana Hibah, Kas Anggota, Konsumsi, ATK" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Jumlah Uang (Rp)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required placeholder="Contoh: 500000" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Transaksi</label>
                        <input type="date" name="date" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Rincian Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Tuliskan catatan tambahan mengenai transaksi ini..." class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-transaction-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Catat Mutasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
@endsection
