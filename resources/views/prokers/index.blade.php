@extends('layouts.dashboard')

@section('title', 'Manajemen Program Kerja')
@section('page_title', 'Program Kerja')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div>
            <h3 class="text-lg font-bold text-white">Program Kerja Organisasi</h3>
            <p class="text-xs text-zinc-500 mt-1">Daftar agenda kegiatan dan progres penyelesaian tugas program kerja.</p>
        </div>
        <button onclick="toggleModal('create-proker-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-folder-plus text-xs"></i>
            <span>Tambah Proker</span>
        </button>
    </div>

    <!-- Grid of Prokers -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($prokers as $proker)
            @php
                $percentage = $proker->tugas_count > 0 ? round(($proker->completed_tugas_count / $proker->tugas_count) * 100) : 0;
            @endphp
            <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-5 flex flex-col justify-between shadow-xl relative overflow-hidden group">
                <!-- Status Tag -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $proker->status == 'Rencana' ? 'bg-zinc-800 text-zinc-400 border border-zinc-700' : ($proker->status == 'Berjalan' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20') }}">
                        {{ $proker->status }}
                    </span>
                    <span class="text-xs font-bold text-white">Rp {{ number_format($proker->budget, 0, ',', '.') }}</span>
                </div>

                <!-- Info -->
                <div class="space-y-2 mb-6">
                    <h4 class="text-base font-extrabold text-white group-hover:text-brand-400 transition-colors">
                        <a href="{{ route('prokers.show', $proker->id) }}">{{ $proker->name }}</a>
                    </h4>
                    <p class="text-xs text-zinc-500 line-clamp-2 leading-relaxed">
                        {{ $proker->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                    <div class="flex items-center gap-2 text-[10px] text-zinc-500 pt-1 font-medium">
                        <i class="fa-regular fa-calendar text-brand-500"></i>
                        <span>
                            {{ $proker->start_date ? date('d M Y', strtotime($proker->start_date)) : 'TBA' }}
                            -
                            {{ $proker->end_date ? date('d M Y', strtotime($proker->end_date)) : 'TBA' }}
                        </span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="space-y-2 pt-4 border-t border-zinc-950">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-zinc-500">Progres Tugas</span>
                        <span class="text-zinc-200">{{ $proker->completed_tugas_count }}/{{ $proker->tugas_count }} ({{ $percentage }}%)</span>
                    </div>
                    <div class="w-full bg-zinc-950 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-brand-600 to-amber-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-2 mt-5 pt-3 border-t border-zinc-950">
                    <a href="{{ route('prokers.show', $proker->id) }}" class="text-xs text-brand-500 hover:text-brand-400 font-semibold px-3 py-1.5 bg-brand-500/5 hover:bg-brand-500/10 border border-brand-500/10 rounded-lg transition-all flex items-center gap-1.5 mr-auto">
                        <span>Detail Tugas</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    
                    <button
                        onclick="openEditProkerModal(this)"
                        data-id="{{ $proker->id }}"
                        data-name="{{ $proker->name }}"
                        data-desc="{{ $proker->description }}"
                        data-start="{{ $proker->start_date }}"
                        data-end="{{ $proker->end_date }}"
                        data-budget="{{ $proker->budget }}"
                        data-status="{{ $proker->status }}"
                        class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-brand-500 hover:border-brand-500/30 transition-colors"
                        title="Edit Proker"
                    >
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </button>
                    
                    <form action="{{ route('prokers.destroy', $proker->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Proker ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-colors" title="Hapus Proker">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-darkbg-900/60 border border-zinc-900 rounded-2xl p-16 text-center text-zinc-500 shadow-xl">
                <i class="fa-solid fa-clipboard-list text-4xl text-zinc-700 mb-3 block"></i>
                <span class="text-sm">Belum ada program kerja terdaftar.</span>
            </div>
        @endforelse
    </div>
</div>

<!-- ================= CREATE PROKER MODAL ================= -->
<div id="create-proker-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-proker-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Buat Program Kerja Baru</h3>
                <button onclick="toggleModal('create-proker-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('prokers.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Nama Proker -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Program Kerja</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Proker</label>
                    <textarea name="description" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- End Date -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Anggaran -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Rencana Anggaran (Rp)</label>
                        <input type="number" name="budget" required min="0" value="0" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Rencana" selected>Rencana</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
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

<!-- ================= EDIT PROKER MODAL ================= -->
<div id="edit-proker-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('edit-proker-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Edit Program Kerja</h3>
                <button onclick="toggleModal('edit-proker-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form id="edit-proker-form" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <!-- Nama Proker -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Program Kerja</label>
                    <input type="text" name="name" id="edit-p-name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Proker</label>
                    <textarea name="description" id="edit-p-desc" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="edit-p-start" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- End Date -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="edit-p-end" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Anggaran -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Rencana Anggaran (Rp)</label>
                        <input type="number" name="budget" id="edit-p-budget" required min="0" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" id="edit-p-status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Rencana">Rencana</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('edit-proker-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Simpan Perubahan</button>
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

    function openEditProkerModal(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const desc = button.getAttribute('data-desc');
        const start = button.getAttribute('data-start');
        const end = button.getAttribute('data-end');
        const budget = button.getAttribute('data-budget');
        const status = button.getAttribute('data-status');

        // Set action URL
        const form = document.getElementById('edit-proker-form');
        form.action = `/prokers/${id}`;

        // Populate fields
        document.getElementById('edit-p-name').value = name;
        document.getElementById('edit-p-desc').value = desc || '';
        document.getElementById('edit-p-start').value = start || '';
        document.getElementById('edit-p-end').value = end || '';
        document.getElementById('edit-p-budget').value = budget;
        document.getElementById('edit-p-status').value = status;

        // Toggle modal
        toggleModal('edit-proker-modal');
    }
</script>
@endsection
