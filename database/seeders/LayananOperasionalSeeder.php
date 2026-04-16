<?php

namespace Database\Seeders;

use App\Models\FormatNomor;
use App\Models\HariLibur;
use App\Models\JenisLayanan;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Models\Tim;
use App\Models\TimAnggota;
use App\Models\User;
use App\Models\UserStatusLayanan;
use App\Models\WorkflowLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LayananOperasionalSeeder extends Seeder
{
    public function run(): void
    {
        // --- Format Nomor (auto-numbering template) ---
        $jenisLayanan = JenisLayanan::all()->keyBy('name');

        $formatNomor = [
            [
                'jenis_layanan_id' => $jenisLayanan['Advis Teknis']->id ?? 1,
                'template'         => 'AT/{YYYY}/{MM}/{SEQ}',
                'kode_layanan'     => 'AT',
                'counter'          => 0,
                'tahun_counter'    => now()->year,
            ],
            [
                'jenis_layanan_id' => $jenisLayanan['Pengujian Laboratorium']->id ?? 2,
                'template'         => 'PL/{YYYY}/{MM}/{SEQ}',
                'kode_layanan'     => 'PL',
                'counter'          => 0,
                'tahun_counter'    => now()->year,
            ],
            [
                'jenis_layanan_id' => $jenisLayanan['Permohonan Data']->id ?? 3,
                'template'         => 'PD/{YYYY}/{MM}/{SEQ}',
                'kode_layanan'     => 'PD',
                'counter'          => 0,
                'tahun_counter'    => now()->year,
            ],
        ];

        foreach ($formatNomor as $fn) {
            FormatNomor::firstOrCreate(
                ['jenis_layanan_id' => $fn['jenis_layanan_id']],
                $fn
            );
        }

        // --- Hari Libur Nasional 2024 Indonesia ---
        $hariLibur = [
            ['tanggal' => '2024-01-01', 'keterangan' => 'Tahun Baru Masehi'],
            ['tanggal' => '2024-02-08', 'keterangan' => 'Tahun Baru Imlek 2575'],
            ['tanggal' => '2024-02-14', 'keterangan' => 'Pemilihan Umum'],
            ['tanggal' => '2024-03-11', 'keterangan' => 'Isra Miraj Nabi Muhammad SAW'],
            ['tanggal' => '2024-03-29', 'keterangan' => 'Jumat Agung'],
            ['tanggal' => '2024-03-31', 'keterangan' => 'Hari Paskah'],
            ['tanggal' => '2024-04-10', 'keterangan' => 'Hari Raya Idul Fitri 1445 H'],
            ['tanggal' => '2024-04-11', 'keterangan' => 'Hari Raya Idul Fitri 1445 H (Hari kedua)'],
            ['tanggal' => '2024-05-01', 'keterangan' => 'Hari Buruh Internasional'],
            ['tanggal' => '2024-05-09', 'keterangan' => 'Kenaikan Isa Almasih'],
            ['tanggal' => '2024-05-23', 'keterangan' => 'Hari Raya Waisak 2568 BE'],
            ['tanggal' => '2024-06-01', 'keterangan' => 'Hari Lahir Pancasila'],
            ['tanggal' => '2024-06-17', 'keterangan' => 'Hari Raya Idul Adha 1445 H'],
            ['tanggal' => '2024-07-07', 'keterangan' => 'Tahun Baru Islam 1446 H'],
            ['tanggal' => '2024-08-17', 'keterangan' => 'Hari Kemerdekaan Republik Indonesia'],
            ['tanggal' => '2024-09-16', 'keterangan' => 'Maulid Nabi Muhammad SAW'],
            ['tanggal' => '2024-12-25', 'keterangan' => 'Hari Raya Natal'],
            // 2025
            ['tanggal' => '2025-01-01', 'keterangan' => 'Tahun Baru Masehi'],
            ['tanggal' => '2025-01-29', 'keterangan' => 'Tahun Baru Imlek 2576'],
            ['tanggal' => '2025-03-28', 'keterangan' => 'Hari Suci Nyepi (Tahun Baru Saka 1947)'],
            ['tanggal' => '2025-03-29', 'keterangan' => 'Isra Miraj Nabi Muhammad SAW'],
            ['tanggal' => '2025-04-18', 'keterangan' => 'Jumat Agung'],
            ['tanggal' => '2025-04-20', 'keterangan' => 'Hari Paskah'],
            ['tanggal' => '2025-03-31', 'keterangan' => 'Hari Raya Idul Fitri 1446 H'],
            ['tanggal' => '2025-04-01', 'keterangan' => 'Hari Raya Idul Fitri 1446 H (Hari kedua)'],
            ['tanggal' => '2025-05-01', 'keterangan' => 'Hari Buruh Internasional'],
            ['tanggal' => '2025-05-29', 'keterangan' => 'Kenaikan Isa Almasih'],
            ['tanggal' => '2025-06-01', 'keterangan' => 'Hari Lahir Pancasila'],
            ['tanggal' => '2025-06-06', 'keterangan' => 'Hari Raya Waisak 2569 BE'],
            ['tanggal' => '2025-06-07', 'keterangan' => 'Hari Raya Idul Adha 1446 H'],
            ['tanggal' => '2025-06-27', 'keterangan' => 'Tahun Baru Islam 1447 H'],
            ['tanggal' => '2025-08-17', 'keterangan' => 'Hari Kemerdekaan Republik Indonesia'],
            ['tanggal' => '2025-09-05', 'keterangan' => 'Maulid Nabi Muhammad SAW'],
            ['tanggal' => '2025-12-25', 'keterangan' => 'Hari Raya Natal'],
            ['tanggal' => '2025-12-26', 'keterangan' => 'Cuti Bersama Natal'],
        ];

        foreach ($hariLibur as $hl) {
            HariLibur::firstOrCreate(['tanggal' => $hl['tanggal']], $hl);
        }

        // --- Tim Teknis ---
        $katimUser    = User::where('email', 'katim@baltekrawa.go.id')->first();
        $analisUser   = User::where('email', 'analis@baltekrawa.go.id')->first();
        $teknisiUser  = User::where('email', 'teknisi@baltekrawa.go.id')->first();

        if ($katimUser && Tim::count() === 0) {
            // Tim Advis Teknis
            $timAdvis = Tim::create([
                'nama'             => 'Tim Advis Teknis I',
                'jenis_layanan_id' => $jenisLayanan['Advis Teknis']->id ?? 1,
                'is_active'        => true,
            ]);
            TimAnggota::create(['tim_id' => $timAdvis->id, 'user_id' => $katimUser->id,   'jabatan' => 'katim']);
            TimAnggota::create(['tim_id' => $timAdvis->id, 'user_id' => $analisUser->id,  'jabatan' => 'analis']);
            TimAnggota::create(['tim_id' => $timAdvis->id, 'user_id' => $teknisiUser->id, 'jabatan' => 'teknisi']);

            // Tim Pengujian Laboratorium
            $timLab = Tim::create([
                'nama'             => 'Tim Pengujian Lab I',
                'jenis_layanan_id' => $jenisLayanan['Pengujian Laboratorium']->id ?? 2,
                'is_active'        => true,
            ]);
            TimAnggota::create(['tim_id' => $timLab->id, 'user_id' => $katimUser->id,   'jabatan' => 'katim']);
            TimAnggota::create(['tim_id' => $timLab->id, 'user_id' => $teknisiUser->id, 'jabatan' => 'teknisi']);

            // Tim Permohonan Data
            $timData = Tim::create([
                'nama'             => 'Tim Permohonan Data',
                'jenis_layanan_id' => $jenisLayanan['Permohonan Data']->id ?? 3,
                'is_active'        => true,
            ]);
            TimAnggota::create(['tim_id' => $timData->id, 'user_id' => $katimUser->id,  'jabatan' => 'katim']);
            TimAnggota::create(['tim_id' => $timData->id, 'user_id' => $analisUser->id, 'jabatan' => 'analis']);
        }

        // --- Sample Permohonan (demo data) ---
        if (Permohonan::count() === 0) {
            $pelanggan1 = User::where('email', 'yasir.haq98@gmail.com')->first();
            $pelanggan2 = User::where('email', 'pelanggan2@example.com')->first();
            $pelanggan3 = User::where('email', 'dinas.pu@example.com')->first();

            $timAdvis = Tim::where('nama', 'Tim Advis Teknis I')->first();
            $timLab   = Tim::where('nama', 'Tim Pengujian Lab I')->first();

            $permohonanData = [];

            if ($pelanggan1) {
                // Permohonan selesai (untuk demo survei)
                $p1 = Permohonan::create([
                    'nomor_pl'         => 'AT/2024/03/001',
                    'user_id'          => $pelanggan1->id,
                    'jenis_layanan_id' => $jenisLayanan['Advis Teknis']->id ?? 1,
                    'perihal'          => 'Advis Teknis Drainase Lahan Rawa Lebak Desa Sungsang',
                    'deskripsi'        => 'Permohonan advis teknis untuk perencanaan sistem drainase lahan rawa lebak seluas ±250 ha di Desa Sungsang, Kabupaten Banyuasin.',
                    'status'           => Permohonan::STATUS_SELESAI,
                    'progress'         => 100,
                    'tim_id'           => $timAdvis?->id,
                    'katim_id'         => $katimUser?->id,
                    'tanggal_mulai'    => Carbon::now()->subDays(45),
                    'tanggal_selesai'  => Carbon::now()->subDays(5),
                    'deadline'         => Carbon::now()->subDays(3),
                    'sla_hari_kerja'   => 30,
                    'is_berbayar'      => true,
                    'created_at'       => Carbon::now()->subDays(50),
                ]);

                // Permohonan dalam proses
                $p2 = Permohonan::create([
                    'nomor_pl'         => 'PL/2024/04/001',
                    'user_id'          => $pelanggan1->id,
                    'jenis_layanan_id' => $jenisLayanan['Pengujian Laboratorium']->id ?? 2,
                    'perihal'          => 'Pengujian Tanah dan Sedimen Rawa Pasang Surut',
                    'deskripsi'        => 'Pengujian sifat fisik dan kimia tanah serta sedimen pada rawa pasang surut untuk keperluan desain fondasi bangunan air.',
                    'status'           => Permohonan::STATUS_PELAKSANAAN,
                    'progress'         => Permohonan::STATUS_PROGRESS[Permohonan::STATUS_PELAKSANAAN],
                    'tim_id'           => $timLab?->id,
                    'katim_id'         => $katimUser?->id,
                    'tanggal_mulai'    => Carbon::now()->subDays(10),
                    'deadline'         => Carbon::now()->addDays(20),
                    'sla_hari_kerja'   => 21,
                    'is_berbayar'      => true,
                    'created_at'       => Carbon::now()->subDays(15),
                ]);

                // Permohonan baru (menunggu verifikasi)
                $p3 = Permohonan::create([
                    'nomor_pl'         => 'AT/2024/04/002',
                    'user_id'          => $pelanggan1->id,
                    'jenis_layanan_id' => $jenisLayanan['Advis Teknis']->id ?? 1,
                    'perihal'          => 'Advis Teknis Polder Rawa Kota Palembang',
                    'deskripsi'        => 'Permohonan advis teknis untuk perencanaan sistem polder sebagai pengendalian banjir rawa di kawasan perkotaan Palembang.',
                    'status'           => Permohonan::STATUS_VERIFIKASI,
                    'progress'         => Permohonan::STATUS_PROGRESS[Permohonan::STATUS_VERIFIKASI],
                    'is_berbayar'      => false,
                    'created_at'       => Carbon::now()->subDays(2),
                ]);
            }

            if ($pelanggan2) {
                $p4 = Permohonan::create([
                    'nomor_pl'         => 'PL/2024/03/002',
                    'user_id'          => $pelanggan2->id,
                    'jenis_layanan_id' => $jenisLayanan['Pengujian Laboratorium']->id ?? 2,
                    'perihal'          => 'Pengujian Kualitas Air Rawa untuk SPAM',
                    'deskripsi'        => 'Pengujian parameter kualitas air rawa sebagai bahan baku Sistem Penyediaan Air Minum (SPAM) di Kabupaten OKI.',
                    'status'           => Permohonan::STATUS_PEMBAYARAN,
                    'progress'         => Permohonan::STATUS_PROGRESS[Permohonan::STATUS_PEMBAYARAN],
                    'is_berbayar'      => true,
                    'created_at'       => Carbon::now()->subDays(8),
                ]);
            }

            if ($pelanggan3) {
                $p5 = Permohonan::create([
                    'nomor_pl'         => 'PD/2024/04/001',
                    'user_id'          => $pelanggan3->id,
                    'jenis_layanan_id' => $jenisLayanan['Permohonan Data']->id ?? 3,
                    'perihal'          => 'Data Hidrologi Rawa Lebak DAS Musi',
                    'deskripsi'        => 'Permohonan data hidrologi dan hidrolika rawa lebak di Daerah Aliran Sungai Musi untuk keperluan perencanaan jaringan irigasi rawa.',
                    'status'           => Permohonan::STATUS_BARU,
                    'progress'         => 0,
                    'is_berbayar'      => false,
                    'created_at'       => Carbon::now()->subDays(1),
                ]);
            }

            // Workflow logs for p1 (selesai)
            if (isset($p1) && $katimUser) {
                $logs = [
                    ['status' => Permohonan::STATUS_BARU,        'catatan' => 'Permohonan diterima.', 'days' => 50],
                    ['status' => Permohonan::STATUS_VERIFIKASI,   'catatan' => 'Dokumen persyaratan lengkap, permohonan diverifikasi.', 'days' => 48],
                    ['status' => Permohonan::STATUS_PENUGASAN,    'catatan' => 'Tim Advis Teknis I ditugaskan. Deadline: 30 hari kerja.', 'days' => 46],
                    ['status' => Permohonan::STATUS_PEMBAYARAN,   'catatan' => 'Billing PNBP diterbitkan. Kode: AT2024001, Rp 5.000.000', 'days' => 45],
                    ['status' => Permohonan::STATUS_PELAKSANAAN,  'catatan' => 'Pembayaran terverifikasi. Pelaksanaan teknis dimulai.', 'days' => 40],
                    ['status' => Permohonan::STATUS_ANALISIS,     'catatan' => 'Survei lapangan selesai. Analisis data dimulai.', 'days' => 25],
                    ['status' => Permohonan::STATUS_EVALUASI,     'catatan' => 'Draft laporan selesai. Evaluasi internal.', 'days' => 12],
                    ['status' => Permohonan::STATUS_FINALISASI,   'catatan' => 'Laporan final disusun dan ditandatangani.', 'days' => 6],
                    ['status' => Permohonan::STATUS_SELESAI,      'catatan' => 'Dokumen hasil telah diserahkan kepada pemohon.', 'days' => 5],
                ];
                $prevStatus = null;
                foreach ($logs as $log) {
                    WorkflowLog::create([
                        'permohonan_id' => $p1->id,
                        'dari_status'   => $prevStatus,
                        'ke_status'     => $log['status'],
                        'catatan'       => $log['catatan'],
                        'actor_id'      => $katimUser->id,
                        'created_at'    => Carbon::now()->subDays($log['days']),
                        'updated_at'    => Carbon::now()->subDays($log['days']),
                    ]);
                    $prevStatus = $log['status'];
                }

                // Pembayaran for p1
                Pembayaran::create([
                    'permohonan_id' => $p1->id,
                    'kode_billing'  => 'AT2024001',
                    'nominal'       => 5000000,
                    'status'        => Pembayaran::STATUS_SUDAH_BAYAR,
                    'verified_by'   => $katimUser->id,
                    'verified_at'   => Carbon::now()->subDays(40),
                    'created_at'    => Carbon::now()->subDays(45),
                ]);
            }

            // Pembayaran for p2 (pelaksanaan - sudah bayar)
            if (isset($p2) && $katimUser) {
                Pembayaran::create([
                    'permohonan_id' => $p2->id,
                    'kode_billing'  => 'PL2024001',
                    'nominal'       => 3500000,
                    'status'        => Pembayaran::STATUS_SUDAH_BAYAR,
                    'verified_by'   => $katimUser->id,
                    'verified_at'   => Carbon::now()->subDays(8),
                    'created_at'    => Carbon::now()->subDays(12),
                ]);
            }

            // Pembayaran for p4 (menunggu bayar)
            if (isset($p4)) {
                Pembayaran::create([
                    'permohonan_id' => $p4->id,
                    'kode_billing'  => 'PL2024002',
                    'nominal'       => 2750000,
                    'status'        => Pembayaran::STATUS_BELUM_BAYAR,
                    'created_at'    => Carbon::now()->subDays(6),
                ]);
            }
        }

        if (UserStatusLayanan::count() === 0) {
            $statusMap = \App\Models\StatusLayanan::pluck('id', 'name');
            $legacyUser = User::where('email', 'yasir.haq98@gmail.com')->first()
                ?? User::where('email', 'baltekrawa1@gmail.com')->first()
                ?? User::first();

            if ($legacyUser) {
                $legacyStats = [
                    ['layanan' => 'Advis Teknis', 'status' => 'Disetujui', 'detail' => 'Permohonan advis teknis drainase rawa.'],
                    ['layanan' => 'Advis Teknis', 'status' => 'Diproses', 'detail' => 'Kajian teknis pengendalian banjir rawa.'],
                    ['layanan' => 'Advis Teknis', 'status' => 'Selesai', 'detail' => 'Rekomendasi desain sistem polder.'],
                    ['layanan' => 'Pengujian Laboratorium', 'status' => 'Disetujui', 'detail' => 'Pengujian sampel tanah rawa pasang surut.'],
                    ['layanan' => 'Pengujian Laboratorium', 'status' => 'Diproses', 'detail' => 'Pengujian kualitas air rawa untuk SPAM.'],
                    ['layanan' => 'Pengujian Laboratorium', 'status' => 'Selesai', 'detail' => 'Laporan pengujian sedimen rawa.'],
                    ['layanan' => 'Permohonan Data', 'status' => 'Disetujui', 'detail' => 'Permintaan data hidrologi rawa lebak.'],
                    ['layanan' => 'Permohonan Data', 'status' => 'Diproses', 'detail' => 'Kompilasi data topografi kawasan rawa.'],
                    ['layanan' => 'Permohonan Data', 'status' => 'Selesai', 'detail' => 'Pengiriman data pasang surut dan peta tematik.'],
                ];

                foreach ($legacyStats as $row) {
                    $jenis = $jenisLayanan[$row['layanan']] ?? null;
                    $statusId = $statusMap[$row['status']] ?? null;

                    if (!$jenis || !$statusId) {
                        continue;
                    }

                    UserStatusLayanan::firstOrCreate([
                        'user_id' => $legacyUser->id,
                        'status_id' => $statusId,
                        'layanan_id' => $jenis->id,
                        'detail' => $row['detail'],
                    ]);
                }
            }
        }
    }
}
