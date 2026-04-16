<?php

namespace App\Services;

use App\Models\HariLibur;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlaService
{
    public static function hitungHariKerja(Carbon $mulai, Carbon $selesai): int
    {
        $libur = HariLibur::whereBetween('tanggal', [$mulai, $selesai])
            ->pluck('tanggal')
            ->map(fn ($d) => $d->format('Y-m-d'))
            ->toArray();

        $hariKerja = 0;
        $period = CarbonPeriod::create($mulai, $selesai);

        foreach ($period as $date) {
            if ($date->isWeekend()) {
                continue;
            }
            if (in_array($date->format('Y-m-d'), $libur, true)) {
                continue;
            }
            $hariKerja++;
        }

        return $hariKerja;
    }

    public static function hitungDeadline(Carbon $mulai, int $jumlahHariKerja): Carbon
    {
        $liburList = HariLibur::where('tanggal', '>=', $mulai)
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->map(fn ($d) => $d->format('Y-m-d'))
            ->toArray();

        $counted = 0;
        $current = $mulai->copy();

        while ($counted < $jumlahHariKerja) {
            $current->addDay();
            if ($current->isWeekend()) {
                continue;
            }
            if (in_array($current->format('Y-m-d'), $liburList, true)) {
                continue;
            }
            $counted++;
        }

        return $current;
    }
}
