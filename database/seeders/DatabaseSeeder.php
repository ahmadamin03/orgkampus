<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Proker;
use App\Models\Tugas;
use App\Models\Event;
use App\Models\Kepanitiaan;
use App\Models\Surat;
use App\Models\Keuangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (BPH & Anggota)
        $admin = User::updateOrCreate(
            ['email' => 'admin@orgkampus.ac.id'],
            [
                'name' => 'Administrator',
                'nim' => '24010120140001',
                'phone' => '081234567890',
                'role_organisasi' => 'Ketua Organisasi',
                'departemen' => 'Badan Pengurus Harian (BPH)',
                'status' => 'Aktif',
                'password' => Hash::make('admin123')
            ]
        );

        $sekretaris = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@orgkampus.ac.id',
            'nim' => '24010120140002',
            'phone' => '081234567891',
            'role_organisasi' => 'Sekretaris',
            'departemen' => 'Badan Pengurus Harian (BPH)',
            'status' => 'Aktif',
            'password' => Hash::make('password')
        ]);

        $bendahara = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@orgkampus.ac.id',
            'nim' => '24010120140003',
            'phone' => '081234567892',
            'role_organisasi' => 'Bendahara',
            'departemen' => 'Badan Pengurus Harian (BPH)',
            'status' => 'Aktif',
            'password' => Hash::make('password')
        ]);

        $kadiv_humas = User::create([
            'name' => 'Rian Hidayat',
            'email' => 'rian@orgkampus.ac.id',
            'nim' => '24010120140004',
            'phone' => '081234567893',
            'role_organisasi' => 'Kepala Divisi',
            'departemen' => 'Humas & Kemitraan',
            'status' => 'Aktif',
            'password' => Hash::make('password')
        ]);

        $anggota_humas = User::create([
            'name' => 'Amalia Lestari',
            'email' => 'amalia@orgkampus.ac.id',
            'nim' => '24010120140005',
            'phone' => '081234567894',
            'role_organisasi' => 'Anggota',
            'departemen' => 'Humas & Kemitraan',
            'status' => 'Aktif',
            'password' => Hash::make('password')
        ]);

        // 2. Seed Proker & Tugas
        $proker1 = Proker::create([
            'name' => 'Latihan Kepemimpinan Mahasiswa (LKM)',
            'description' => 'Pelatihan kepemimpinan dan manajemen organisasi untuk anggota baru.',
            'start_date' => '2026-07-10',
            'end_date' => '2026-07-12',
            'budget' => 5000000.00,
            'status' => 'Rencana'
        ]);

        Tugas::create([
            'proker_id' => $proker1->id,
            'title' => 'Penyusunan Proposal LKM',
            'description' => 'Membuat draf proposal kegiatan dan rincian anggaran awal.',
            'assigned_to' => $sekretaris->id,
            'due_date' => '2026-06-30',
            'status' => 'Ongoing'
        ]);

        Tugas::create([
            'proker_id' => $proker1->id,
            'title' => 'Pemesanan Tempat & Konsumsi',
            'description' => 'Mencari villa/tempat pelatihan dan memesan katering makanan.',
            'assigned_to' => $anggota_humas->id,
            'due_date' => '2026-07-05',
            'status' => 'Pending'
        ]);

        $proker2 = Proker::create([
            'name' => 'Seminar IT & AI',
            'description' => 'Seminar nasional tentang kecerdasan buatan dalam dunia akademik.',
            'start_date' => '2026-05-15',
            'end_date' => '2026-05-15',
            'budget' => 8500000.00,
            'status' => 'Selesai'
        ]);

        Tugas::create([
            'proker_id' => $proker2->id,
            'title' => 'Menghubungi Pembicara Utama',
            'description' => 'Mengirim undangan pembicara kepada pakar AI nasional.',
            'assigned_to' => $kadiv_humas->id,
            'due_date' => '2026-04-20',
            'status' => 'Completed'
        ]);

        Tugas::create([
            'proker_id' => $proker2->id,
            'title' => 'Promosi & Pendaftaran Peserta',
            'description' => 'Membuat pamflet digital dan menyebarkan form pendaftaran.',
            'assigned_to' => $anggota_humas->id,
            'due_date' => '2026-05-10',
            'status' => 'Completed'
        ]);

        // 3. Seed Event & Kepanitiaan
        $event1 = Event::create([
            'name' => 'Dies Natalis Organisasi Ke-10',
            'description' => 'Ulang tahun organisasi dengan acara syukuran dan temu alumni.',
            'date' => '2026-08-20',
            'location' => 'Gedung Serbaguna Kampus',
            'status' => 'Rencana'
        ]);

        Kepanitiaan::create([
            'event_id' => $event1->id,
            'user_id' => $kadiv_humas->id,
            'role' => 'Ketua Panitia'
        ]);

        Kepanitiaan::create([
            'event_id' => $event1->id,
            'user_id' => $anggota_humas->id,
            'role' => 'Divisi Acara'
        ]);

        Kepanitiaan::create([
            'event_id' => $event1->id,
            'user_id' => $bendahara->id,
            'role' => 'Bendahara Panitia'
        ]);

        // 4. Seed Surat & Administrasi
        Surat::create([
            'nomor_surat' => '024/ORG/SM/VI/2026',
            'type' => 'Masuk',
            'perihal' => 'Undangan Rapat Koordinasi Ormawa',
            'pengirim_penerima' => 'Badan Eksekutif Mahasiswa (BEM)',
            'tanggal' => '2026-06-18',
            'description' => 'Undangan rapat penyusunan kalender kegiatan bersama di rektorat.'
        ]);

        Surat::create([
            'nomor_surat' => '045/ORG/SK/VI/2026',
            'type' => 'Keluar',
            'perihal' => 'Permohonan Dana Kegiatan LKM',
            'pengirim_penerima' => 'Bagian Kemahasiswaan Rektorat',
            'tanggal' => '2026-06-20',
            'description' => 'Surat pengantar proposal permohonan dana bantuan kegiatan LKM.'
        ]);

        // 5. Seed Keuangan Kas
        Keuangan::create([
            'type' => 'Pemasukan',
            'category' => 'Dana Hibah Kampus',
            'amount' => 10000000.00,
            'date' => '2026-06-01',
            'description' => 'Pencairan dana kemahasiswaan termin 1.',
            'user_id' => $bendahara->id
        ]);

        Keuangan::create([
            'type' => 'Pemasukan',
            'category' => 'Uang Kas Anggota',
            'amount' => 500000.00,
            'date' => '2026-06-10',
            'description' => 'Iuran kas rutin bulan Juni dari 25 anggota.',
            'user_id' => $bendahara->id
        ]);

        Keuangan::create([
            'type' => 'Pengeluaran',
            'category' => 'Pembelian ATK',
            'amount' => 250000.00,
            'date' => '2026-06-12',
            'description' => 'Buku kas, bolpoin, kertas HVS, dan stempel baru.',
            'user_id' => $bendahara->id
        ]);

        Keuangan::create([
            'type' => 'Pengeluaran',
            'category' => 'Konsumsi Rapat Pleno',
            'amount' => 450000.00,
            'date' => '2026-06-15',
            'description' => 'Nasi kotak untuk rapat koordinasi program kerja.',
            'user_id' => $bendahara->id
        ]);
    }
}
