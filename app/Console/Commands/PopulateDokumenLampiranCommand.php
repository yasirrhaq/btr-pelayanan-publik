<?php

namespace App\Console\Commands;

use App\Models\Pengumuman;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PopulateDokumenLampiranCommand extends Command
{
    protected $signature = 'demo:populate-dokumen-lampiran';

    protected $description = 'Populate sample lampiran for pengumuman and berita so dokumen page has test data.';

    public function handle(): int
    {
        $sourcePath = public_path('assets/sample-dokumen.pdf');

        if (!is_file($sourcePath)) {
            $this->error('Sample dokumen source not found at public/assets/sample-dokumen.pdf');

            return self::FAILURE;
        }

        $lampiranPath = $this->ensurePengumumanLampiranFile($sourcePath);
        $pengumumanUpdated = $this->populatePengumuman($lampiranPath);
        $beritaUpdated = $this->populateBerita($lampiranPath);

        $this->info("Pengumuman updated: {$pengumumanUpdated}");
        $this->info("Berita updated: {$beritaUpdated}");

        return self::SUCCESS;
    }

    protected function ensurePengumumanLampiranFile(string $sourcePath): string
    {
        $relativePath = 'pengumuman/sample-dokumen-btr.pdf';
        $targetPath = storage_path('app/public/' . $relativePath);

        if (!is_dir(dirname($targetPath))) {
            File::makeDirectory(dirname($targetPath), 0777, true, true);
        }

        if (!is_file($targetPath)) {
            File::copy($sourcePath, $targetPath);
        }

        return $relativePath;
    }

    protected function populatePengumuman(string $lampiranPath): int
    {
        $updated = 0;

        Pengumuman::published()
            ->whereNull('lampiran_path')
            ->latest()
            ->take(3)
            ->get()
            ->each(function (Pengumuman $pengumuman) use ($lampiranPath, &$updated) {
                $pengumuman->update([
                    'lampiran_path' => $lampiranPath,
                ]);

                $updated++;
            });

        return $updated;
    }

    protected function populateBerita(string $lampiranPath): int
    {
        $updated = 0;

        Post::latest()
            ->take(3)
            ->get()
            ->each(function (Post $post) use ($lampiranPath, &$updated) {
                if ($post->lampiran_path) {
                    return;
                }

                $post->update([
                    'lampiran_path' => $lampiranPath,
                ]);

                $updated++;
            });

        return $updated;
    }
}
