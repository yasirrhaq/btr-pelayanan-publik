<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galeri_foto', function (Blueprint $table) {
            if (!Schema::hasColumn('galeri_foto', 'type')) {
                $table->string('type', 20)->default('image')->after('path_image');
            }
        });

        DB::table('galeri_foto')->whereNull('type')->update(['type' => 'image']);
    }

    public function down(): void
    {
        Schema::table('galeri_foto', function (Blueprint $table) {
            if (Schema::hasColumn('galeri_foto', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
