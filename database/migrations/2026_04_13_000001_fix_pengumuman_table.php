<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Drop columns from original migration that don't match the controller
            $table->dropColumn(['gambar', 'is_pinned', 'is_published']);
        });

        Schema::table('pengumuman', function (Blueprint $table) {
            // Add columns expected by PengumumanController
            $table->string('lampiran_path')->nullable()->after('isi');
            $table->boolean('is_active')->default(true)->after('lampiran_path');
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropColumn(['lampiran_path', 'is_active']);
        });

        Schema::table('pengumuman', function (Blueprint $table) {
            $table->string('gambar')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(false);
        });
    }
};
