<?php

namespace Database\Seeders;

use App\Models\GaleriFoto;
use App\Models\Pengumuman;
use App\Models\Post;
use Illuminate\Database\Seeder;

class FotoGalleryPaginationDemoSeeder extends Seeder
{
    public function run(): void
    {
        GaleriFoto::query()
            ->where('title', 'like', 'Demo Galeri Foto %')
            ->delete();

        $demoPhotos = [
            'Kondisi Pintu Air Modular di Anjir Barat',
            'Kondisi Pintu Air Modular di Anjir Serat',
            'Kondisi Saluran Primer Wilayah Timur',
            'Pengamatan Lapangan Struktur Tanggul',
            'Kegiatan Monitoring Rawa Pasang Surut',
            'Pemeriksaan Elevasi Pintu Air Sekunder',
            'Dokumentasi Tim Survei Lapangan Barat',
            'Pengukuran Geometri Saluran Tersier',
            'Koordinasi Teknis di Lokasi Anjir',
            'Inspeksi Visual Bangunan Pelengkap',
            'Pemetaan Kondisi Infrastruktur Rawa',
            'Pelaksanaan Pengujian Lapangan Struktur',
        ];

        for ($index = 0; $index < 44; $index++) {
            $title = $demoPhotos[$index % count($demoPhotos)];

            GaleriFoto::create([
                'title' => 'Demo Galeri Foto ' . ($index + 1) . ' - ' . $title,
                'path_image' => $index % 2 === 0 ? 'assets/fotoDumy.jpeg' : 'assets/balaiRawa.png',
                'type' => 'image',
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => now()->subDays($index),
                'updated_at' => now()->subDays($index),
            ]);
        }

        Post::query()
            ->take(2)
            ->get()
            ->each(function (Post $post, int $index) {
                if (str_contains($post->body ?? '', 'foto-gallery-demo-image')) {
                    return;
                }

                $image = $index === 0 ? '/assets/struktur.png' : '/assets/fotoDumy.jpeg';

                $post->update([
                    'body' => ($post->body ?? '') . '<p><img src="' . $image . '" alt="foto-gallery-demo-image"></p>',
                ]);
            });

        Pengumuman::published()
            ->take(2)
            ->get()
            ->each(function (Pengumuman $pengumuman, int $index) {
                if (str_contains($pengumuman->isi ?? '', 'foto-gallery-demo-image')) {
                    return;
                }

                $image = $index === 0 ? '/assets/balaiRawa.png' : '/assets/beritaterkini1.png';

                $pengumuman->update([
                    'isi' => ($pengumuman->isi ?? '') . '<p><img src="' . $image . '" alt="foto-gallery-demo-image"></p>',
                ]);
            });
    }
}
