<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Run order matters — dependencies must come before dependents:
     * 1. Roles & Permissions (spatie)
     * 2. Reference data (KategoriInstansi, JenisLayanan, UrlLayanan, StatusLayanan)
     * 3. Users (assigns roles → depends on #1 and #2)
     * 4. Konten Web (Posts, Berita, Galeri, Fasilitas, etc.)
     * 5. Survei Pertanyaan (9 unsur SKM)
     * 6. Layanan Operasional (FormatNomor, HariLibur, Tim, Permohonan demo)
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,    // roles + permissions
            ReferenceDataSeeder::class,          // JenisLayanan, UrlLayanan, StatusLayanan, KategoriInstansi
            UsersSeeder::class,                  // users with role assignments
            KontenWebSeeder::class,              // Banner, Galeri, Fasilitas, Pengumuman, etc.
            SurveiPertanyaanSeeder::class,       // 9 unsur SKM
            LayananOperasionalSeeder::class,     // FormatNomor, HariLibur, Tim, sample Permohonan
        ]);
    }
}
