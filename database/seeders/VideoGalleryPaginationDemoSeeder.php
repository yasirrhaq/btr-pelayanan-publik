<?php

namespace Database\Seeders;

use App\Models\GaleriFoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoGalleryPaginationDemoSeeder extends Seeder
{
    public function run(): void
    {
        GaleriFoto::query()
            ->where('type', GaleriFoto::TYPE_VIDEO)
            ->where('title', 'like', 'Demo Galeri Video %')
            ->delete();

        $titles = [
            'Dokumentasi Kegiatan Survei Lapangan Rawa',
            'Penjelasan Layanan Pengujian Laboratorium',
            'Publikasi Monitoring Infrastruktur Pintu Air',
            'Dokumentasi Sosialisasi Layanan Teknis',
            'Kegiatan Koordinasi Teknis Wilayah Anjir',
            'Publikasi Penguatan Kapasitas Tim Lapangan',
            'Layanan Konsultasi Teknis untuk Pemohon',
            'Dokumentasi Pemeriksaan Struktur Bangunan Air',
            'Kegiatan Evaluasi Kondisi Rawa Pasang Surut',
        ];

        $youtubeUrls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://www.youtube.com/watch?v=ysz5S6PUM-U',
            'https://www.youtube.com/watch?v=jNQXAC9IVRw',
            'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
        ];

        $categories = GaleriFoto::VIDEO_CATEGORIES;
        $now = now();

        for ($index = 0; $index < 18; $index++) {
            $isYoutube = $index % 3 === 2;
            $title = 'Demo Galeri Video ' . ($index + 1) . ' - ' . $titles[$index % count($titles)];

            GaleriFoto::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'path_image' => $isYoutube ? null : 'assets/sample-video.mp4',
                'type' => GaleriFoto::TYPE_VIDEO,
                'category' => $categories[$index % count($categories)],
                'source_type' => $isYoutube ? GaleriFoto::SOURCE_TYPE_YOUTUBE : GaleriFoto::SOURCE_TYPE_UPLOAD,
                'source_url' => $isYoutube ? $youtubeUrls[$index % count($youtubeUrls)] : null,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now->copy()->subDays($index),
                'updated_at' => $now->copy()->subDays($index),
            ]);
        }
    }
}
