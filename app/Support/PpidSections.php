<?php

namespace App\Support;

class PpidSections
{
    public const MAP = [
        'kebijakan-ppid' => [
            'label' => 'Kebijakan PPID',
            'type_title' => 'Kebijakan PPID',
            'public_eyebrow' => 'Keterbukaan Informasi',
            'public_summary' => 'Kebijakan dasar, tata kelola, dan pijakan layanan informasi publik Balai Teknik Rawa.',
            'public_accent' => 'from-[#354776] to-[#49639d]',
            'public_icon' => 'fa-scale-balanced',
            'badge' => 'PPID',
        ],
        'info-berkala' => [
            'label' => 'Info Berkala',
            'type_title' => 'Informasi Berkala',
            'aliases' => ['Info Berkala'],
            'public_eyebrow' => 'Publikasi Rutin',
            'public_summary' => 'Informasi yang diperbarui secara periodik agar publik dapat memantau layanan dan kinerja.',
            'public_accent' => 'from-[#354776] to-[#5c7dc3]',
            'public_icon' => 'fa-calendar-days',
            'badge' => 'Informasi Publik',
        ],
        'info-serta-merta' => [
            'label' => 'Info Serta Merta',
            'type_title' => 'Informasi Serta Merta',
            'aliases' => ['Info Serta Merta'],
            'public_eyebrow' => 'Informasi Mendesak',
            'public_summary' => 'Informasi yang wajib segera diumumkan saat berdampak langsung pada kepentingan masyarakat.',
            'public_accent' => 'from-[#355c76] to-[#3f8fa6]',
            'public_icon' => 'fa-bolt',
            'badge' => 'Informasi Publik',
        ],
        'info-setiap-saat' => [
            'label' => 'Info Setiap Saat',
            'type_title' => 'Informasi Setiap Saat',
            'aliases' => ['Info Setiap Saat'],
            'public_eyebrow' => 'Akses Sesuai Permintaan',
            'public_summary' => 'Informasi yang tersedia setiap saat dan dapat diminta sesuai mekanisme layanan informasi.',
            'public_accent' => 'from-[#35576a] to-[#4a8e8d]',
            'public_icon' => 'fa-folder-open',
            'badge' => 'Informasi Publik',
        ],
    ];

    public static function all(): array
    {
        return self::MAP;
    }

    public static function typeTitles(): array
    {
        return array_map(fn ($section) => $section['type_title'], self::MAP);
    }

    public static function aliasesFor(string $key): array
    {
        $section = self::MAP[$key] ?? null;
        if (!$section) {
            return [];
        }

        return array_values(array_unique(array_filter(array_merge(
            [$section['type_title']],
            $section['aliases'] ?? []
        ))));
    }
}
