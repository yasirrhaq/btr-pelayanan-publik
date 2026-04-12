# Product Requirements Document (PRD)
## BTR Pelayanan Publik — Balai Teknik Rawa Public Services Portal

**Version**: 1.0  
**Date**: 2026-04-11  
**Status**: Observed / Reverse-Engineered from Codebase  

---

## 1. Product Overview

**BTR Pelayanan Publik** is a government public services web portal for **Balai Teknik Rawa (BTR)** — an Indonesian technical office under the Ministry of Public Works (PUPR) specializing in swamp/rawa engineering. The system serves as both a public information hub and an administrative back-office for managing content and service requests.

### Target Users

| Role | Description |
|------|-------------|
| **Public Visitor** | General public seeking information about BTR, services, news, and documents |
| **Registered User** | Verified account holders who can submit and track service requests |
| **Admin** | Staff members managing all website content and service data |

---

## 2. Goals & Objectives

- Provide a centralized digital presence for BTR's public information
- Allow citizens to track and request technical advisory services (advis teknis) and lab testing (pengujian laboratorium)
- Enable non-technical admin staff to manage website content via a dashboard
- Maintain transparency by publishing organizational information, scientific works, and employee data

---

## 3. Feature Requirements

### 3.1 Public Information Pages

| Page | Description |
|------|-------------|
| **Home** | Featured news, photos, quick access to services and related sites |
| **Berita (News)** | Paginated news articles with category filtering and AJAX search |
| **Visi & Misi** | Organization vision and mission |
| **Tugas & Fungsi** | Duties and functions of the office |
| **Sejarah** | History of BTR |
| **Struktur Organisasi** | Organizational chart |
| **Info Pegawai** | Employee directory |
| **Fasilitas Balai** | Facilities and equipment listing |
| **Karya Ilmiah** | Published scientific works/papers with detail pages |
| **Galeri Foto & Video** | Media gallery for photos and videos |
| **Kategori** | Browse news by category |
| **Situs Terkait** | Links to related government/partner sites |

### 3.2 Technical Services

| Service | Description |
|---------|-------------|
| **Pengujian Laboratorium** | Laboratory testing service — information and request |
| **Advis Teknis** | Technical advisory service — information and request |

Each service has a dedicated URL managed by admin via `url_layanan` table, enabling flexible routing to external or internal service pages.

### 3.3 User Authentication & Account Management

- **Registration**: Email + password with automatic verification email (Gmail SMTP)
- **Email Verification**: Token-based, user receives link via email; `is_verified` flag set on confirmation
- **Login**: Standard email/password; blocked if email not verified
- **Forgot Password**: Reset flow via email link
- **Profile Management**: Update personal information and change password (must confirm current password)

### 3.4 Service Request Tracking (Registered Users)

- Authenticated and verified users can submit service requests (`StatusLayanan`)
- Users track the status of their submitted requests via `/profile` area
- Each request links a `User` to a `JenisLayanan` (service type) via `UserStatusLayanan`

### 3.5 Admin Dashboard (`/dashboard`)

All admin routes are protected by `is_admin == 1` on the user record.

#### Content Management

| Module | Capabilities |
|--------|-------------|
| **Posts / Berita** | Create, edit, delete news articles; auto-slug generation; category assignment |
| **Categories** | CRUD for news categories with auto-slug |
| **Karya Ilmiah** | CRUD for scientific works; image upload; language field (Indonesian/English) |
| **Galeri Foto & Video** | Upload and manage photo/video gallery items |
| **Foto Home** | Manage featured images shown on homepage |
| **Foto Layanan** | Manage service-specific images |
| **Info Pegawai** | CRUD for employee directory entries |
| **Fasilitas Balai** | CRUD for facility/equipment listings |
| **Struktur Organisasi** | Manage org chart data |
| **Situs Terkait** | Manage external related site links |
| **Profil Singkat** | Edit brief office profile content |
| **Footer Setting** | Configure footer content (contact info, social links, etc.) |
| **Settings** | General application settings |

#### Service Management

| Module | Capabilities |
|--------|-------------|
| **URL Layanan** | Edit/update URLs and descriptions for each service type |
| **Status Layanan** | View and manage incoming service requests from users |
| **Landing Page** | CMS for dynamic landing pages with type classification; soft delete; audit trail (created_by / updated_by) |

