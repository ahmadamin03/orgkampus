@extends('layouts.dashboard')

@section('title', 'Manajemen Event & Kepanitiaan')
@section('page_title', 'Event & Kepanitiaan')

@section('content')
<div class="space-y-6">
    <!-- Header Controls -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div>
            <h3 class="text-lg font-bold text-white">Event & Kegiatan Organisasi</h3>
            <p class="text-xs text-zinc-500 mt-1">Kelola kepanitiaan dan daftar kegiatan eksternal maupun internal organisasi.</p>
        </div>
        <button onclick="toggleModal('create-event-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-calendar-plus text-xs"></i>
            <span>Tambah Event</span>
        </button>
    </div>

    <!-- Event Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($events as $event)
        <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $event->status == 'Rencana' ? 'bg-zinc-800 text-zinc-400' : ($event->status == 'Berjalan' ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400') }}">
                    {{ $event->status }}
                </span>
                <span class="text-xs text-zinc-500">{{ $event->kepanitiaans->count() }} panitia</span>
            </div>
            <h4 class="text-white font-bold text-base">{{ $event->name }}</h4>
            <p class="text-xs text-zinc-400 mt-2">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-zinc-500">
                @if($event->date)
                <span><i class="fa-regular fa-calendar mr-1"></i>{{ date('d M Y', strtotime($event->date)) }}</span>
                @endif
                @if($event->location)
                <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</span>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-zinc-900 flex items-center justify-end gap-2">
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Hapus event ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-all" title="Hapus">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-darkbg-900/60 border border-zinc-900 rounded-2xl p-16 text-center text-zinc-500 shadow-xl">
            <i class="fa-solid fa-calendar-xmark text-4xl text-zinc-700 mb-3 block"></i>
            <span class="text-sm">Belum ada event terdaftar.</span>
        </div>
        @endforelse
    </div>
</div>

<!-- ================= CREATE EVENT MODAL ================= -->
<div id="create-event-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-event-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Tambah Event Baru</h3>
                <button onclick="toggleModal('create-event-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('events.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Event</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Kegiatan</label>
                    <textarea name="description" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" name="date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Rencana" selected>Rencana</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tempat / Lokasi</label>
                        <input type="text" name="location" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-event-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
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
