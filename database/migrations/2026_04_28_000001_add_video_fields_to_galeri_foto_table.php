<?php

use App\Models\GaleriFoto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galeri_foto', function (Blueprint $table) {
            if (!Schema::hasColumn('galeri_foto', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }

            if (!Schema::hasColumn('galeri_foto', 'category')) {
                $table->string('category', 50)->nullable()->after('type');
            }

            if (!Schema::hasColumn('galeri_foto', 'source_type')) {
                $table->string('source_type', 20)->nullable()->after('category');
            }

            if (!Schema::hasColumn('galeri_foto', 'source_url')) {
                $table->text('source_url')->nullable()->after('source_type');
            }
        });

        $slugCounts = [];

        DB::table('galeri_foto')->orderBy('id')->get()->each(function ($item) use (&$slugCounts) {
            $baseSlug = Str::slug($item->title ?: ('galeri-' . $item->id)) ?: ('galeri-' . $item->id);

            $slugCounts[$baseSlug] = ($slugCounts[$baseSlug] ?? 0) + 1;
            $slug = $slugCounts[$baseSlug] === 1 ? $baseSlug : ($baseSlug . '-' . $slugCounts[$baseSlug]);

            DB::table('galeri_foto')
                ->where('id', $item->id)
                ->update([
                    'slug' => $item->slug ?: $slug,
                    'category' => $item->category ?: ($item->type === GaleriFoto::TYPE_VIDEO ? 'Dokumentasi' : null),
                    'source_type' => $item->source_type ?: ($item->type === GaleriFoto::TYPE_VIDEO ? GaleriFoto::SOURCE_TYPE_UPLOAD : null),
                ]);
        });

        Schema::table('galeri_foto', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('galeri_foto', function (Blueprint $table) {
            if (Schema::hasColumn('galeri_foto', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('galeri_foto', 'source_url')) {
                $table->dropColumn('source_url');
            }

            if (Schema::hasColumn('galeri_foto', 'source_type')) {
                $table->dropColumn('source_type');
            }

            if (Schema::hasColumn('galeri_foto', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