---

## 4. System Architecture

### Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP ^7.2, Laravel 8 |
| **Frontend** | Blade templates, Vite (JS/CSS bundler) |
| **Database** | MySQL (database: `pupr`) |
| **Auth** | Laravel built-in + Laravel Sanctum (API) |
| **Image Processing** | Intervention/Image v2 |
| **HTTP Client** | Guzzle v7 |
| **API Auth** | Laravel Sanctum |
| **Profiling (dev)** | Clockwork v5 |

### Key Patterns

- **Route Model Binding**: Post and KaryaIlmiah resolved by slug (e.g., `/berita/{post:slug}`)
- **Sluggable**: Automatic slug generation on `Post`, `Category`, `KaryaIlmiah` via `cviebrock/eloquent-sluggable`
- **Soft Deletes**: Used on `LandingPage` to preserve data on deletion
- **Audit Trail**: `LandingPage` records `created_by` and `updated_by` user IDs
- **HTTPS Enforcement**: App forces HTTPS in production via `AppServiceProvider`
- **Pagination**: Bootstrap 5 style

---

## 5. Data Model Summary

```
users
  └── userStatusLayanan[] → status_layanan (service requests)

posts → categories (many-to-one)

karya_ilmiah (scientific works, with image + language)

url_layanan (service URLs per service type)
jenis_layanan (service type catalog)

galeri_foto
foto_home
foto_layanan

info_pegawai
fasilitas_balai
struktur_organisasi

landing_page → landing_page_tipe (soft deleted, audit trail)
situs_terkait
footer_settings
```

---

## 6. Non-Functional Requirements (Observed)

| Concern | Implementation |
|---------|---------------|
| **Locale** | Indonesian (`id_ID` faker locale, UI in Bahasa Indonesia) |
| **Email** | Gmail SMTP via environment config |
| **File Storage** | Laravel public disk; `storage:link` required after deploy |
| **Image Fallback** | `imageExists()` helper falls back to Unsplash placeholder if image missing |
| **DB Compatibility** | Default string length set to 191 for older MySQL/MariaDB |
| **Security** | CSRF on all forms, middleware-gated admin, email verification gate |

---

## 7. Out of Scope (Not Implemented)

- **API endpoints**: Sanctum is configured but no API routes are defined beyond the default stub
- **Real-time features**: Broadcasting is configured but no event listeners are defined
- **Scheduled jobs**: No artisan scheduled commands defined
- **Search**: Only AJAX search on berita page; no global site search

---

## 8. Deployment Notes

1. Copy `.env.example` → `.env`, set `APP_KEY`, database credentials (`DB_DATABASE=pupr`), and Gmail SMTP credentials
2. Run `composer install && npm install && npm run build`
3. Run `php artisan migrate --seed`
4. Run `php artisan storage:link`
5. Ensure the first admin user has `is_admin = 1` set directly in the database
6. HTTPS must be configured at the server level; `APP_ENV=production` triggers HTTPS URL forcing

---

*This PRD was reverse-engineered from source code analysis. Feature descriptions reflect implemented behavior as observed in routes, controllers, models, and migrations.*

---

## 9. Admin Dashboard Redesign Requirements

**Source**: `design/Admin Web/Hal Admin Web fix_pages-to-jpg-0001..0028.jpg`
**Status**: MANDATORY — follow mockups exactly
**Goal**: Replace current admin UI. Current admin looks unprofessional. Polish to match provided design.

### 9.1 Global Layout

Full-height app shell. Two-column layout.

