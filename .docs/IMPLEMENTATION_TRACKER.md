# Implementation Tracker — BTR Pelayanan Publik

> Last updated: 2026-04-23

## Legend

| Symbol | Meaning |
|--------|---------|
| :white_check_mark: | Fully implemented |
| :construction: | Partially implemented |
| :x: | Not yet implemented |

---

## Module 1: Portal Publik (Frontend) — 95%

| Feature | Status | Notes |
|---------|--------|-------|
| Beranda + Banner | :white_check_mark: | Tailwind redesign, carousel, stats widget |
| Widget Statistik Real-time (Antri/Proses/Selesai) | :white_check_mark: | HomeController passes statsLayanan |
| Profil Instansi (Visi Misi, Sejarah, Tugas, Struktur, Fasilitas) | :white_check_mark: | Public shell unified; Visi/Misi/Tugas cleaned up; Sejarah split layout with image; Struktur and Info Pegawai simplified |
| Portal Berita & Publikasi | :white_check_mark: | Posts + categories + slugs + redesigned `/berita` and `berita/{slug}` with local image fallback, server-side filtering, and real `lampiran_path` support surfaced on public detail and `/dokumen` |
| Renstra / Publikasi Strategis | :white_check_mark: | Public `/renstra` and `/renstra/{slug}` are live; legacy `karya-ilmiah` URLs remain as compatibility redirects |
| Galeri Foto & Video | :white_check_mark: | Separate pages |
| Footer (Kontak, Lokasi, Links) | :white_check_mark: | FooterSetting model + admin CRUD |
| Pencarian Global | :white_check_mark: | Search form in navbar |
| Tanya Kaura (chatbot/floating button) | :white_check_mark: | Floating widget |
| Tautan Media Sosial | :white_check_mark: | UrlLayanan model |
| Layanan Informasi PPID | :white_check_mark: | Public `/ppid` hub plus `/ppid/kebijakan-ppid`, `/ppid/info-berkala`, `/ppid/info-serta-merta`, and `/ppid/info-setiap-saat` are wired to admin-managed content |
| Renstra / Dokumen Strategis | :white_check_mark: | Public `/dokumen` page now aggregates pengumuman lampiran, galeri dokumen, and real berita lampiran, with old body-link parsing kept as fallback |
| Multilingual (ID/EN auto-translate) | :white_check_mark: | SetLocale + TranslateResponse middleware |

---

## Module 2: Admin Layanan (Manajemen Operasional) — 90%

| Feature | Status | Notes |
|---------|--------|-------|
| Dashboard Analitik (stat cards + per-layanan table) | :white_check_mark: | dashboard.blade.php — 4 stat cards + breakdown table + recent list |
| Permohonan List (filter by status/jenis/search) | :white_check_mark: | index.blade.php with filter toolbar |
| Permohonan Detail + Workflow Controls | :white_check_mark: | show.blade.php — info, dokumen, log, payment, survey, status change, assign tim, billing, upload final |
| **Workflow Engine** | :white_check_mark: | WorkflowService with state machine transitions + WorkflowLog audit |
| **SLA Calculation** | :white_check_mark: | SlaService — hitungHariKerja + hitungDeadline (skip weekends + hari_libur) |
| **Auto Numbering** | :white_check_mark: | NomorPermohonanService — FormatNomor template with row-lock counter |
| **Tim Assignment** | :white_check_mark: | assignTim action — picks katim, calculates deadline |
| **Billing / PNBP** | :white_check_mark: | setBilling action + Pembayaran model |
| **Payment Verification** | :white_check_mark: | verifyPayment (approve/reject) |
| **Dokumen Final Upload** | :white_check_mark: | uploadDokumenFinal route + controller action + form in show.blade.php |
| Sidebar Navigation (matches design) | :white_check_mark: | layanan/layouts/sidebar.blade.php — now permission-aware; management roles see layanan modules, stage roles get a narrowed inbox-style menu |
| Layout + Header (date/time/user) | :white_check_mark: | layanan/layouts/main.blade.php — reuses admin.css + header |
| Manajemen Data Pelanggan | :white_check_mark: | data-pelanggan.blade.php — searchable user list with permohonan counts |
| Survei Kepuasan Analytics (SKM) | :white_check_mark: | survei-analytics.blade.php — stat cards, per-unsur bars, IKM, recent responses |
| Pusat Notifikasi Admin | :x: | Needs admin notification list page (low priority) |

---

## Module 3: Admin Web (CMS) — 95%

