# Architecture — BTR Pelayanan Publik

## Overview

Public services portal for **Balai Teknik Rawa** (Rawa Engineering Office), a unit under Kementerian Pekerjaan Umum. Handles news publishing, scientific works, gallery, service status tracking, and employee info.

- Language: **Indonesian (id_ID)**
- Pattern: **Server-Side Rendering (SSR)** via Laravel Blade
- No SPA, no API-first — full round-trip HTML responses

---

## Backend Stack

| Component | Version | Notes |
|---|---|---|
| PHP | ^7.2 / 8.2 runtime | Tested on 8.2 |
| Laravel | ^8.0 | Framework core |
| MySQL | 8.0 | DB name: `pupr` |
| Laravel Sanctum | ^2.15 | Installed but unused (no API currently) |
| Eloquent ORM | (Laravel built-in) | All DB access |
| Guzzle HTTP | ^7.2 | HTTP client |
| Intervention Image | ^2.7 | Image resizing/upload |
| Eloquent Sluggable | ^8.0 (cviebrock) | Auto-slug for Post, Category, KaryaIlmiah |
| Laravel Helpers | ^1.5 | `Str::`, `Arr::` etc. via `laravel/helpers` |
| Laravel Tinker | ^2.7 | REPL debugging |
| Clockwork | ^5.1 | Dev profiler |
| Faker | ^1.9.1 (id_ID locale) | Seeders |
| PHPUnit | ^9.5.10 | Tests |
| Laravel Sail | ^1.0.1 | Docker dev environment |

**Mail:** Gmail SMTP via `SignupEmail` Mailable — sends email verification link on register.

**Queue:** Not explicitly configured beyond default `sync` driver. Mail is sent synchronously.

**Storage:** `php artisan storage:link` — uploaded images served from `storage/app/public`.

---

## Frontend Stack

Two separate layout systems coexist:

### Modern Layout — `mainTailwind.blade.php`
Used by: homepage (`home.blade.php`)

| Library | Source | Version |
|---|---|---|
| Tailwind CSS | CDN (`cdn.tailwindcss.com`) | Latest CDN |
| Alpine.js | CDN (`unpkg.com/alpinejs`) | 3.x |
| Font Awesome | CDN (`cdnjs.cloudflare.com`) | 6.5.0 |
| Google Fonts Inter | CDN | 400/500/600/700 |

Custom Tailwind config (inline):
```js
colors: { btr: '#354776', 'btr-dark': '#2a3a61', 'btr-yellow': '#F5A623' }
fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
```

Interactivity via Alpine.js `x-data` / `@click` / `x-show` / `@click.away` / `x-cloak`.
CSS hover dropdowns via `.nav-item:hover .nav-dropdown { display: block }`.

### Legacy Layout — `mainNew.blade.php`
Used by: admin panel, most other frontend pages

| Library | Source | Version |
|---|---|---|
| Bootstrap | CDN or Vite | 5.2 |
| jQuery | CDN | 3.x |
| Font Awesome | CDN | (various) |

### Build Tool — Vite

| Package | Version |
|---|---|
| vite | ^3.0.0 |
| laravel-vite-plugin | ^0.6.0 |
| axios | ^0.27 |
| lodash | ^4.17.19 |
| postcss | ^8.1.14 |

Entry points: `resources/js/app.js`, `resources/css/app.css` → compiled to `public/build/`.
Homepage currently uses CDN, not Vite-compiled assets.

---

## Database

25 migrations, ~18 active tables. DB name: `pupr`.