| Region | Specification |
|--------|---------------|
| **Sidebar** | Fixed left, dark navy background, ~260px width, full height |
| **Top bar** | Thin white strip, contains date+time (left), admin profile (right) |
| **Content** | Light gray (#F5F5F7) background, white rounded cards, generous padding |

### 9.2 Color Palette

| Token | Hex | Usage |
|-------|-----|-------|
| `--sidebar-bg` | `#1E3A6B` | Sidebar background, primary buttons |
| `--accent-yellow` | `#FDC300` | Active menu highlight, logo mark, tab inactive |
| `--content-bg` | `#F5F5F7` | Main content background |
| `--card-bg` | `#FFFFFF` | Card surfaces |
| `--text-primary` | `#1E3A6B` | Headings, table headers |
| `--text-muted` | `#6B7280` | Secondary text |
| `--danger-red` | `#DC2626` | Delete action icons |
| `--info-blue` | `#2563EB` | Edit action icons |
| `--success-green` | `#10B981` | View/preview action icons |
| **Stat card colors** | blue, pink, cyan, yellow, gray | Dashboard metric cards |

### 9.3 Sidebar Menu (New Structure)

Menu groups collapsed under parent with `>` indicator for children. Active item shown as full-width yellow bar with navy text.

```
BALAI TEKNIK RAWA (logo)

 Dashboard
 Profil
   > Identitas
   > SDM
   > Fasilitas
 Layanan
 Publikasi
   > Banner
   > Berita
   > Galeri
   > Pengumuman
   > Renstra
   > PPID
 Tautan
 Pengaturan
   > Hak Akses
   > Sistem

 Logout
```

Logout pinned bottom with power icon.

### 9.4 Top Bar

- Left: calendar icon + date (`09 Maret 2026`), clock icon + time (`10:44:02`)
- Right: admin name + role subtitle (`Iswatunnisa / Admin Master`) + circular avatar

### 9.5 Page Specifications

#### Dashboard (`0001`)
- Heading `DASHBOARD`
- Mascot illustration card (top-left)
- Stat cards grid (5 metrics): Total Admin Web (blue), Total Admin Layanan (pink), Total Berita (cyan), Total Pengumuman (yellow), Total Galeri (gray)
- Line chart card: `Grafik Pengunjung Situs Web Balai Teknik Rawa` with year dropdown and total visitor count

#### Profil - Identitas (`0002-0006`)
- Yellow tab bar: `Tentang Kami | Sejarah | Visi & Misi | Tugas & Fungsi | Maskot`
- Tab content: WYSIWYG rich text editor (bold, italic, strike, link, headings, quote, code, list) + file upload row + SUBMIT button
- Visi & Misi + Tugas & Fungsi use table layout: `Gambar | Deskripsi | Status | Aksi`

#### Profil - SDM (`0007-0008`)
- Tabs: `Struktur Organisasi | Pegawai`
- Struktur: upload image + inline SUBMIT + preview panel
- Pegawai: `(+) Pegawai` button, search box, table `No | Foto | Nama Pegawai | Jabatan | Golongan | Status (PNS/PPPK) | Aksi`

#### Profil - Fasilitas (`0009`)
- `(+) Fasilitas` button + search
- Table: `No | Foto | Nama Fasilitas | Deskripsi | Status (Publish/Draft) | Aksi`

#### Layanan (`0010-0014`)
- Tabs: `Advis Teknik | Laboratorium | Permohonan Data | Maklumat | Standart Pelayanan`
- WYSIWYG + file upload pattern
- Maklumat + Standart Pelayanan use image/PDF preview pane

#### Publikasi - Banner (`0015`)
- Note banner (pink icon): `Gunakan halaman ini untuk mengelola foto slider di Beranda. Ukuran 1920 x 600 px (maks. 1 MB)`
- `(+) Foto Banner` button
- Table: `No | Gambar | Judul | Deskripsi | Status | Aksi`

#### Publikasi - Berita (`0016`)
- Buttons: `(+) Buat Berita`, `(+) Kategori Berita`, search
- Table: `No | Judul | Kategori | Tanggal Kegiatan | Status | Aksi`

#### Publikasi - Galeri (`0017-0019`)
- Tabs: `Foto | Video | Dokumen`
- Foto/Video: card grid (3 cols × 2 rows), each card shows date, thumbnail, judul, deskripsi, action icons
- Dokumen: table `No | Judul | Jenis | Ukuran | Tanggal | Status | Aksi`

#### Publikasi - Pengumuman (`0020`)
- `(+) Pengumuman` + search
- Table: `No | Judul | Deskripsi | Tanggal | Status | Aksi`

#### Publikasi - Renstra (`0021`)
- `(+) Renstra` + search
- Table: `No | Judul | Tahun | Status | Aksi` (with download icon)

#### Publikasi - PPID (`0022-0025`)
- Tabs: `Kebijakan PPID | Info Berkala | Info Serta Merta | Info Setiap Saat`
- Kebijakan PPID: `Judul` input + `Isi Kebijakan` textarea + `Unggah Dokumen` + SUBMIT
- Others: WYSIWYG editor + SIMPAN button

#### Tautan (`0026`)
- `(+) Tautan` + search
- Table: `Nama Tautan | Kategori | URL | Logo | Status | Aksi`
- Kategori values: `Sosial Media`, `Situs Terkait`, `Link Fitur Menu`, `Laporan Pengaduan`

#### Pengaturan - Hak Akses (`0027`)
- Note banner: `Gunakan halaman ini untuk mengelola akun admin dan kewenangan dalam mengelola web Balai Teknik Rawa`
- `(+) Buat Akun` + search
- Table: `No | Nama | Username | Hak Akses | Status | Aksi`
- Roles: `Admin Master`, `Admin Web - Editor`, `Admin Web - Kelola`, `Admin Layanan - Lab`, `Admin Layanan - Advis`, `Admin Layanan - Data`

#### Pengaturan - Sistem (`0028`)
- Collapsible sections: `Header`, `Footer`
- Header table: `Keterangan | Upload Data | Status | Aksi` (rows: Kop Balai)
- Footer table: rows for `No. Telp`, `No. Wa`, `Email`, `Alamat`, `Embed Gmaps`, `Copyright Text`
- SUBMIT button bottom-right

### 9.6 Component Specs

| Component | Rules |
|-----------|-------|
| **Cards** | White bg, `border-radius: 12px`, soft shadow, 24px padding |
| **Tables** | Header row navy text on white, centered cells, thin gray borders, rounded outer corners |
| **Primary button** | Navy bg, white text, pill shape (`border-radius: 999px`), icon prefix for `(+)` actions |
| **Tabs** | Yellow inactive, white active, bottom-attached to content card |
| **Action icons** | Red trash, blue pencil, green eye — inline in `Aksi` column |
| **Search** | Rounded pill input with magnifier icon on right |
| **Status pills** | Text-only: `Publish`, `Draft`, `Aktif`, `Tidak Aktif` (no badge bg per mockup) |
| **WYSIWYG** | Toolbar: B, I, S, link, headings, quote, code, bullet list, ordered list |
| **File upload** | Pill-shaped field, navy circular upload icon on left, filename text, optional SUBMIT inline |

### 9.7 Scope Expansion (New Features Implied by Design)

Mockups introduce modules not in current codebase. Treat as new requirements:

| New Module | Notes |
|------------|-------|
| **Maskot** | New tab under Profil/Identitas — WYSIWYG + image upload |
| **Pengumuman** | New publication type separate from Berita |
| **Renstra** | Strategic plan docs with year field |
| **PPID** | Four-tab public info disclosure module |
| **Banner slider** | Homepage slider management (1920×600, max 1MB) |
| **Dokumen gallery** | Third tab alongside Foto/Video |
| **Tautan categorization** | Add `kategori` field: Sosial Media / Situs Terkait / Link Fitur / Laporan Pengaduan |
| **Role-based Hak Akses** | Expand beyond `is_admin` flag — six roles listed above |
| **Admin Layanan roles** | Split admin responsibilities: Lab, Advis, Data |
| **Permohonan Data tab** | New sub-service under Layanan |
| **Maklumat Pelayanan** | File upload module under Layanan |
| **Standart Pelayanan** | PDF upload module under Layanan |
| **Dashboard visitor chart** | Monthly visitor line chart with year filter |
| **Dashboard stat cards** | Five metric counters |
| **Header/Footer CMS** | Pengaturan-Sistem replaces current footer_settings with structured table |

### 9.8 Implementation Priority

1. Global shell: sidebar + top bar + color tokens + card styles
2. Dashboard layout with stat cards + chart
3. Refactor existing CRUD pages to new table style
4. Build new modules (Pengumuman, Renstra, PPID, Maskot, Banner slider)
5. Expand role system beyond `is_admin`
6. Migrate footer_settings into Pengaturan-Sistem structure

### 9.9 Fidelity Rule

Match mockups pixel-close where possible. No deviation on: sidebar color, yellow accent, tab pattern, table header style, action icon colors, button shape. Typography: sans-serif (Inter or Poppins). Icons: Lucide or Feather set.