| Feature | Status | Notes |
|---------|--------|-------|
| Dashboard Admin Master | :white_check_mark: | Basic dashboard view |
| Manajemen Profil (Identitas, Sejarah, Visi Misi) | :white_check_mark: | `/dashboard/profil-singkat` rebuilt into tabbed flow for Tentang Kami, Sejarah, Visi & Misi, Tugas & Fungsi, Maskot using Jodit and shared public data sources |
| Manajemen SDM (Info Pegawai) | :white_check_mark: | Full CRUD + structured employee fields + urutan sorting + photo remove support + seeded roster |
| Manajemen Fasilitas | :white_check_mark: | Full CRUD |
| Manajemen Struktur Organisasi | :white_check_mark: | Full CRUD |
| Manajemen Banner / Foto Home | :white_check_mark: | Edit + update |
| Manajemen Berita | :white_check_mark: | Full CRUD with slugs + Jodit editor on create/edit |
| Manajemen Galeri Foto/Video | :white_check_mark: | Full CRUD |
| Manajemen Pengumuman | :white_check_mark: | PengumumanController — full CRUD with lampiran file upload |
| Manajemen PPID (4 kategori informasi) | :white_check_mark: | Tabbed PPID admin page with Jodit editor, upload handling, and landing-page-backed content |
| Manajemen Dokumen Layanan (Standar/Maklumat PDF) | :construction: | Uses LandingPage model, no dedicated upload center |
| Manajemen Renstra | :white_check_mark: | Repurposed Karya Ilmiah as Renstra in sidebar |
| Kop Surat & Identitas Web | :construction: | FooterSetting exists, no letterhead |
| Manajemen Akun (RBAC) | :white_check_mark: | HakAksesController — list users, filter by role, assign/sync roles, create admin accounts, manage module-level access, direct per-user permissions, and active/inactive status |
| Sidebar Navigation (matches design) | :white_check_mark: | Updated with PPID, Pengumuman, Hak Akses, Master Tim, Master Survei, grouped Layanan, split profile submenu, real BTR logo |
| Master Tim | :white_check_mark: | MasterTimController — full CRUD with dynamic anggota form |
| Master Format Nomor | :construction: | Model + service exist, no admin config page (uses seeder) |
| Master Survei (9 unsur) | :white_check_mark: | MasterSurveiController — inline add/edit/toggle/delete |

---

## Module 4: Portal Pelanggan (Self-Service) — 95%

| Feature | Status | Notes |
|---------|--------|-------|
| Layout + Sidebar (matches design) | :white_check_mark: | pelanggan shell now follows the newer admin visual language while keeping pelanggan-specific navigation and routes |
| Dashboard Pelanggan (ringkasan status) | :white_check_mark: | Welcome card, 4 stat cards, active table, survey invitation |
| E-Service Wizard (4 langkah) | :white_check_mark: | permohonan/create.blade.php — JS wizard, service cards, data confirm, detail+upload |
| - Langkah 1: Pilih Layanan | :white_check_mark: | Radio card grid with icons |
| - Langkah 2: Konfirmasi Data Profil | :white_check_mark: | dl list with BENAR/EDIT buttons |
| - Langkah 3: Detail Teknis + Upload | :white_check_mark: | Textarea + dual file upload + checkboxes |
| - Langkah 4: Finalisasi | :white_check_mark: | Success page shown via redirect |
| Permohonan List | :white_check_mark: | permohonan/index.blade.php — table + pagination |
| Permohonan Detail | :white_check_mark: | permohonan/show.blade.php — info, progress bar, timeline, dokumen, payment, final docs |
| Tracking System (timeline + progress bar) | :white_check_mark: | tracking/index.blade.php — search by nomor PL, timeline + progress |
| Pembayaran List | :white_check_mark: | pembayaran/index.blade.php — table of all tagihan |
| Pembayaran Detail + Upload Bukti | :white_check_mark: | pembayaran/show.blade.php — billing info, upload form, PNBP info |
| Dokumen Hasil (gated by survei) | :white_check_mark: | dokumen/index.blade.php — tab panel, view/download actions |
| Notifikasi (list + mark read) | :white_check_mark: | notifikasi/index.blade.php — card list, mark all read, badge count in sidebar |
| Survei Kepuasan (9-unsur form) | :white_check_mark: | survei/create.blade.php — radio groups, saran textarea |
| Profil Pelanggan | :white_check_mark: | profil/index.blade.php — info table, change password link |
| Bantuan / FAQ | :white_check_mark: | bantuan/index.blade.php — collapsible FAQ |
| Routes registered | :white_check_mark: | routes/web.php — pelanggan group restored and key pelanggan routes now load successfully in live browser checks |

