<?php

namespace Database\Seeders;

use App\Models\KategoriInstansi;
use Illuminate\Database\Seeder;

class KategoriInstansiSeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($kategori as $nama) {
            KategoriInstansi::firstOrCreate(['nama' => $nama]);
        }
    }
}
