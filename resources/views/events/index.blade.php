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

    <!-- Event Accordions/Cards -->
    <div class="space-y-6">
        @forelse($events as $event)
            <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl overflow-hidden shadow-xl">
                <!-- Event Header Info Panel -->
                <div class="p-6 border-b border-zinc-950 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-zinc-950/20">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $event->status == 'Rencana' ? 'bg-zinc-800 text-zinc-400' : ($event->status == 'Berjalan' ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400') }}">
                                {{ $event->status }}
                            </span>
                            <span class="text-xs text-zinc-500 flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-brand-500"></i>
                                <span>{{ $event->date ? date('d M Y', strtotime($event->date)) : 'TBA' }}</span>
                            </span>
                            <span class="text-xs text-zinc-500 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-brand-500"></i>
                                <span>{{ $event->location ?? 'TBA' }}</span>
                            </span>
                        </div>
                        <h3 class="text-lg font-extrabold text-white">{{ $event->name }}</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed max-w-2xl">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <button
                            onclick="openEditEventModal(this)"
                            data-id="{{ $event->id }}"
                            data-name="{{ $event->name }}"
                            data-desc="{{ $event->description }}"
                            data-date="{{ $event->date }}"
                            data-loc="{{ $event->location }}"
                            data-status="{{ $event->status }}"
                            class="px-3 py-1.5 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-brand-500 hover:border-brand-500/30 text-xs font-semibold transition-colors flex items-center gap-1.5"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Edit Event</span>
                        </button>
                        
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event beserta seluruh panitia di dalamnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-colors" title="Hapus Event">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Committee Subsection -->
                <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Inline add panitia form -->
                    <div class="bg-zinc-950/30 p-4 border border-zinc-900 rounded-xl space-y-3 lg:col-span-1">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3"><i class="fa-solid fa-user-plus text-brand-500 mr-1.5"></i>Tambah Anggota Panitia</h4>
                        
                        <form action="{{ route('events.committees.store', $event->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-semibold text-zinc-500 mb-1.5">Nama Anggota</label>
                                <select name="user_id" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-xs rounded-lg px-3 py-2 outline-none focus:border-brand-500 transition-colors">
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-zinc-500 mb-1.5">Penugasan / Jabatan Panitia</label>
                                <input type="text" name="role" placeholder="Contoh: Ketua Panitia, Sie Acara" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-xs rounded-lg px-3 py-2 outline-none focus:border-brand-500 transition-colors">
                            </div>
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold py-2 rounded-lg transition-colors flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-plus"></i>
                                <span>Tambahkan Panitia</span>
                            </button>
                        </form>
                    </div>

                    <!-- Right: Panitia list table -->
                    <div class="lg:col-span-2 space-y-2">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3 flex items-center justify-between">
                            <span><i class="fa-solid fa-users-gear text-brand-500 mr-1.5"></i>Susunan Kepanitiaan</span>
                            <span class="text-zinc-500 font-semibold lowercase text-[11px] font-normal">{{ $event->kepanitiaans->count() }} panitia aktif</span>
                        </h4>

                        <div class="overflow-x-auto border border-zinc-900 rounded-xl">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-zinc-500 font-semibold uppercase bg-zinc-950/40 border-b border-zinc-900">
                                        <th class="px-4 py-2.5">Panitia</th>
                                        <th class="px-4 py-2.5">Jabatan Kepanitiaan</th>
                                        <th class="px-4 py-2.5 text-right">Keluarkan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-900 bg-black/10">
                                    @forelse($event->kepanitiaans as $kp)
                                        <tr>
                                            <td class="px-4 py-2.5 font-medium text-white flex items-center gap-2">
                                                <div class="w-5 h-5 rounded-full bg-brand-500/10 flex items-center justify-center font-bold text-brand-500 text-[9px]">
                                                    {{ strtoupper(substr($kp->user->name, 0, 2)) }}
                                                </div>
                                                <span>{{ $kp->user->name }}</span>
                                            </td>
                                            <td class="px-4 py-2.5 text-zinc-300">
                                                <span class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-zinc-300">
                                                    {{ $kp->role }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2.5 text-right">
                                                <form action="{{ route('committees.destroy', $kp->id) }}" method="POST" onsubmit="return confirm('Keluarkan panitia ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-zinc-500 hover:text-red-400 transition-colors" title="Keluarkan Panitia">
                                                        <i class="fa-solid fa-user-minus"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-zinc-600">Belum ada panitia terdaftar untuk event ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-darkbg-900/60 border border-zinc-900 rounded-2xl p-16 text-center text-zinc-500 shadow-xl">
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
                <!-- Nama Event -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Event</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Kegiatan</label>
                    <textarea name="description" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Date -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" name="date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
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
                    <!-- Lokasi -->
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

<!-- ================= EDIT EVENT MODAL ================= -->
<div id="edit-event-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('edit-event-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Edit Event</h3>
                <button onclick="toggleModal('edit-event-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form id="edit-event-form" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <!-- Nama Event -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Event</label>
                    <input type="text" name="name" id="edit-e-name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Deskripsi Kegiatan</label>
                    <textarea name="description" id="edit-e-desc" rows="3" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Date -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" name="date" id="edit-e-date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" id="edit-e-status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Rencana">Rencana</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <!-- Lokasi -->
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tempat / Lokasi</label>
                        <input type="text" name="location" id="edit-e-loc" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('edit-event-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
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

    function openEditEventModal(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const desc = button.getAttribute('data-desc');
        const date = button.getAttribute('data-date');
        const loc = button.getAttribute('data-loc');
        const status = button.getAttribute('data-status');

        // Set action URL
        const form = document.getElementById('edit-event-form');
        form.action = `/events/${id}`;

        // Populate fields
        document.getElementById('edit-e-name').value = name;
        document.getElementById('edit-e-desc').value = desc || '';
        document.getElementById('edit-e-date').value = date || '';
        document.getElementById('edit-e-loc').value = loc || '';
        document.getElementById('edit-e-status').value = status;

        // Toggle modal
        toggleModal('edit-event-modal');
    }
</script>
@endsection