---

## Cross-Cutting Concerns

| Feature | Status | Notes |
|---------|--------|-------|
| **RBAC (spatie/laravel-permission)** | :white_check_mark: | 9 roles, 27 permissions seeded. Admin UI covers role assignment, module-level access, direct per-user permissions, and active/inactive state; route middleware now blocks editor/admin-layanan cross-area leaks and hides management-only layanan menus from stage roles. |
| **Workflow Engine** | :white_check_mark: | WorkflowService — validates transitions, logs, notifies |
| **SLA Calculation (hari kerja)** | :white_check_mark: | SlaService + hari_libur table |
| **Auto Numbering (Format Nomor)** | :white_check_mark: | NomorPermohonanService with row-lock counter |
| **Database Schema (15 tables)** | :white_check_mark: | Migration for all layanan workflow tables |
| **Models (14+ new)** | :white_check_mark: | All with relationships + guarded |
| **Survey Gatekeeper** | :white_check_mark: | DokumenFinal.is_downloadable unlocked after survey completion |
| **WhatsApp Business API** | :x: | No integration (optional enhancement) |
| **Email Notifications (beyond verification)** | :x: | Only signup email (optional enhancement) |
| **Real-time Updates** | :x: | No broadcasting (optional enhancement) |
| **File Security (signed URLs)** | :x: | No signed downloads (optional enhancement) |
| **Captcha (Login + Register)** | :white_check_mark: | mews/captcha flat style |
| **Rate Limiting (Auth routes)** | :white_check_mark: | throttle:10,1 and 5,1 |
| **CSRF Protection** | :white_check_mark: | Standard Laravel |
| **Multi-language** | :white_check_mark: | TranslateResponse middleware |

---

## Files Created / Modified This Session

### Layouts & CSS
- `resources/views/pelanggan/layouts/main.blade.php` — Pelanggan portal layout
- `resources/views/pelanggan/layouts/sidebar.blade.php` — Pelanggan sidebar (matches design)
- `resources/views/pelanggan/layouts/header.blade.php` — Pelanggan top bar (date, time, user)
- `resources/views/dashboard/layanan/layouts/main.blade.php` — Admin Layanan layout
- `resources/views/dashboard/layanan/layouts/sidebar.blade.php` — Admin Layanan sidebar (matches design)
- `public/css/pelanggan.css` — Complete CSS for pelanggan portal (wizard, timeline, upload, notif, survey, etc.)

### Pelanggan Portal Views (8 views)
- `resources/views/pelanggan/dashboard.blade.php`
- `resources/views/pelanggan/permohonan/index.blade.php`
- `resources/views/pelanggan/permohonan/create.blade.php` — 4-step wizard
- `resources/views/pelanggan/permohonan/show.blade.php` — Detail + timeline
- `resources/views/pelanggan/tracking/index.blade.php` — Search + timeline
- `resources/views/pelanggan/pembayaran/index.blade.php`
- `resources/views/pelanggan/pembayaran/show.blade.php` — Upload bukti bayar
- `resources/views/pelanggan/dokumen/index.blade.php`
- `resources/views/pelanggan/notifikasi/index.blade.php`
- `resources/views/pelanggan/survei/create.blade.php` — 9-unsur form
- `resources/views/pelanggan/profil/index.blade.php`
- `resources/views/pelanggan/bantuan/index.blade.php` — FAQ

### Admin Layanan Views (4 views)
- `resources/views/dashboard/layanan/dashboard.blade.php` — Stat cards + tables
- `resources/views/dashboard/layanan/index.blade.php` — Permohonan list with filters
- `resources/views/dashboard/layanan/show.blade.php` — Detail + workflow controls
- `resources/views/dashboard/layanan/data-pelanggan.blade.php` — Customer list
- `resources/views/dashboard/layanan/survei-analytics.blade.php` — SKM analytics

