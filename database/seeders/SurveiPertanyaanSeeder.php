<?php

namespace Database\Seeders;

use App\Models\SurveiPertanyaan;
use Illuminate\Database\Seeder;

class SurveiPertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $unsurPelayanan = [
            ['urutan' => 1, 'unsur' => 'Persyaratan',       'pertanyaan' => 'Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?'],
            ['urutan' => 2, 'unsur' => 'Sistem/Mekanisme',   'pertanyaan' => 'Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini?'],
            ['urutan' => 3, 'unsur' => 'Waktu Penyelesaian', 'pertanyaan' => 'Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?'],
            ['urutan' => 4, 'unsur' => 'Biaya/Tarif',        'pertanyaan' => 'Bagaimana pendapat Saudara tentang kewajaran biaya/tarif dalam pelayanan?'],
            ['urutan' => 5, 'unsur' => 'Produk Layanan',     'pertanyaan' => 'Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?'],
            ['urutan' => 6, 'unsur' => 'Kompetensi Pelaksana', 'pertanyaan' => 'Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas dalam pelayanan?'],
            ['urutan' => 7, 'unsur' => 'Perilaku Pelaksana',  'pertanyaan' => 'Bagaimana pendapat Saudara tentang perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?'],
            ['urutan' => 8, 'unsur' => 'Penanganan Pengaduan', 'pertanyaan' => 'Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana penanganan pengaduan pengguna layanan?'],
            ['urutan' => 9, 'unsur' => 'Sarana dan Prasarana', 'pertanyaan' => 'Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana pelayanan?'],
        ];

        foreach ($unsurPelayanan as $item) {
            SurveiPertanyaan::firstOrCreate(
                ['urutan' => $item['urutan']],
                $item
            );
        }
    }
}
