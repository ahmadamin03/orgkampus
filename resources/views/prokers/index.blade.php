@extends('layouts.dashboard')

@section('title', 'Manajemen Program Kerja')
@section('page_title', 'Program Kerja (Proker)')

@section('content')
<div class="space-y-6">
    <!-- Header Controls -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div>
            <h3 class="text-lg font-bold text-white">Daftar Program Kerja</h3>
            <p class="text-xs text-zinc-500 mt-1">Kelola dan pantau seluruh rencana kegiatan organisasi.</p>
        </div>
        <button onclick="toggleModal('create-proker-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-folder-plus text-xs"></i>
            <span>Tambah Proker</span>
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($prokers as $proker)
        <a href="{{ route('prokers.show', $proker) }}" class="block bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl hover:border-brand-500/30 transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $proker->status == 'Rencana' ? 'bg-zinc-800 text-zinc-400' : ($proker->status == 'Berjalan' ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400') }}">
                    {{ $proker->status }}
                </span>
                <span class="text-xs text-zinc-500">{{ $proker->tugas->count() }} tugas</span>
            </div>
            <h4 class="text-white font-bold text-base group-hover:text-brand-500 transition-colors">{{ $proker->name }}</h4>
            <p class="text-xs text-zinc-400 mt-2 line-clamp-2">{{ $proker->description ?? 'Tidak ada deskripsi.' }}</p>
            <div class="mt-4 pt-4 border-t border-zinc-900 flex items-center justify-between text-xs text-zinc-500">
                <span>Rp {{ number_format($proker->budget, 0, ',', '.') }}</span>
                <span class="flex items-center gap-1 text-zinc-400 group-hover:text-brand-500 transition-colors">
                    Detail <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full bg-darkbg-900/60 border border-zinc-900 rounded-2xl p-16 text-center text-zinc-500 shadow-xl">
            <i class="fa-solid fa-clipboard-question text-4xl text-zinc-700 mb-3 block"></i>
            <span class="text-sm">Belum ada program kerja terdaftar.</span>
        </div>
        @endforelse
    </div>

    @if ($prokers->hasPages())
    <div class="flex items-center justify-between pt-4">
        <div class="text-xs text-zinc-500">
            Halaman {{ $prokers->currentPage() }} dari {{ $prokers->lastPage() }}
        </div>
        <div class="flex gap-2">
            @if ($prokers->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-600 text-xs font-medium">Sebelumnya</span>
            @else
                <a href="{{ $prokers->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-400 hover:text-white hover:border-zinc-700 text-xs font-medium transition-colors">Sebelumnya</a>
            @endif
            @if ($prokers->hasMorePages())
                <a href="{{ $prokers->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-400 hover:text-white hover:border-zinc-700 text-xs font-medium transition-colors">Selanjutnya</a>
            @else
                <span class="px-3 py-1.5 rounded-lg bg-zinc-950 border border-zinc-800 text-zinc-600 text-xs font-medium">Selanjutnya</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- ================= CREATE PROKER MODAL ================= -->
<div id="create-proker-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-proker-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Tambah Proker Baru</h3>
                <button onclick="toggleModal('create-proker-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('prokers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Program Kerja</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Ringkas</label>
                    <textarea name="description" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Rencana" selected>Rencana</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Anggaran (Rp)</label>
                        <input type="number" name="budget" min="0" step="0.01" value="0" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tenggat Waktu</label>
                        <input type="date" name="end_date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-proker-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Simpan</button>
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
