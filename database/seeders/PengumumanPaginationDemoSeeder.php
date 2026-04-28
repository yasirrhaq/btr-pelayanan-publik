<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PengumumanPaginationDemoSeeder extends Seeder
{
    public function run(): void
    {
        $sampleDokumenSource = public_path('assets/sample-dokumen.pdf');
        $sampleDokumenTarget = storage_path('app/public/pengumuman/sample-dokumen-btr.pdf');

        if (is_file($sampleDokumenSource)) {
            if (!is_dir(dirname($sampleDokumenTarget))) {
                File::makeDirectory(dirname($sampleDokumenTarget), 0777, true, true);
            }

            if (!is_file($sampleDokumenTarget)) {
                File::copy($sampleDokumenSource, $sampleDokumenTarget);
            }
        }

        Pengumuman::withTrashed()
            ->where('judul', 'like', 'Demo Pengumuman Pagination %')
            ->forceDelete();

        $adminUser = User::where('email', 'baltekrawa1@gmail.com')->first();

        if (!$adminUser) {
            return;
        }

        $thumbnails = [
            'assets/fotoDumy.jpeg',
            'assets/balaiRawa.png',
            'assets/beritaterkini1.png',
            'assets/beritaterkini2.png',
        ];

        for ($i = 1; $i <= 12; $i++) {
            Pengumuman::create([
                'judul' => 'Demo Pengumuman Pagination ' . $i,
                'isi' => 'Pengumuman demo nomor ' . $i . ' untuk verifikasi tampilan thumbnail, counter views, dan pagination publik pada halaman pengumuman Balai Teknik Rawa.',
                'lampiran_path' => 'pengumuman/sample-dokumen-btr.pdf',
                'thumbnail_path' => $thumbnails[($i - 1) % count($thumbnails)],
                'is_active' => true,
                'views' => 25 + ($i * 17),
                'created_by' => $adminUser->id,
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i),
            ]);
        }
    }
}
