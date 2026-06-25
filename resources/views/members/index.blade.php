@extends('layouts.dashboard')

@section('title', 'Manajemen Anggota')
@section('page_title', 'Manajemen Anggota')

@section('content')
<div class="bg-darkbg-900/60 backdrop-blur-md border border-zinc-900 rounded-2xl shadow-xl">
    <!-- Header Controls -->
    <div class="p-6 border-b border-zinc-900 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-white">Daftar Anggota Organisasi</h3>
            <p class="text-xs text-zinc-500 mt-1">Total terdaftar: {{ $members->count() }} orang anggota</p>
        </div>
        <button onclick="toggleModal('create-modal')" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Tambah Anggota</span>
        </button>
    </div>

    <!-- Table content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-zinc-500 text-xs border-b border-zinc-900 font-semibold uppercase bg-zinc-950/20">
                    <th class="px-6 py-3.5">NIM & Nama</th>
                    <th class="px-6 py-3.5">Kontak</th>
                    <th class="px-6 py-3.5">Jabatan</th>
                    <th class="px-6 py-3.5">Departemen</th>
                    <th class="px-6 py-3.5 text-center">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-900">
                @forelse($members as $member)
                <tr class="hover:bg-zinc-900/10 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-500/10 flex items-center justify-center font-bold text-brand-500 text-xs">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-zinc-200 text-sm">{{ $member->name }}</h4>
                                <span class="text-xs text-zinc-500">{{ $member->nim ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs text-zinc-400">
                        <div>{{ $member->email }}</div>
                        <div class="text-zinc-500">{{ $member->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-xs font-semibold text-zinc-300">{{ $member->role_organisasi }}</td>
                    <td class="px-6 py-4 text-xs text-zinc-400">{{ $member->departemen ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-[10px] px-2.5 py-0.5 rounded-full font-semibold {{ $member->status == 'Aktif' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-zinc-800 text-zinc-500' }}">
                            {{ $member->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editMember({{ $member->id }})" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-400 hover:text-brand-500 hover:border-brand-500/30 transition-all" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota {{ $member->name }}?')">
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
                        <i class="fa-solid fa-users-slash text-3xl text-zinc-700 mb-2.5 block"></i>
                        <span>Belum ada anggota terdaftar.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= CREATE MODAL ================= -->
<div id="create-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('create-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Tambah Anggota Baru</h3>
                <button onclick="toggleModal('create-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">NIM</label>
                        <input type="text" name="nim" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">No. HP / WA</label>
                        <input type="text" name="phone" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Jabatan Organisasi</label>
                        <select name="role_organisasi" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Ketua Organisasi">Ketua Organisasi</option>
                            <option value="Sekretaris">Sekretaris</option>
                            <option value="Bendahara">Bendahara</option>
                            <option value="Kepala Divisi">Kepala Divisi</option>
                            <option value="Anggota" selected>Anggota</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Departemen / Divisi</label>
                        <select name="departemen" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="">BPH / Non-Divisi</option>
                            <option value="Humas & Kemitraan">Humas & Kemitraan</option>
                            <option value="Pengembangan Sumber Daya (PSDM)">PSDM</option>
                            <option value="Riset & Teknologi (R&D)">Riset & Teknologi (R&D)</option>
                            <option value="Minat & Bakat">Minat & Bakat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Password Login</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('create-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-brand-500/10 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div id="edit-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="toggleModal('edit-modal')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-darkbg-900 border border-zinc-800 rounded-2xl shadow-2xl p-6 sm:p-8 animate-fade-in-up">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4 mb-6">
                <h3 class="text-lg font-bold text-white">Edit Anggota</h3>
                <button onclick="toggleModal('edit-modal')" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form id="edit-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Email</label>
                        <input type="email" name="email" id="edit-email" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">NIM</label>
                        <input type="text" name="nim" id="edit-nim" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">No. HP / WA</label>
                        <input type="text" name="phone" id="edit-phone" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Jabatan Organisasi</label>
                        <select name="role_organisasi" id="edit-role" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Ketua Organisasi">Ketua Organisasi</option>
                            <option value="Sekretaris">Sekretaris</option>
                            <option value="Bendahara">Bendahara</option>
                            <option value="Kepala Divisi">Kepala Divisi</option>
                            <option value="Anggota">Anggota</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Departemen / Divisi</label>
                        <select name="departemen" id="edit-departemen" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="">BPH / Non-Divisi</option>
                            <option value="Humas & Kemitraan">Humas & Kemitraan</option>
                            <option value="Pengembangan Sumber Daya (PSDM)">PSDM</option>
                            <option value="Riset & Teknologi (R&D)">Riset & Teknologi (R&D)</option>
                            <option value="Minat & Bakat">Minat & Bakat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Status</label>
                        <select name="status" id="edit-status" required class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-400 mb-2">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="edit-password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-zinc-950 border border-zinc-800 text-white text-sm rounded-xl px-4 py-2.5 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800 mt-6">
                    <button type="button" onclick="toggleModal('edit-modal')" class="bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">Batal</button>
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

    function editMember(id) {
        fetch('/members/' + id)
            .then(r => r.json())
            .then(data => {
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-nim').value = data.nim || '';
                document.getElementById('edit-phone').value = data.phone || '';
                document.getElementById('edit-role').value = data.role_organisasi;
                document.getElementById('edit-departemen').value = data.departemen || '';
                document.getElementById('edit-status').value = data.status;
                document.getElementById('edit-form').action = '/members/' + id;
                toggleModal('edit-modal');
            });
    }
</script>
@endsection
