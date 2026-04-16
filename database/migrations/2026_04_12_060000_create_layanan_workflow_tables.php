<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --- Kategori Instansi (untuk profil pelanggan) ---
        Schema::create('kategori_instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Add kategori_instansi_id to users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kategori_instansi_id')->nullable()->after('instansi')
                  ->constrained('kategori_instansi')->nullOnDelete();
            $table->string('no_hp')->nullable()->after('email');
        });

        // --- Tim (team hierarchy: layanan → tim → anggota) ---
        Schema::create('tim', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('jenis_layanan_id')->constrained('jenis_layanan')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tim_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tim')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('jabatan'); // katim, penyelia, analis, teknisi
            $table->timestamps();

            $table->unique(['tim_id', 'user_id']);
        });

        // --- Format Nomor (auto numbering template per layanan) ---
        Schema::create('format_nomor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_layanan_id')->constrained('jenis_layanan')->cascadeOnDelete();
            $table->string('template'); // e.g. {ID}/{KODE}/BTR.{KODE}/{TAHUN}
            $table->string('kode_layanan')->nullable();
            $table->unsignedInteger('counter')->default(0);
            $table->year('tahun_counter');
            $table->timestamps();
        });

        // --- Permohonan (the central service request entity) ---
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pl')->unique()->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_layanan_id')->constrained('jenis_layanan');
            $table->string('perihal');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('baru');
            // baru → verifikasi → penugasan → pelaksanaan → analisis → evaluasi → finalisasi → selesai
            $table->unsignedTinyInteger('progress')->default(0); // 0-100
            $table->foreignId('tim_id')->nullable()->constrained('tim')->nullOnDelete();
            $table->foreignId('katim_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('deadline')->nullable();
            $table->unsignedInteger('sla_hari_kerja')->nullable();
            $table->boolean('is_berbayar')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // --- Dokumen Permohonan (uploaded files: surat pengantar, KTP, etc.) ---
        Schema::create('dokumen_permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->string('tipe'); // surat_pengantar, ktp, lampiran, hasil
            $table->string('nama_file');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('ukuran')->default(0); // bytes
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // --- Workflow Log (audit trail for every status change) ---
        Schema::create('workflow_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->string('dari_status')->nullable();
            $table->string('ke_status');
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('permohonan_id');
        });

        // --- Pembayaran / Billing PNBP ---
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->string('kode_billing')->nullable();
            $table->decimal('nominal', 15, 2)->default(0);
            $table->string('status')->default('belum_bayar');
            // belum_bayar → menunggu_verifikasi → sudah_bayar → ditolak
            $table->string('bukti_bayar_path')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // --- Survei Kepuasan Masyarakat (SKM) ---
        Schema::create('survei_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('urutan');
            $table->string('unsur'); // 9 unsur pelayanan
            $table->text('pertanyaan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('survei_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('saran')->nullable();
            $table->timestamps();

            $table->unique(['permohonan_id', 'user_id']);
        });

        Schema::create('survei_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survei_kepuasan_id')->constrained('survei_kepuasan')->cascadeOnDelete();
            $table->foreignId('survei_pertanyaan_id')->constrained('survei_pertanyaan')->cascadeOnDelete();
            $table->unsignedTinyInteger('nilai'); // 1-4
            $table->timestamps();
        });

        // --- Notifikasi Pelanggan ---
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('permohonan_id')->nullable()->constrained('permohonan')->cascadeOnDelete();
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe')->default('info'); // info, success, warning, danger
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
        });

        // --- Dokumen Final (hasil layanan yang bisa diunduh) ---
        Schema::create('dokumen_final', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->string('nama_dokumen');
            $table->string('path');
            $table->string('tipe')->default('lhp'); // lhp, advis, data, lainnya
            $table->boolean('is_downloadable')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // --- Pengumuman (announcements) ---
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // --- Hari Libur Indonesia (for SLA calculation) ---
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hari_libur');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('dokumen_final');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('survei_jawaban');
        Schema::dropIfExists('survei_kepuasan');
        Schema::dropIfExists('survei_pertanyaan');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('workflow_log');
        Schema::dropIfExists('dokumen_permohonan');
        Schema::dropIfExists('permohonan');
        Schema::dropIfExists('format_nomor');
        Schema::dropIfExists('tim_anggota');
        Schema::dropIfExists('tim');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kategori_instansi_id']);
            $table->dropColumn(['kategori_instansi_id', 'no_hp']);
        });
        Schema::dropIfExists('kategori_instansi');
    }
};