### Admin Web Enhancement Views (8 views)
- `resources/views/dashboard/hak-akses/index.blade.php` — User role management
- `resources/views/dashboard/hak-akses/edit.blade.php` — Assign roles to user
- `resources/views/dashboard/master-tim/index.blade.php` — Tim list
- `resources/views/dashboard/master-tim/create.blade.php` — Create tim + anggota
- `resources/views/dashboard/master-tim/edit.blade.php` — Edit tim + anggota
- `resources/views/dashboard/master-survei/index.blade.php` — Inline survei config
- `resources/views/dashboard/pengumuman/index.blade.php` — Pengumuman list
- `resources/views/dashboard/pengumuman/create.blade.php` — Create pengumuman
- `resources/views/dashboard/pengumuman/edit.blade.php` — Edit pengumuman
- `resources/views/dashboard/ppid/index.blade.php` — PPID 4-category page

### Controllers (4 new)
- `app/Http/Controllers/Admin/HakAksesController.php`
- `app/Http/Controllers/Admin/MasterTimController.php`
- `app/Http/Controllers/Admin/MasterSurveiController.php`
- `app/Http/Controllers/Admin/PengumumanController.php`

### Modified
- `app/Http/Controllers/Admin/Layanan/PermohonanManagementController.php` — Added uploadDokumenFinal, dataPelanggan, surveiAnalytics
- `app/Http/Controllers/PostController.php` — Server-side berita list filtering + pagination (4 per page)
- `resources/views/dashboard/layouts/sidebar.blade.php` — Added PPID, Pengumuman, Master Tim, Master Survei, Hak Akses, grouped Layanan, split Profil submenu, correct BTR logo icon
- `resources/views/berita/index.blade.php` — Rebuilt berita listing page on unified public shell
- `resources/views/frontend/beritaDetail.blade.php` — Rebuilt berita detail page
- `resources/views/frontend/sejarah.blade.php` — Dedicated split layout with image
- `resources/views/frontend/visimisi.blade.php` — Text-only polished layout
- `resources/views/frontend/tugas.blade.php` — Text-only polished layout
- `resources/views/frontend/struktur.blade.php` — Simplified image-first layout
- `resources/views/frontend/info-pegawai.blade.php` — Structured employee card layout with initials fallback and `urutan`-based ordering
- `resources/views/frontend/fasilitas-balai.blade.php` — Responsive card layout with fallback images
- `resources/views/frontend/advis-teknis.blade.php` — Responsive service layout with fallback image
- `resources/views/frontend/pengujian-laboratorium.blade.php` — Responsive service layout with fallback image
- `resources/views/frontend/layouts/landing-page-content.blade.php` — Modernized shared profile content layout
- `resources/views/frontend/partials/headerTailwind.blade.php` — Grouped public menu with hover flyouts for subsubmenu
- `resources/views/frontend/dokumen.blade.php` — Public document center with preview/download cards
- `app/Http/Controllers/PublicDokumenController.php` — Aggregates public document sources
- `resources/views/frontend/partials/footerTailwind.blade.php` — Explicit footer text colors
- `routes/web.php` — Added all pelanggan + admin layanan + admin web routes
- `resources/views/pelanggan/layouts/main.blade.php` — Updated pelanggan shell interactions
- `resources/views/pelanggan/layouts/sidebar.blade.php` — Updated pelanggan sidebar logo + logout style
- `resources/views/pelanggan/layouts/header.blade.php` — Added pelanggan profile dropdown
- `public/css/pelanggan.css` — Aligned pelanggan shell styling with current admin design language
- `database/seeders/KontenWebSeeder.php` — Added local image defaults + seeded 5 berita posts
- `app/Helper.php` — Local fallback image resolution for public assets

---

## Remaining Work (Nice-to-Have)

| Priority | Feature | Notes |
|----------|---------|-------|
| Low | Admin Notification Center | Admin-facing notification list page |
| Low | Master Format Nomor UI | Admin CRUD for numbering templates (currently seed-based) |
| Low | Chart.js Dashboard | Visual charts for admin dashboards |
| Optional | WhatsApp Integration | WhatsApp Business API for notifications |
| Optional | Email Notifications | Beyond verification emails |
| Optional | Signed Download URLs | Extra file security |

---

## Existing Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 8 (PHP ^7.2/^8.x) |
| Database | MySQL (`pupr`) |
| Frontend | Tailwind CDN + Alpine.js + Bootstrap 5 + custom CSS |
| Auth | Session-based, email verification |
| Assets | Vite 3 |
| RBAC | spatie/laravel-permission v5 |
| Captcha | mews/captcha |
| Translation | stichoza/google-translate-php |
| Image | intervention/image |
| Slugs | cviebrock/eloquent-sluggable |
| Debug | itsgoingd/clockwork |
| Container | Docker (PHP-FPM + Nginx + MySQL) |
