<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE galeri_foto MODIFY path_image VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement("UPDATE galeri_foto SET path_image = '' WHERE path_image IS NULL");
        DB::statement('ALTER TABLE galeri_foto MODIFY path_image VARCHAR(255) NOT NULL');
    }
};
