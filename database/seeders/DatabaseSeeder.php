<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\FotoHome;
use App\Models\GaleriFoto;
use App\Models\InfoPegawai;
use App\Models\JenisLayanan;
use App\Models\KaryaIlmiah;
use App\Models\StatusLayanan;
use App\Models\SuratPermohonan;
use App\Models\UrlLayanan;
use Illuminate\Database\Seeder;
use PharIo\Manifest\Url;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        User::create([
            'name' => 'Yasir Haq',
            'username' => 'yasir',
            'email' => 'yasir.haq98@gmail.com',
            'password' => bcrypt('12345'),
            'no_id' => '165150201111185',
            'verification_token' => '',
            'is_verified' => 1,
            'reset_token' => '',
            'instansi' => 'ub'
        ]);

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'is_admin' => 1,
            'email' => 'baltekrawa1@gmail.com',
            'password' => bcrypt('adminbaltekrawa123'),
            'no_id' => 'admin_1',
            'verification_token' => '',
            'is_verified' => 1,
            'reset_token' => '',
            'instansi' => 'BTR'
        ]);

        Category::create([
            'name' => 'Berita Utama',
            'slug' => 'berita-utama'
        ]);

        Category::create([
            'name' => 'Artikel',
            'slug' => 'artikel'
        ]);

        StatusLayanan::create([
            'name' => 'Disetujui'
        ]);

        StatusLayanan::create([
            'name' => 'Diproses'
        ]);

        StatusLayanan::create([
            'name' => 'Ditolak'
        ]);

        StatusLayanan::create([
            'name' => 'Selesai'
        ]);

        JenisLayanan::create([
            'name' => 'Advis Teknis'
        ]);

        JenisLayanan::create([
            'name' => 'Pengujian Laboratorium'
        ]);
        JenisLayanan::create([
            'name' => 'Permohonan Data'
        ]);

        UrlLayanan::create([
            'name' => 'Advis Teknis',
            'url' => 'link advis'
        ]);
        UrlLayanan::create([
            'name' => 'Pengujian Laboratorium',
            'url' => 'link lab'
        ]);
        UrlLayanan::create([
            'name' => 'Permohonan Data',
            'url' => 'https://forms.gle/7ousk5h4t7Kx8CNr5'
        ]);
        UrlLayanan::create([
            'name' => 'Layanan Perpustakaan',
            'url' => 'http://192.202.151.10/perpus_balairawa'
        ]);
        UrlLayanan::create([
            'name' => 'Rencana Strategi',
            'url' => 'link rencana strategi'
        ]);
        UrlLayanan::create([
            'name' => 'Survey Kepuasan Pelanggan',
            'url' => 'https://forms.gle/DCpku1dAkN9XUYK57'
        ]);
        UrlLayanan::create([
            'name' => 'Hasil Survey Kepuasan Pelanggan',
            'url' => 'link hasil survey kepuasan pelanggan'
        ]);
        UrlLayanan::create([
            'name' => 'Whatsap BTR',
            'url' => 'https://wa.me/+62813463336'
        ]);

        FotoHome::create([
            'title' => 'PU Balai Teknik Rawa',
            'deskripsi' => 'Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan  pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa.',
            'path_image' => '',
            'created_by' => 'admin'
        ]);

        FotoHome::create([
            'title' => 'PU Balai Teknik Rawa',
            'deskripsi' => 'Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan  pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa.',
            'path_image' => '',
            'created_by' => 'admin'
        ]);

        FotoHome::create([
            'title' => 'PU Balai Teknik Rawa',
            'deskripsi' => 'Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan  pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa.',
            'path_image' => '',
            'created_by' => 'admin'
        ]);

        GaleriFoto::create([
            'title' => 'Foto 1',
            'path_image' => '',
            'created_by' => 'admin'
        ]);

        InfoPegawai::create([
            'title' => 'Info Pegawai PNS',
            'path_image' => '',
            'created_by' => 'admin'
        ]);
        
        KaryaIlmiah::factory(10)->create();

        Post::factory(20)->create();
    }
}
