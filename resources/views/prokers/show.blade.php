@extends('layouts.dashboard')

@section('title', 'Detail Program Kerja')
@section('page_title', 'Detail Program Kerja')

@section('content')
<div class="space-y-6">
    <!-- Back button & Title -->
    <div class="flex items-center justify-between">
        <a href="{{ route('prokers.index') }}" class="text-xs text-zinc-400 hover:text-brand-500 font-semibold flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Program Kerja</span>
        </a>
    </div>

    <!-- Proker Details Panel -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-32 h-32 rounded-full bg-brand-500/5 blur-2xl"></div>

        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
            <div class="space-y-3 max-w-xl">
                <div class="flex items-center gap-2.5">
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $proker->status == 'Rencana' ? 'bg-zinc-800 text-zinc-400' : ($proker->status == 'Berjalan' ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400') }}">
                        {{ $proker->status }}
                    </span>
                    <span class="text-xs text-zinc-500">Dibuat pada {{ date('d M Y', strtotime($proker->created_at)) }}</span>
                </div>
                <h2 class="text-2xl font-black text-white leading-tight">{{ $proker->name }}</h2>
                <p class="text-sm text-zinc-400 leading-relaxed">{{ $proker->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>

            <!-- Stats side -->
            <div class="grid grid-cols-2 gap-4 bg-zinc-950/40 p-4 border border-zinc-900 rounded-xl md:min-w-[280px]">
                <div>
                    <span class="text-[10px] text-zinc-500 uppercase font-bold tracking-wider block">Anggaran</span>
                    <span class="text-sm font-extrabold text-white">Rp {{ number_format($proker->budget, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-zinc-500 uppercase font-bold tracking-wider block">Total Tugas</span>
                    <span class="text-sm font-extrabold text-white">{{ $proker->tugas->count() }} Tugas</span>
                </div>
                <div class="col-span-2 pt-2 border-t border-zinc-900/60 flex items-center gap-1.5 text-[10px] text-zinc-400 font-medium">
                    <i class="fa-regular fa-calendar-range text-brand-500"></i>
                    <span>
                        {{ $proker->start_date ? date('d M Y', strtotime($proker->start_date)) : 'TBA' }}
                        s/d
                        {{ $proker->end_date ? date('d M Y', strtotime($proker->end_date)) : 'TBA' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TASKS SECTION -->
    <div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl shadow-xl">
        <!-- Header -->
        <div class="p-6 border-b border-zinc-900 flex items-center justify-between">
            <div>
                <h3 class="text-md font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-brand-500"></i>
                    <span>Daftar Tugas Program Kerja</span>
                </h3>
            </div>
            <button onclick="toggleModal('create-task-modal')" class="bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-300 hover:text-white font-semibold px-3 py-1.5 rounded-xl transition-all flex items-center gap-1.5 text-xs">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Tambah Tugas</span>
            </button>
        </div>

        <!-- Task Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase bg-zinc-950/20">
                        <th class="px-6 py-3.5">Tugas</th>
                        <th class="px-6 py-3.5">Tenggat Waktu</th>
                        <th class="px-6 py-3.5">Penanggung Jawab</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Ubah Status / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-900">
                    @forelse($proker->tugas as $task)
                        <tr class="hover:bg-zinc-900/10 transition-colors">
                            <td class="px-6 py-4">
                                <h4 class="font-semibold text-zinc-200 text-sm">{{ $task->title }}</h4>
                                <p class="text-xs text-zinc-500 mt-1 max-w-xs truncate" title="{{ $task->description }}">{{ $task->description ?? 'Tidak ada catatan.' }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-zinc-400">
                                @if($task->due_date)
                                    <i class="fa-regular fa-clock mr-1 text-zinc-500"></i>
                                    <span>{{ date('d M Y', strtotime($task->due_date)) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($task->assignee)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-brand-500/10 flex items-center justify-center font-bold text-brand-500 text-[10px]">
                                            {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                        </div>
                                        <span class="text-zinc-300 font-medium text-xs">{{ $task->assignee->name }}</span>
                                    </div>
                                @else
                                    <span class="text-zinc-600 text-xs italic">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $task->status == 'Completed' ? 'bg-emerald-500/10 text-emerald-400' : ($task->status == 'Ongoing' ? 'bg-amber-500/10 text-amber-400' : 'bg-red-500/10 text-red-400') }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    <!-- Status toggles -->
                                    <form action="{{ route('tasks.status.update', $task->id) }}" method="POST" class="flex gap-1 bg-zinc-950 p-1 border border-zinc-900 rounded-lg">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="status" value="Pending" class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-bold {{ $task->status == 'Pending' ? 'bg-red-500/10 text-red-400' : 'text-zinc-600 hover:text-zinc-400' }}" title="Set Pending">P</button>
                                        <button type="submit" name="status" value="Ongoing" class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-bold {{ $task->status == 'Ongoing' ? 'bg-amber-500/10 text-amber-400' : 'text-zinc-600 hover:text-zinc-400' }}" title="Set Ongoing">O</button>
                                        <button type="submit" name="status" value="Completed" class="w-6 h-6 rounded flex items-center justify-center text-[10px] font-bold {{ $task->status == 'Completed' ? 'bg-emerald-500/10 text-emerald-400' : 'text-zinc-600 hover:text-zinc-400' }}" title="Set Completed">C</button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-red-400 hover:border-red-500/30 transition-all" title="Hapus Tugas">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-600">
                                <i class="fa-solid fa-list-check text-2xl text-zinc-800 mb-2 block"></i>
                                <span>Belum ada tugas dibuat untuk program kerja ini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= CREATE TASK MODAL ================= -->
<div id="create-task-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-task-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Tambah Tugas Baru</h3>
                <button onclick="toggleModal('create-task-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('prokers.tasks.store', $proker->id) }}" method="POST" class="space-y-4">
                @csrf
                <!-- Judul Tugas -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Judul Tugas</label>
                    <input type="text" name="title" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                </div>
                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Instruksi / Catatan</label>
                    <textarea name="description" rows="2" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all"></textarea>
                </div>
                <!-- Penanggung Jawab -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-400 mb-2">Penanggung Jawab</label>
                    <select name="assigned_to" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->role_organisasi }})</option>
                        @endforeach
                    </select>
                </div>
                <!-- Due date & Status -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Tenggat Waktu</label>
                        <input type="date" name="due_date" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status Awal</label>
                        <select name="status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Pending" selected>Pending</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-task-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Tambah</button>
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