| Table | Model | Purpose |
|---|---|---|
| `users` | `User` | Auth, `is_admin`, `is_verified` flags |
| `posts` | `Post` | News/berita articles (sluggable) |
| `categories` | `Category` | Post categories (sluggable) |
| `karya_ilmiahs` | `KaryaIlmiah` | Scientific works (sluggable) |
| `status_layanans` | `StatusLayanan` | Service status types |
| `user_status_layanans` | `UserStatusLayanan` | User-service status pivot |
| `jenis_layanans` | `JenisLayanan` | Service types |
| `url_layanans` | `UrlLayanan` | External service URLs + social media |
| `galeri_fotos` | `GaleriFoto` | Gallery photos/videos |
| `foto_homes` | `FotoHome` | Homepage carousel images |
| `info_pegawais` | `InfoPegawai` | Employee directory |
| `fasilitas_balais` | `FasilitasBalai` | Office facilities |
| `struktur_organisasis` | `StrukturOrganisasi` | Org chart |
| `landing_pages` | `LandingPage` | CMS landing pages (soft delete, created_by/updated_by) |
| `landing_page_tipes` | `LandingPageTipe` | Landing page type relation |
| `situs_terkaits` | `SitusTerkait` | Related external sites |
| `footer_settings` | `FooterSetting` | Footer content config |

---

## Authentication & Authorization

Session-based auth (Laravel default). No JWT/token API auth.

| Middleware Alias | Class | Check |
|---|---|---|
| `auth` | Laravel built-in | Logged in |
| `is_verify_email` | `IsVerifyEmail` | `users.is_verified == 1` |
| `admin` | `IsAdmin` | `users.is_admin == 1` |
| `guest` | Laravel built-in | Not logged in |

**Registration flow:**
1. User registers → `users` row created, `is_verified = 0`
2. `SignupEmail` mailable sent via Gmail SMTP
3. User clicks link → `is_verified = 1`
4. Login POST passes through `is_verify_email` middleware

**Password reset:** Custom `ForgotPasswordController` with token-based flow.

---

## Route Structure

### Public (no auth)
```
GET /                   HomeController@index
GET /home               HomeController@index
GET /berita             PostController@index
GET /berita/{slug}      PostController@show
GET /visi-misi          VisiMisiController@index
GET /tugas              TugasController@index
GET /sejarah            SejarahController@index
GET /karya-ilmiah       KaryaIlmiahController@index
GET /karya-ilmiah-detail/{slug}
GET /struktur-organisasi
GET /info-pegawai
GET /fasilitas-balai
GET /pengujian-laboratorium
GET /advis-teknis
GET /foto, /video
```

### Auth
```
GET  /login             LoginController@index        [guest]
POST /login             LoginController@authenticate [is_verify_email]
GET  /register          RegisterController@index     [guest]
POST /register          RegisterController@store
GET  /verify-email                                   [auth]
POST /verify-email      (resend)
POST /logout
GET  /verify            RegisterController@verifyAccount
GET  /forgot-password / POST, GET /reset-password/{token}
GET  /profile                                        [auth, is_verify_email]
GET  /profile/status-layanan                         [auth, is_verify_email]
GET  /profile/password                               [auth]
```

### Admin (prefix: `/dashboard`, middleware: `admin`)
```
GET  /dashboard/
resource /posts            DashboardPostController
resource /categories       AdminCategoryController
resource /status-layanan   StatusLayananController
resource /karya-ilmiah     AdminKaryaIlmiahController
resource /url-layanan      AdminUrlLayananController (index/edit/update)
resource /settings         AdminSettings
resource /galeri/foto-video FotoVideoController
resource /foto-home        FotoHomeController (index/edit/update)
resource /foto-layanan     AdminFotoLayananController
resource /situs-terkait    AdminSitusTerkaitController
resource /profil-singkat   AdminProfilSingkatController
resource /info-pegawai     AdminInfoPegawaiController
resource /fasilitas-balai  AdminFasilitasBalaiController
resource /struktur-organisasi AdminStrukturOrganisasiController
resource /footer-setting   AdminFooterSettingController
         /landing-page     LandingPageController (manual CRUD)
```

---

## Key Models

