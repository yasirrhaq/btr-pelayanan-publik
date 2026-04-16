<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FasilitasBalai;
use App\Models\FooterSetting;
use App\Models\FotoHome;
use App\Models\GaleriFoto;
use App\Models\InfoPegawai;
use App\Models\KaryaIlmiah;
use App\Models\Post;
use App\Models\Pengumuman;
use App\Models\SitusTerkait;
use App\Models\StrukturOrganisasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KontenWebSeeder extends Seeder
{
    public function run(): void
    {
        // --- Kategori Berita ---
        $categories = [
            ['name' => 'Berita Utama',      'slug' => 'berita-utama'],
            ['name' => 'Artikel',            'slug' => 'artikel'],
            ['name' => 'Pengumuman',         'slug' => 'pengumuman'],
            ['name' => 'Kegiatan',           'slug' => 'kegiatan'],
            ['name' => 'Inovasi & Teknologi','slug' => 'inovasi-teknologi'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // --- Foto Home (Banner) ---
        $banners = [
            [
                'title'       => 'Balai Teknik Rawa',
                'deskripsi'   => 'Balai Teknik Rawa mempunyai tugas melaksanakan pengembangan, perekayasaan, dan pelaksanaan pelayanan teknis pengujian, pengkajian, inspeksi, dan sertifikasi di bidang rawa.',
                'path_image'  => 'assets/balaiRawa.png',
                'created_by'  => 'admin',
            ],
            [
                'title'       => 'Layanan Teknis Unggulan',
                'deskripsi'   => 'Kami menyediakan layanan advis teknis, pengujian laboratorium, dan permohonan data untuk mendukung pembangunan infrastruktur rawa di Indonesia.',
                'path_image'  => 'assets/balaiRawa.png',
                'created_by'  => 'admin',
            ],
            [
                'title'       => 'Komitmen Pelayanan Prima',
                'deskripsi'   => 'Bersertifikasi ISO 9001:2015, BTR berkomitmen memberikan pelayanan berkualitas tinggi kepada masyarakat dan pemangku kepentingan.',
                'path_image'  => 'assets/balaiRawa.png',
                'created_by'  => 'admin',
            ],
        ];
        if (FotoHome::count() === 0) {
            foreach ($banners as $b) {
                FotoHome::create($b);
            }
        }
        FotoHome::where(function ($query) {
            $query->whereNull('path_image')->orWhere('path_image', '');
        })->update(['path_image' => 'assets/balaiRawa.png']);

        // --- Info Pegawai ---
        if (InfoPegawai::count() === 0) {
            InfoPegawai::create([
                'title'      => 'Data Pegawai Balai Teknik Rawa',
                'path_image' => 'assets/info-pegawai.jpg',
                'created_by' => 'admin',
            ]);
        }
        InfoPegawai::where(function ($query) {
            $query->whereNull('path_image')->orWhere('path_image', '');
        })->update(['path_image' => 'assets/info-pegawai.jpg']);

        // --- Struktur Organisasi ---
        if (StrukturOrganisasi::count() === 0) {
            StrukturOrganisasi::create([
                'title'      => 'Struktur Organisasi BTR 2024',
                'path_image' => 'assets/struktur.png',
                'created_by' => 'admin',
            ]);
        }
        StrukturOrganisasi::where(function ($query) {
            $query->whereNull('path_image')->orWhere('path_image', '');
        })->update(['path_image' => 'assets/struktur.png']);

        // --- Fasilitas Balai ---
        $fasilitas = [
            ['title' => 'Laboratorium Tanah',      'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Laboratorium Air',         'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Ruang Rapat Utama',        'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Perpustakaan Teknis',      'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Gedung Workshop',          'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
        ];
        if (FasilitasBalai::count() === 0) {
            foreach ($fasilitas as $f) {
                FasilitasBalai::create($f);
            }
        }
        FasilitasBalai::where(function ($query) {
            $query->whereNull('path_image')->orWhere('path_image', '');
        })->update(['path_image' => 'assets/fotoDumy.jpeg']);

        // --- Galeri Foto ---
        $galeri = [
            ['title' => 'Kegiatan Survei Lapangan 2024',     'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Workshop Teknis Rawa Nasional',      'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Pengujian Laboratorium Sedimen',     'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Kunjungan Dinas Provinsi Sumsel',    'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
            ['title' => 'Pelatihan Penggunaan Alat Ukur',     'path_image' => 'assets/fotoDumy.jpeg', 'created_by' => 'admin'],
        ];
        if (GaleriFoto::count() <= 1) {
            foreach ($galeri as $g) {
                GaleriFoto::firstOrCreate(['title' => $g['title']], $g);
            }
        }
        GaleriFoto::where(function ($query) {
            $query->whereNull('path_image')->orWhere('path_image', '');
        })->update(['path_image' => 'assets/fotoDumy.jpeg']);

        // --- Footer Setting ---
        $footer = FooterSetting::first();
        if ($footer) {
            $footer->update([
                'nama_kementerian' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'alamat'           => 'Jl. Gatot Subroto No. 82, Palembang, Sumatera Selatan 30151',
                'no_hp'            => '(0711) 517541',
                'email'            => 'baltekrawa@pupr.go.id',
            ]);
        } else {
            FooterSetting::create([
                'nama_kementerian' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'alamat'           => 'Jl. Gatot Subroto No. 82, Palembang, Sumatera Selatan 30151',
                'no_hp'            => '(0711) 517541',
                'email'            => 'baltekrawa@pupr.go.id',
            ]);
        }

        // --- Situs Terkait ---
        $situs = [
            ['title' => 'Kementerian PUPR',       'url' => 'https://www.pu.go.id',           'path_image' => ''],
            ['title' => 'PUSDATIN PUPR',           'url' => 'https://pusdatin.pu.go.id',       'path_image' => ''],
            ['title' => 'BPJT',                    'url' => 'https://bpjt.pu.go.id',           'path_image' => ''],
            ['title' => 'LPJK',                    'url' => 'https://lpjk.pu.go.id',           'path_image' => ''],
        ];
        if (SitusTerkait::count() === 0) {
            foreach ($situs as $s) {
                SitusTerkait::create($s);
            }
        }

        // --- Karya Ilmiah / Renstra ---
        if (\App\Models\KaryaIlmiah::count() === 0) {
            $karya = [
                [
                    'title'          => 'Analisis Hidraulik Rawa Lebak di Sumatera Selatan',
                    'slug'           => 'analisis-hidraulik-rawa-lebak-sumatera-selatan',
                    'penerbit'       => 'Jurnal Teknik Rawa',
                    'tanggal_terbit' => '2023-06-01',
                    'issn_online'    => '2549-1234',
                    'issn_cetak'     => '2549-5678',
                    'subyek'         => 'Hidrologi, Rawa Lebak',
                    'abstract'       => 'Penelitian ini membahas karakteristik hidraulik dan hidrologi rawa lebak yang ada di wilayah Sumatera Selatan.',
                    'bahasa'         => 'id',
                    'publish_at'     => '2023-06-01',
                ],
                [
                    'title'          => 'Rencana Strategis BTR 2020-2024',
                    'slug'           => 'rencana-strategis-btr-2020-2024',
                    'penerbit'       => 'Balai Teknik Rawa',
                    'tanggal_terbit' => '2020-01-01',
                    'issn_online'    => '',
                    'issn_cetak'     => '',
                    'subyek'         => 'Renstra, Perencanaan',
                    'abstract'       => 'Dokumen rencana strategis Balai Teknik Rawa periode 2020-2024 yang memuat visi, misi, tujuan, sasaran, dan program kerja.',
                    'bahasa'         => 'id',
                    'publish_at'     => '2020-01-01',
                ],
                [
                    'title'          => 'Evaluasi Drainase Lahan Rawa Pasang Surut',
                    'slug'           => 'evaluasi-drainase-lahan-rawa-pasang-surut',
                    'penerbit'       => 'Prosiding Seminar Nasional Teknik Sipil',
                    'tanggal_terbit' => '2022-09-15',
                    'issn_online'    => '2088-9011',
                    'issn_cetak'     => '2088-9010',
                    'subyek'         => 'Drainase, Rawa Pasang Surut',
                    'abstract'       => 'Evaluasi kinerja sistem drainase pada lahan rawa pasang surut di delta Musi, Sumatera Selatan.',
                    'bahasa'         => 'id',
                    'publish_at'     => '2022-09-15',
                ],
            ];
            foreach ($karya as $k) {
                \App\Models\KaryaIlmiah::create($k);
            }
        }

        // --- Berita ---
        if (Post::count() === 0) {
            $categoryMap = Category::pluck('id', 'slug');

            $posts = [
                [
                    'category_slug' => 'berita-utama',
                    'title' => 'Balai Teknik Rawa Perkuat Layanan Advis Teknis Tahun 2026',
                    'slug' => 'balai-teknik-rawa-perkuat-layanan-advis-teknis-tahun-2026',
                    'image' => 'assets/beritautama.png',
                    'excerpt' => 'Balai Teknik Rawa memperkuat layanan advis teknis untuk mempercepat dukungan teknis bidang rawa di berbagai wilayah kerja.',
                    'body' => '<p>Balai Teknik Rawa terus memperkuat layanan advis teknis guna mendukung kebutuhan perencanaan, pelaksanaan, dan evaluasi infrastruktur rawa secara lebih cepat dan terukur.</p><p>Penguatan layanan dilakukan melalui penajaman proses konsultasi teknis, penyiapan dokumen rujukan, serta peningkatan koordinasi dengan pemohon layanan dari pusat maupun daerah.</p><p>Langkah ini diharapkan membantu pemangku kepentingan memperoleh rekomendasi teknis yang lebih responsif, akurat, dan sesuai karakteristik wilayah rawa.</p>',
                    'publish_at' => '2026-04-10 09:00:00',
                ],
                [
                    'category_slug' => 'kegiatan',
                    'title' => 'Tim Balai Teknik Rawa Laksanakan Survei Lapangan di Sumatera Selatan',
                    'slug' => 'tim-balai-teknik-rawa-laksanakan-survei-lapangan-di-sumatera-selatan',
                    'image' => 'assets/fotoBaner.png',
                    'excerpt' => 'Survei lapangan dilakukan untuk memperkuat data dukung layanan teknis dan evaluasi kondisi lapangan pada kawasan rawa prioritas.',
                    'body' => '<p>Tim teknis Balai Teknik Rawa melaksanakan survei lapangan pada beberapa lokasi prioritas di Sumatera Selatan sebagai bagian dari pengumpulan data teknis dan verifikasi kondisi eksisting.</p><p>Kegiatan ini mencakup observasi lapangan, dokumentasi visual, dan koordinasi dengan pihak setempat untuk memastikan kebutuhan teknis dapat diidentifikasi secara tepat.</p><p>Hasil survei akan menjadi dasar penyusunan rekomendasi teknis lanjutan dan penguatan basis data pelayanan balai.</p>',
                    'publish_at' => '2026-04-08 10:30:00',
                ],
                [
                    'category_slug' => 'inovasi-teknologi',
                    'title' => 'Pengujian Laboratorium Sedimen Dukung Inovasi Analisis Rawa',
                    'slug' => 'pengujian-laboratorium-sedimen-dukung-inovasi-analisis-rawa',
                    'image' => 'assets/beritaterkini1.png',
                    'excerpt' => 'Penguatan laboratorium dilakukan melalui pengujian sedimen dan pemanfaatan hasil analisis untuk pengembangan teknologi bidang rawa.',
                    'body' => '<p>Laboratorium Balai Teknik Rawa melaksanakan pengujian sedimen untuk mendukung kebutuhan analisis teknis dan pengembangan inovasi bidang rawa.</p><p>Data hasil pengujian dimanfaatkan sebagai masukan dalam penyusunan kajian, evaluasi mutu, dan pengembangan metode pelayanan teknis yang lebih adaptif.</p><p>Dengan dukungan laboratorium yang semakin baik, proses layanan teknis diharapkan menjadi lebih konsisten dan dapat dipertanggungjawabkan.</p>',
                    'publish_at' => '2026-04-05 13:00:00',
                ],
                [
                    'category_slug' => 'artikel',
                    'title' => 'Workshop Teknis Rawa Bahas Penguatan Data dan Informasi Publik',
                    'slug' => 'workshop-teknis-rawa-bahas-penguatan-data-dan-informasi-publik',
                    'image' => 'assets/beritaterkini2.png',
                    'excerpt' => 'Workshop internal membahas pengelolaan data teknis, dokumentasi layanan, dan penyajian informasi publik yang lebih mudah diakses.',
                    'body' => '<p>Balai Teknik Rawa menyelenggarakan workshop teknis internal yang berfokus pada peningkatan kualitas pengelolaan data dan informasi publik.</p><p>Materi yang dibahas meliputi konsistensi dokumentasi, pemanfaatan data layanan, serta perbaikan alur penyajian informasi pada kanal digital balai.</p><p>Kegiatan ini menjadi bagian dari upaya peningkatan mutu layanan informasi dan transparansi layanan teknis kepada masyarakat.</p>',
                    'publish_at' => '2026-04-03 08:15:00',
                ],
                [
                    'category_slug' => 'kegiatan',
                    'title' => 'Balai Teknik Rawa Terima Kunjungan Koordinasi Mitra Daerah',
                    'slug' => 'balai-teknik-rawa-terima-kunjungan-koordinasi-mitra-daerah',
                    'image' => 'assets/balaiRawa.png',
                    'excerpt' => 'Kunjungan koordinasi membahas peluang sinergi layanan teknis, data pendukung, dan penguatan kapasitas kelembagaan bidang rawa.',
                    'body' => '<p>Balai Teknik Rawa menerima kunjungan koordinasi dari mitra daerah dalam rangka membahas kebutuhan layanan teknis dan peluang kolaborasi lintas instansi.</p><p>Pertemuan menyoroti pentingnya penyediaan data pendukung, dokumentasi hasil layanan, dan kesinambungan komunikasi teknis antara pusat dan daerah.</p><p>Diharapkan koordinasi ini memperluas dampak layanan Balai Teknik Rawa pada wilayah kerja yang membutuhkan dukungan teknis bidang rawa.</p>',
                    'publish_at' => '2026-04-01 11:00:00',
                ],
            ];

            foreach ($posts as $post) {
                Post::create([
                    'category_id' => $categoryMap[$post['category_slug']] ?? $categoryMap['artikel'],
                    'title' => $post['title'],
                    'slug' => $post['slug'],
                    'image' => $post['image'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'publish_at' => $post['publish_at'],
                ]);
            }
        }

        // --- Pengumuman ---
        $adminUser = \App\Models\User::where('email', 'baltekrawa1@gmail.com')->first();
        if (Pengumuman::count() === 0 && $adminUser) {
            $pengumuman = [
                [
                    'judul'      => 'Jadwal Pemeliharaan Sistem Layanan Online',
                    'isi'        => 'Diberitahukan kepada seluruh pengguna layanan bahwa sistem layanan online akan dilakukan pemeliharaan pada hari Sabtu, 20 April 2024 pukul 22.00-06.00 WIB. Selama periode tersebut, layanan online tidak dapat diakses.',
                    'is_active'  => true,
                    'created_by' => $adminUser->id,
                ],
                [
                    'judul'      => 'Pengumuman Penerimaan Permohonan Layanan Advis Teknis Batch 2 Tahun 2024',
                    'isi'        => 'Balai Teknik Rawa membuka penerimaan permohonan layanan advis teknis batch kedua tahun 2024. Pendaftaran dibuka mulai 1 Mei 2024. Pemohon wajib melengkapi dokumen persyaratan sesuai standar pelayanan yang berlaku.',
                    'is_active'  => true,
                    'created_by' => $adminUser->id,
                ],
                [
                    'judul'      => 'Informasi Tarif Layanan Pengujian Laboratorium 2024',
                    'isi'        => 'Sesuai Peraturan Pemerintah Nomor 30 Tahun 2021 tentang Jenis dan Tarif atas Jenis PNBP yang Berlaku pada Kementerian PUPR, tarif layanan pengujian laboratorium BTR mengalami pembaruan terhitung 1 Januari 2024.',
                    'is_active'  => true,
                    'created_by' => $adminUser->id,
                ],
            ];
            foreach ($pengumuman as $p) {
                Pengumuman::create($p);
            }
        }
    }
}
