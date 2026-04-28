<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('judul');
        });

        DB::table('pengumuman')
            ->select('id', 'judul')
            ->orderBy('id')
            ->get()
            ->each(function ($item) {
                $baseSlug = Str::slug($item->judul);
                $baseSlug = $baseSlug !== '' ? $baseSlug : 'pengumuman-' . $item->id;
                $slug = $baseSlug;
                $suffix = 2;

                while (
                    DB::table('pengumuman')
                        ->where('slug', $slug)
                        ->where('id', '!=', $item->id)
                        ->exists()
                ) {
                    $slug = $baseSlug . '-' . $suffix;
                    $suffix++;
                }

                DB::table('pengumuman')
                    ->where('id', $item->id)
                    ->update(['slug' => $slug]);
            });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