| Model | Traits / Features |
|---|---|
| `User` | `HasFactory`, `Notifiable`. Columns: `name`, `email`, `password`, `is_admin`, `is_verified` |
| `Post` | Sluggable (`slug` from `judul`). Belongs to `Category` |
| `Category` | Sluggable. Has many `Post` |
| `KaryaIlmiah` | Sluggable. Has `path_image`, `bahasa` |
| `LandingPage` | `SoftDeletes`. `created_by`/`updated_by` user IDs. Belongs to `LandingPageTipe` |
| `UrlLayanan` | Stores service URLs + social media links + YouTube. Has `name`, `url`, `path_image` |
| `UserStatusLayanan` | Pivot — user service tracking |
| `GaleriFoto` | Photos and videos (type field removed in later migration) |

---

## Key Controllers

### Frontend
| Controller | Responsibility |
|---|---|
| `HomeController` | Homepage — loads all sections (news, gallery, landing pages, social URLs) |
| `PostController` | News list + detail + AJAX search |
| `KaryaIlmiahController` | Scientific works list + detail |
| `UrlLayananController` | Service pages (pengujian lab, advis teknis) |
| `UserStatusLayananController` | User's service tracking history |
| `LoginController` | Login, logout, email verification |
| `RegisterController` | Registration + verify account |
| `ForgotPasswordController` | Password reset flow |

### Admin
| Controller | Responsibility |
|---|---|
| `DashboardPostController` | CRUD posts/berita |
| `AdminCategoryController` | CRUD categories |
| `AdminKaryaIlmiahController` | CRUD scientific works |
| `FotoVideoController` | CRUD gallery |
| `LandingPageController` | CRUD landing pages (soft delete) |
| `AdminUrlLayananController` | Edit service + social media URLs |
| `AdminFooterSettingController` | Edit footer content |
| `AdminInfoPegawaiController` | CRUD employee directory |
| `AdminStrukturOrganisasiController` | CRUD org chart |
| `AdminFasilitasBalaiController` | CRUD facilities |
| `AdminSettings` | Site-wide settings |

### Utilities
| | |
|---|---|
| `Functions/ImageUpload.php` | Reusable image upload logic via Intervention Image |
| `app/Helper.php` | Global helpers: `cutText()`, `imageExists()`, `globalTipeLanding()`, `slugCustom()`, `toSqlWithBinding()` |

---

## System Flow

### Request Lifecycle
```
Browser Request
  → Nginx/Apache
  → public/index.php (Laravel bootstrap)
  → Kernel middleware (web group: session, CSRF, etc.)
  → Route matching (routes/web.php)
  → [Optional] custom middleware (auth / is_verify_email / admin)
  → Controller method
  → Blade view rendered
  → HTML response
```

### Auth Flow
```
Register POST
  → RegisterController@store
  → User::create() (is_verified=0)
  → SignupEmail mailable → Gmail SMTP
  → Redirect to verify-email page

Verify GET /verify?token=...
  → RegisterController@verifyAccount
  → User.is_verified = 1

Login POST
  → LoginController@authenticate
  → [is_verify_email middleware checks is_verified]
  → Auth::attempt()
  → Session created
  → Redirect to /home
```

### Admin Flow
```
Request to /dashboard/*
  → IsAdmin middleware
  → checks Auth::user()->is_admin == 1
  → if false: abort(403)
  → Admin controller handles CRUD
  → Admin Blade views (Bootstrap 5 / jQuery)
```

---

## React.js Decision

**Do NOT install React.**

| Consideration | Detail |
|---|---|
| Current need | Zero. All interactivity handled by Alpine.js |
| Pattern match | SSR Blade app — React adds hybrid/SPA complexity for no gain |
| Alpine.js coverage | Dropdowns, toggles, modals, carousels — all supported |
| Better alternative if needed | **Livewire** — stays in Laravel/Blade world, no JS build complexity |
| When React makes sense | Building a separate SPA, mobile app, or public API consumer |

**Recommendation:** If richer UI is needed in the future, add **Livewire v3** first. React only if a separate frontend app is required.
