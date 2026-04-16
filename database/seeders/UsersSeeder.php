<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Master
        $admin = User::firstOrCreate(
            ['email' => 'baltekrawa1@gmail.com'],
            [
                'name'               => 'Admin BTR',
                'username'           => 'admin',
                'is_admin'           => 1,
                'password'           => Hash::make('adminbaltekrawa123'),
                'no_id'              => 'ADM001',
                'no_hp'              => '081234567890',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Admin Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@baltekrawa.go.id'],
            [
                'name'               => 'Editor Konten',
                'username'           => 'editor',
                'is_admin'           => 1,
                'password'           => Hash::make('editor123'),
                'no_id'              => 'ADM002',
                'no_hp'              => '081234567891',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Admin Layanan
        $adminLayanan = User::firstOrCreate(
            ['email' => 'layanan@baltekrawa.go.id'],
            [
                'name'               => 'Admin Layanan',
                'username'           => 'adminlayanan',
                'is_admin'           => 1,
                'password'           => Hash::make('layanan123'),
                'no_id'              => 'ADM003',
                'no_hp'              => '081234567892',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Katim (Ketua Tim)
        $katim = User::firstOrCreate(
            ['email' => 'katim@baltekrawa.go.id'],
            [
                'name'               => 'Dr. Budi Santoso',
                'username'           => 'katim_budi',
                'is_admin'           => 1,
                'password'           => Hash::make('katim123'),
                'no_id'              => 'PEG001',
                'no_hp'              => '081234567893',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Analis
        $analis = User::firstOrCreate(
            ['email' => 'analis@baltekrawa.go.id'],
            [
                'name'               => 'Ir. Siti Rahayu',
                'username'           => 'analis_siti',
                'is_admin'           => 1,
                'password'           => Hash::make('analis123'),
                'no_id'              => 'PEG002',
                'no_hp'              => '081234567894',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Teknisi
        $teknisi = User::firstOrCreate(
            ['email' => 'teknisi@baltekrawa.go.id'],
            [
                'name'               => 'Ahmad Teknisi',
                'username'           => 'teknisi_ahmad',
                'is_admin'           => 1,
                'password'           => Hash::make('teknisi123'),
                'no_id'              => 'PEG003',
                'no_hp'              => '081234567895',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Balai Teknik Rawa',
            ]
        );

        // Pelanggan 1 (existing)
        $pelanggan1 = User::firstOrCreate(
            ['email' => 'yasir.haq98@gmail.com'],
            [
                'name'               => 'Yasir Haq',
                'username'           => 'yasir',
                'is_admin'           => 0,
                'password'           => Hash::make('12345'),
                'no_id'              => '165150201111185',
                'no_hp'              => '085678901234',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Universitas Brawijaya',
            ]
        );

        // Pelanggan 2
        $pelanggan2 = User::firstOrCreate(
            ['email' => 'pelanggan2@example.com'],
            [
                'name'               => 'PT Rekayasa Lahan',
                'username'           => 'rekayasa_lahan',
                'is_admin'           => 0,
                'password'           => Hash::make('pelanggan123'),
                'no_id'              => 'PL002',
                'no_hp'              => '082345678901',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'PT Rekayasa Lahan Nusantara',
            ]
        );

        // Pelanggan 3
        $pelanggan3 = User::firstOrCreate(
            ['email' => 'dinas.pu@example.com'],
            [
                'name'               => 'Dinas PU Kabupaten',
                'username'           => 'dinas_pu',
                'is_admin'           => 0,
                'password'           => Hash::make('dinas123'),
                'no_id'              => 'PL003',
                'no_hp'              => '083456789012',
                'verification_token' => '',
                'is_verified'        => 1,
                'reset_token'        => '',
                'instansi'           => 'Dinas Pekerjaan Umum Kab. Ogan Komering Ilir',
            ]
        );

        // Assign roles
        $admin->syncRoles(['admin-master']);
        $editor->syncRoles(['admin-editor']);
        $adminLayanan->syncRoles(['admin-layanan-master']);
        $katim->syncRoles(['katim']);
        $analis->syncRoles(['analis']);
        $teknisi->syncRoles(['teknisi']);
        $pelanggan1->syncRoles(['pelanggan']);
        $pelanggan2->syncRoles(['pelanggan']);
        $pelanggan3->syncRoles(['pelanggan']);
    }
}
