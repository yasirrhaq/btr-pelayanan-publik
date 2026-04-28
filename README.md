# BTR Pelayanan Publik

Aplikasi web portal pelayanan publik untuk **Balai Teknik Rawa (BTR)**, unit di bawah Direktorat Jenderal Sumber Daya Air, Kementerian Pekerjaan Umum.

## Tentang Aplikasi

Portal ini menyediakan akses informasi dan layanan publik dari Balai Teknik Rawa, meliputi:

- Berita dan informasi terkini
- Karya ilmiah dan publikasi teknis
- Galeri foto dan video kegiatan
- Profil organisasi dan struktur pegawai
- Fasilitas balai
- Layanan pengujian laboratorium dan advis teknis
- Pelacakan status layanan bagi pengguna terdaftar

## Teknologi

- **Backend:** Laravel 8, PHP 8.2, MySQL
- **Frontend:** Tailwind CSS, Alpine.js, Bootstrap 5
- **Build Tool:** Vite 3

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

## Struktur Dokumentasi

- `docs/plans/` untuk design doc dan rencana implementasi.
- `docs/implementation/` untuk ringkasan fitur yang sudah dibangun.
- `docs/testing/` untuk hasil QA, audit, dan bukti pengujian.
- `docs/architecture/` untuk referensi struktur sistem, role, dan overview teknis.
- `docs/operations/` untuk workflow internal repo, tracker, memory, dan handoff session.

## Lisensi

Hak cipta © Balai Teknik Rawa. Seluruh hak dilindungi.
