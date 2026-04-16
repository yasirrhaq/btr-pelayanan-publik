<?php

namespace App\Services;

use App\Models\FormatNomor;
use Illuminate\Support\Facades\DB;

class NomorPermohonanService
{
    public static function generate(int $jenisLayananId): string
    {
        return DB::transaction(function () use ($jenisLayananId) {
            $format = FormatNomor::where('jenis_layanan_id', $jenisLayananId)
                ->lockForUpdate()
                ->first();

            if (!$format) {
                return sprintf('PL-%04d/%d', rand(1, 9999), now()->year);
            }

            $tahun = now()->year;
            if ($format->tahun_counter != $tahun) {
                $format->counter = 0;
                $format->tahun_counter = $tahun;
            }

            $format->counter++;
            $format->save();

            $nomor = str_replace(
                ['{ID}', '{KODE}', '{TAHUN}', '{COUNTER}', '{YYYY}', '{MM}', '{SEQ}'],
                [
                    str_pad($format->counter, 4, '0', STR_PAD_LEFT),
                    $format->kode_layanan ?? 'PL',
                    $tahun,
                    $format->counter,
                    $tahun,
                    now()->format('m'),
                    str_pad($format->counter, 3, '0', STR_PAD_LEFT),
                ],
                $format->template
            );

            return $nomor;
        });
    }
}
