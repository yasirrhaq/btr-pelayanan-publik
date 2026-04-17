<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_pegawai', function (Blueprint $table) {
            $table->unsignedInteger('urutan')->default(9999)->after('title');
        });

        $ids = DB::table('info_pegawai')->orderBy('id')->pluck('id');

        foreach ($ids as $index => $id) {
            DB::table('info_pegawai')
                ->where('id', $id)
                ->update(['urutan' => $index + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('info_pegawai', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }
};
