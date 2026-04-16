<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use App\Models\KategoriInstansi;
use App\Models\StatusLayanan;
use App\Models\UrlLayanan;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        // --- Jenis Layanan ---
        $jenisLayanan = [
            'Advis Teknis',
            'Pengujian Laboratorium',
            'Permohonan Data',
            'Layanan Lainnya',
        ];
        foreach ($jenisLayanan as $jl) {
            JenisLayanan::firstOrCreate(['name' => $jl]);
        }

        // --- Status Layanan (legacy - for public tracking widget) ---
        $statusLayanan = [
            'Disetujui',
            'Diproses',
            'Ditolak',
            'Selesai',
        ];
        foreach ($statusLayanan as $sl) {
            StatusLayanan::firstOrCreate(['name' => $sl]);
        }

        // --- URL Layanan (sosial media + layanan links) ---
        $urlLayanan = [
            ['name' => 'Advis Teknis',                      'url' => '#'],
            ['name' => 'Pengujian Laboratorium',             'url' => '#'],
            ['name' => 'Permohonan Data',                   'url' => 'https://forms.gle/7ousk5h4t7Kx8CNr5'],
            ['name' => 'Layanan Perpustakaan',              'url' => 'http://192.202.151.10/perpus_balairawa'],
            ['name' => 'Rencana Strategi',                  'url' => '#'],
            ['name' => 'Survey Kepuasan Pelanggan',         'url' => 'https://forms.gle/DCpku1dAkN9XUYK57'],
            ['name' => 'Hasil Survey Kepuasan Pelanggan',   'url' => '#'],
            ['name' => 'Whatsapp BTR',                      'url' => 'https://wa.me/+628134633360'],
            ['name' => 'Facebook BTR',                      'url' => 'https://facebook.com/baltekrawa'],
            ['name' => 'Instagram BTR',                     'url' => 'https://instagram.com/baltekrawa'],
            ['name' => 'YouTube BTR',                       'url' => 'https://youtube.com/@baltekrawa'],
            ['name' => 'Twitter/X BTR',                     'url' => 'https://twitter.com/baltekrawa'],
        ];
        foreach ($urlLayanan as $ul) {
            UrlLayanan::firstOrCreate(['name' => $ul['name']], $ul);
        }

        // --- Kategori Instansi ---
        $kategori = [
            'Kementerian/Lembaga',
            'Pemerintah Daerah Provinsi',
            'Pemerintah Daerah Kabupaten/Kota',
            'BUMN/BUMD',
            'Swasta',
            'Perguruan Tinggi',
            'Lembaga Penelitian',
            'Perorangan',
            'Lainnya',
        ];
        foreach ($kategori as $k) {
            KategoriInstansi::firstOrCreate(['nama' => $k]);
        }
    }
}
