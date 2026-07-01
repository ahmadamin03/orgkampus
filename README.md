<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php" alt="PHP 8.3">
    <img src="https://img.shields.io/badge/Laravel-13.8-FF2D20?logo=laravel" alt="Laravel 13">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-06B6D4?logo=tailwindcss" alt="Tailwind CSS 4">
    <img src="https://img.shields.io/badge/Sanctum-API-FF2D20" alt="Sanctum API">
    <img src="https://img.shields.io/badge/30_tests-passing-22c55e" alt="Tests: 30 passing">
    <a href="https://orgkampus.up.railway.app"><img src="https://img.shields.io/badge/Live-Demo-orange?style=flat&logo=railway" alt="Live Demo"></a>
</p>

<h1 align="center">OrgKampus</h1>
@@ -15,156 +16,6 @@

---

## Fitur

### 1. Dasbor
- Ringkasan statistik: total anggota, proker, event, surat, saldo kas
- Tugas aktif terbaru + histori transaksi dan surat terbaru

### 2. Database Anggota
- CRUD anggota organisasi (nama, email, NIM, kontak, jabatan, departemen, status)
- Login terintegrasi — setiap anggota punya akun sendiri
- API endpoint untuk integrasi eksternal

### 3. Program Kerja & Tugas
- Buat rencana program kerja dengan anggaran dan tenggat waktu
- Delegasi tugas ke anggota dengan status (Pending / Ongoing / Completed)
- Pantau progres real-time

### 4. Manajemen Keuangan Kas
- Catat pemasukan dan pengeluaran kas organisasi
- Ringkasan total pemasukan, pengeluaran, dan saldo

### 5. Surat & Administrasi
- Arsip surat masuk/keluar dengan unggah file lampiran
- Nomor surat otomatis terkelola

### 6. Event & Kepanitiaan
- Kelola acara organisasi beserta susunan kepanitiaan
- Pantau jadwal dan status acara

### 7. REST API
- Autentikasi token berbasis Sanctum
- CRUD lengkap untuk semua entitas
- Dokumentasi OpenAPI 3.0 interaktif di `/api/documentation`

---

## Tech Stack

| Lapisan | Teknologi |
|---------|-----------|
| Backend | PHP 8.3, Laravel 13.8 |
| Frontend | Blade, Tailwind CSS 4 (CDN), Font Awesome 6, Plus Jakarta Sans |
| API Auth | Laravel Sanctum |
| Database | MySQL / MariaDB (via migration) |
| Testing | PHPUnit 12 — 30 test cases (152 assertions) |
| Dev Tools | Laravel Tinker, Pail, Pao, Pint, Vite |

---

## Arsitektur

### Multi-Tenant
Setiap organisasi memiliki data terisolasi. Semua tabel memiliki kolom `organization_id` dengan global scope otomatis (`TenantScoped` trait). Pendaftaran langsung membuat organisasi baru + akun ketua organisasi.

### Service Layer
- **7 service interfaces** di `app/Contracts/Services/`
- **7 implementasi** di `app/Services/`
- Controller bergantung pada interface (dependency injection)

### API
- Base path: `/api`
- Autentikasi: Bearer token (Sanctum)
- Resource endpoints: members, prokers, events, surats, keuangans, tugas
- Format respons: JSON terstruktur dengan pagination
- Dokumentasi: `storage/api-docs/api-contract.yaml` (OpenAPI 3.0.3)
**🌐 Aplikasi Live:** [https://orgkampus.up.railway.app](https://orgkampus.up.railway.app)

---

## Instalasi

### Prasyarat
- PHP ^8.3
- Composer
- MySQL / MariaDB
- Node.js & npm (untuk Vite build production)

### Langkah

```bash
# Clone repositori
git clone https://github.com/ahmadamin03/orgkampus.git
cd orgkampus

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env, lalu:
php artisan migrate

# Build aset (dev)
npm run dev

# Jalankan server
php artisan serve
```

### Setup Cepat (jika ada `composer.json` script)
```bash
composer setup
```

---

## Testing

```bash
php artisan test

# 30 passing (152 assertions)
# - 17 web feature tests (OrgKampusTest)
# - 13 API feature tests (ApiTest)
# - Multi-tenant isolation teruji di kedua suite
```

---

## API Documentation

Dokumentasi API lengkap tersedia secara interaktif:

```
GET /api/documentation
```

Atau buka `storage/api-docs/api-contract.yaml` untuk spesimen OpenAPI mentah.

---

## Hak Akses

| Role | Deskripsi |
|------|-----------|
| Ketua Organisasi | Akses penuh ke semua fitur |
| Sekretaris | Manajemen surat dan administrasi |
| Bendahara | Manajemen keuangan dan kas |
| Kepala Divisi | Manajemen proker dan tugas divisi |
| Anggota | Akses terbatas sesuai tugas |

---

## Lisensi

MIT License — lihat file `LICENSE` untuk detail.

---

<p align="center">
    Dibuat dengan ❤️ oleh Tim OrgKampus
</p>
