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
                <tr class="hover:bg-zinc-900/10 transition-colors">
                    <td class="px-6 py-4">
                        <h4 class="font-semibold text-zinc-200 text-sm">{{ $surat->nomor_surat }}</h4>
                        <span class="text-xs text-zinc-500">{{ date('d M Y', strtotime($surat->tanggal)) }}</span>
                    </td>
                    <td class="px-6 py-4 text-xs text-zinc-300 max-w-[200px] truncate">{{ $surat->perihal }}</td>
                    <td class="px-6 py-4 text-xs text-zinc-400">{{ $surat->pengirim_penerima }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $surat->type == 'Masuk' ? 'bg-blue-500/10 text-blue-400' : 'bg-purple-500/10 text-purple-400' }}">
                            {{ $surat->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($surat->file_path)
                        <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" class="text-brand-500 hover:text-brand-400 text-xs font-semibold flex items-center justify-center gap-1">
                            <i class="fa-solid fa-file-lines"></i> Lihat
                        </a>
                        @else
                        <span class="text-zinc-600 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('surats.destroy', $surat) }}" method="POST" onsubmit="return confirm('Hapus surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-all" title="Hapus">
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
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Nomor Surat</label>
                        <input type="text" name="nomor_surat" required placeholder="Contoh: 001/ORG/VI/2026" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tipe Surat</label>
                        <select name="type" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Masuk" selected>Surat Masuk</option>
                            <option value="Keluar">Surat Keluar</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Perihal / Hal</label>
                        <input type="text" name="perihal" required placeholder="Contoh: Undangan Partisipasi Acara" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Pengirim / Penerima</label>
                        <input type="text" name="pengirim_penerima" required placeholder="Nama instansi/orang" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Surat</label>
                        <input type="date" name="tanggal" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Ringkas / Catatan</label>
                        <textarea name="description" rows="2" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                    </div>
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

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
@endsection
