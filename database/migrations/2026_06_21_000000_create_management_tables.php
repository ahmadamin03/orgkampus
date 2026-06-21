<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Program Kerja
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->string('status')->default('Rencana'); // Rencana, Berjalan, Selesai
            $table->timestamps();
        });

        // 2. Tugas Proker
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proker_id')->constrained('prokers')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->date('due_date')->nullable();
            $table->string('status')->default('Pending'); // Pending, Ongoing, Completed
            $table->timestamps();
        });

        // 3. Event Kegiatan
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Rencana'); // Rencana, Berjalan, Selesai
            $table->timestamps();
        });

        // 4. Kepanitiaan Event
        Schema::create('kepanitiaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role'); // Ketua Panitia, Sekretaris, Bendahara, Sie Acara, Sie Perlengkapan, dll.
            $table->timestamps();
        });

        // 5. Surat & Administrasi
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('type'); // Masuk, Keluar
            $table->string('perihal');
            $table->string('pengirim_penerima'); // Pengirim (untuk Surat Masuk), Penerima (untuk Surat Keluar)
            $table->date('tanggal');
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 6. Keuangan Kas
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Pemasukan, Pengeluaran
            $table->string('category'); // Kas Anggota, Dana Kampus, Sponsor, Konsumsi, Transport, dll.
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // pencatat transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
        Schema::dropIfExists('surats');
        Schema::dropIfExists('kepanitiaans');
        Schema::dropIfExists('events');
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('prokers');
    }
};
