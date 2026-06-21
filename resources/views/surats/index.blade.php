@extends('layouts.dashboard')

@section('title', 'Manajemen Surat & Administrasi')
@section('page_title', 'Surat & Administrasi')

@section('content')
<div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl shadow-xl">
    <!-- Header Controls -->
    <div class="p-6 border-b border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Arsip Surat Organisasi</h3>
            <p class="text-xs text-zinc-500 mt-1">Total arsip: {{ $surats->count() }} dokumen terdaftar</p>
        </div>
        <button onclick="toggleModal('create-surat-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-file-arrow-up text-xs"></i>
            <span>Arsipkan Surat</span>
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase bg-zinc-950/20">
                    <th class="px-6 py-3.5">Nomor & Tanggal</th>
                    <th class="px-6 py-3.5">Perihal</th>
                    <th class="px-6 py-3.5">Pengirim / Penerima</th>
                    <th class="px-6 py-3.5 text-center">Tipe</th>
                    <th class="px-6 py-3.5 text-center">Dokumen</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-900">
                @forelse($surats as $surat)
                    <tr class="hover:bg-zinc-900/25 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-white text-sm">{{ $surat->nomor_surat }}</div>
                            <span class="text-xs text-zinc-500 mt-1 block"><i class="fa-regular fa-calendar-days mr-1"></i>{{ date('d M Y', strtotime($surat->tanggal)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-zinc-200 text-sm">{{ $surat->perihal }}</div>
                            <span class="text-xs text-zinc-500 mt-1 block truncate max-w-xs" title="{{ $surat->description }}">{{ $surat->description ?? 'Tidak ada catatan.' }}</span>
                        </td>
                        <td class="px-6 py-4 text-zinc-300 text-xs font-semibold">
                            @if($surat->type == 'Masuk')
                                <span class="text-[10px] text-zinc-500 block uppercase font-bold tracking-wider">Dari</span>
                            @else
                                <span class="text-[10px] text-zinc-500 block uppercase font-bold tracking-wider">Kepada</span>
                            @endif
                            <span class="text-sm text-zinc-200 font-medium mt-0.5 block">{{ $surat->pengirim_penerima }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $surat->type == 'Masuk' ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'bg-brand-500/10 text-brand-400 border border-brand-500/20' }}">
                                Surat {{ $surat->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($surat->file_path)
                                <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-brand-500 hover:text-brand-400 font-bold bg-brand-500/5 hover:bg-brand-500/10 px-2.5 py-1.5 rounded-lg border border-brand-500/15 transition-all">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span>Lihat File</span>
                                </a>
                            @else
                                <span class="text-zinc-600 text-xs italic">Tidak Ada File</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    onclick="openEditSuratModal(this)"
                                    data-id="{{ $surat->id }}"
                                    data-nomor="{{ $surat->nomor_surat }}"
                                    data-type="{{ $surat->type }}"
                                    data-perihal="{{ $surat->perihal }}"
                                    data-pihak="{{ $surat->pengirim_penerima }}"
                                    data-tanggal="{{ $surat->tanggal }}"
                                    data-desc="{{ $surat->description }}"
                                    class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-brand-500 hover:border-brand-500/30 transition-colors"
                                    title="Edit Surat"
                                >
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                
                                <form action="{{ route('surats.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-colors" title="Hapus Surat">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                            <i class="fa-solid fa-envelope-open-text text-3xl text-zinc-700 mb-2.5 block"></i>
                            <span>Belum ada surat terdaftar.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= CREATE SURAT MODAL ================= -->
<div id="create-surat-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-surat-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Arsipkan Surat Baru</h3>
                <button onclick="toggleModal('create-surat-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('surats.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nomor Surat -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Nomor Surat</label>
                        <input type="text" name="nomor_surat" required placeholder="Contoh: 001/ORG/VI/2026" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Tipe -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tipe Surat</label>
                        <select name="type" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Masuk" selected>Surat Masuk</option>
                            <option value="Keluar">Surat Keluar</option>
                        </select>
                    </div>
                    <!-- Perihal -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Perihal / Hal</label>
                        <input type="text" name="perihal" required placeholder="Contoh: Undangan Partisipasi Acara" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Pengirim / Penerima -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Pengirim / Penerima</label>
                        <input type="text" name="pengirim_penerima" required placeholder="Nama instansi/orang" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Surat</label>
                        <input type="date" name="tanggal" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Catatan Deskripsi -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Ringkas / Catatan</label>
                        <textarea name="description" rows="2" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                    </div>
                    <!-- File Upload -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Unggah Berkas / Dokumen (PDF, JPG, PNG)</label>
                        <input type="file" name="file" class="w-full bg-zinc-950 border border-zinc-800 text-zinc-400 text-sm rounded-xl px-4 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-500/10 file:text-brand-500 hover:file:bg-brand-500/20 transition-all outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-surat-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT SURAT MODAL ================= -->
<div id="edit-surat-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('edit-surat-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Edit Arsip Surat</h3>
                <button onclick="toggleModal('edit-surat-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form id="edit-surat-form" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nomor Surat -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Nomor Surat</label>
                        <input type="text" name="nomor_surat" id="edit-s-nomor" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Tipe -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tipe Surat</label>
                        <select name="type" id="edit-s-type" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Masuk">Surat Masuk</option>
                            <option value="Keluar">Surat Keluar</option>
                        </select>
                    </div>
                    <!-- Perihal -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Perihal / Hal</label>
                        <input type="text" name="perihal" id="edit-s-perihal" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Pengirim / Penerima -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Pengirim / Penerima</label>
                        <input type="text" name="pengirim_penerima" id="edit-s-pihak" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Surat</label>
                        <input type="date" name="tanggal" id="edit-s-tanggal" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Catatan Deskripsi -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Ringkas / Catatan</label>
                        <textarea name="description" id="edit-s-desc" rows="2" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                    </div>
                    <!-- File Upload -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Unggah Berkas Baru (Menggantikan berkas lama jika ada)</label>
                        <input type="file" name="file" class="w-full bg-zinc-950 border border-zinc-800 text-zinc-400 text-sm rounded-xl px-4 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-500/10 file:text-brand-500 hover:file:bg-brand-500/20 transition-all outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('edit-surat-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
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

    function openEditSuratModal(button) {
        const id = button.getAttribute('data-id');
        const nomor = button.getAttribute('data-nomor');
        const type = button.getAttribute('data-type');
        const perihal = button.getAttribute('data-perihal');
        const pihak = button.getAttribute('data-pihak');
        const tanggal = button.getAttribute('data-tanggal');
        const desc = button.getAttribute('data-desc');

        // Set action URL
        const form = document.getElementById('edit-surat-form');
        form.action = `/surats/${id}`;

        // Populate fields
        document.getElementById('edit-s-nomor').value = nomor;
        document.getElementById('edit-s-type').value = type;
        document.getElementById('edit-s-perihal').value = perihal;
        document.getElementById('edit-s-pihak').value = pihak;
        document.getElementById('edit-s-tanggal').value = tanggal;
        document.getElementById('edit-s-desc').value = desc || '';

        // Toggle modal
        toggleModal('edit-surat-modal');
    }
</script>
@endsection
