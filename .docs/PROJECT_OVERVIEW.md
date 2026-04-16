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
