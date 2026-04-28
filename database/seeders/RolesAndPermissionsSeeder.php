<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Permissions ---
        $permissions = [
            // Admin Web
            'access-dashboard',
            'manage-users',
            'manage-settings',
            'manage-berita',
            'manage-galeri',
            'manage-profil',
            'manage-sdm',
            'manage-fasilitas',
            'manage-pengumuman',
            'manage-landing-page',
            'manage-ppid',
            'manage-renstra',
            'manage-banner',
            'manage-tautan',
            'manage-layanan-info',
            // Admin Layanan
            'view-all-permohonan',
            'manage-permohonan',
            'verifikasi-permohonan',
            'assign-tim',
            'manage-billing',
            'manage-dokumen-final',
            'manage-survei',
            'manage-tim',
            'manage-format-nomor',
            // Teknis
            'pelaksanaan-teknis',
            'analisis-teknis',
            'evaluasi-teknis',
            // Pelanggan
            'ajukan-permohonan',
            'tracking-permohonan',
            'upload-bukti-bayar',
            'isi-survei',
            'unduh-dokumen',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // --- Roles ---

        // Admin Web - Master: full CMS + user management
        Role::firstOrCreate(['name' => 'admin-master'])->syncPermissions([
            'access-dashboard', 'manage-users', 'manage-settings',
            'manage-berita', 'manage-galeri', 'manage-profil',
            'manage-sdm', 'manage-fasilitas', 'manage-pengumuman',
            'manage-landing-page', 'manage-ppid', 'manage-renstra',
            'manage-banner', 'manage-tautan', 'manage-layanan-info',
            'view-all-permohonan',
            'manage-tim', 'manage-format-nomor', 'manage-survei',
        ]);

        // Admin Web - Editor: content management only
        Role::firstOrCreate(['name' => 'admin-editor'])->syncPermissions([
            'access-dashboard', 'manage-berita', 'manage-galeri', 'manage-pengumuman',
        ]);

        // Admin Layanan - Master: full service management
        Role::firstOrCreate(['name' => 'admin-layanan-master'])->syncPermissions([
            'access-dashboard', 'view-all-permohonan', 'manage-permohonan',
            'manage-billing', 'manage-dokumen-final',
            'manage-survei', 'manage-tim', 'manage-format-nomor',
        ]);

        // Katim: verification + team assignment
        Role::firstOrCreate(['name' => 'katim'])->syncPermissions([
            'access-dashboard', 'view-all-permohonan', 'verifikasi-permohonan', 'assign-tim',
            'manage-dokumen-final',
        ]);

        // Admin Bidang: billing + notifications + handover
        Role::firstOrCreate(['name' => 'admin-bidang'])->syncPermissions([
            'access-dashboard', 'view-all-permohonan', 'manage-billing', 'manage-permohonan',
        ]);

        // Technical staff roles
        Role::firstOrCreate(['name' => 'analis'])->syncPermissions([
            'access-dashboard', 'pelaksanaan-teknis', 'analisis-teknis',
        ]);
        Role::firstOrCreate(['name' => 'penyelia'])->syncPermissions([
            'access-dashboard', 'pelaksanaan-teknis', 'evaluasi-teknis',
        ]);
        Role::firstOrCreate(['name' => 'teknisi'])->syncPermissions([
            'access-dashboard', 'pelaksanaan-teknis',
        ]);

        // Pelanggan: self-service portal
        Role::firstOrCreate(['name' => 'pelanggan'])->syncPermissions([
            'ajukan-permohonan', 'tracking-permohonan',
            'upload-bukti-bayar', 'isi-survei', 'unduh-dokumen',
        ]);
    }
}
