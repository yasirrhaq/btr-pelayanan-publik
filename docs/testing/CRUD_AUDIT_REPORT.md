# CRUD Audit Report

Date: 2026-04-14
Repository: `btr-pelayanan-publik`

## Scope

- Audited all backend-connected route surfaces from `routes/web.php:60` through `routes/web.php:263`.
- Included auth, admin web CMS, admin layanan, pelanggan portal, and route-backed query pages.
- Attempted live runtime setup for browser CRUD execution, then completed static code audit where runtime was blocked.

## Runtime Attempt

- `docker-compose ps` could not run because Docker daemon was unavailable on this machine.
- `curl -I http://localhost:8080` failed because no app server was listening.
- `php artisan route:list` failed because `app/Http/Controllers/Admin/LandingPage/LandingPageController.php:14` hits the database in the constructor, and current `.env` points to `DB_HOST=db`.
- Attempted SQLite fallback with `php artisan migrate:fresh --seed --force`, but migration failed at `database/migrations/2022_11_24_040946_alter_galeri_remove_type` because Doctrine DBAL support for SQLite is missing in the current install.

Result: direct Chrome DevTools control was not available in this CLI session. After Docker recovery, I ran live browser automation through Playwright instead.

## Runtime Recovery

- Initial state:
  - `btr_app` up
  - `btr_db` healthy
  - `btr_nginx` stuck restarting
- Root cause from container logs: `docker/nginx/default.conf:24` upstream `app:9000` could not resolve because the nginx container had lost healthy network attachment during restart.
- Recovery action: recreated nginx with `docker-compose up -d --force-recreate nginx`.
- After recovery:
  - `btr_nginx` healthy
  - `http://localhost:8080` returned `200 OK`

## Live Browser Test Run

- First live run after recovery: `61 passed`, `3 failed`
- Fixes applied for runtime breakers, workflow guards, pelanggan field mismatches, numbering placeholders, and new CRUD coverage.
- Final verification command: `npx playwright test --reporter=list`
- Final result: `68 passed`, `0 failed`
- Final runtime duration: about `3.7m`

### Confirmed fixed runtime issues

- `resources/views/dashboard/pengumuman/index.blade.php:28` no longer crashes; `Str::limit()` is now resolved safely.
- `resources/views/dashboard/layanan/index.blade.php:54` no longer crashes; the permohonan list and filter toolbar now load cleanly.
- `resources/views/pelanggan/dashboard.blade.php:64`, `resources/views/pelanggan/permohonan/index.blade.php:31`, and `resources/views/pelanggan/notifikasi/index.blade.php:26` no longer crash on `Str::limit()`.
- `resources/views/dashboard/layanan/show.blade.php:145` now renders the survey section against the actual `hasOne` relation shape.
- `app/Http/Controllers/LoginController.php:41` now sends verified pelanggan users to `/pelanggan` instead of `/dashboard`.
- `app/Services/NomorPermohonanService.php:30` now supports the seeded `{YYYY}`, `{MM}`, and `{SEQ}` placeholders, which removed duplicate-number failures during live pelanggan submission testing.
- `app/Http/Controllers/Admin/MasterSurveiController.php:20` and `resources/views/dashboard/master-survei/index.blade.php:12` now handle the required `unsur` field correctly.

### Live CRUD flows now covered

- Admin Web:
  - Pengumuman create + delete
  - Master Survei create + delete
- Admin Layanan:
  - Permohonan list to detail navigation
- Pelanggan:
  - Permohonan submission flow

### Additional runtime issue still open

- Dashboard still requests `/img/mascot.png` and receives `404`.
- This is cosmetic because the inline fallback still renders a placeholder mascot.

## Route Coverage

Audited these backend-connected areas:

- Auth: `/login`, `/register`, `/forgot-password`, `/reset-password`, `/verify-email`, `/verify`, `/logout`, `/profile/password`
- Admin Web CMS: `/dashboard/posts`, `/dashboard/categories`, `/dashboard/status-layanan`, `/dashboard/karya-ilmiah`, `/dashboard/url-layanan`, `/dashboard/settings`, `/dashboard/galeri/foto-video`, `/dashboard/foto-home`, `/dashboard/foto-layanan`, `/dashboard/situs-terkait`, `/dashboard/profil-singkat`, `/dashboard/info-pegawai`, `/dashboard/fasilitas-balai`, `/dashboard/struktur-organisasi`, `/dashboard/footer-setting`, `/dashboard/landing-page`, `/dashboard/hak-akses`, `/dashboard/master-tim`, `/dashboard/master-survei`, `/dashboard/pengumuman`, `/dashboard/ppid`
- Admin Layanan: `/dashboard/layanan`, `/dashboard/layanan/permohonan`, detail page actions, data pelanggan, survei analytics
- Pelanggan: `/pelanggan/permohonan`, `/pelanggan/tracking`, `/pelanggan/pembayaran`, `/pelanggan/dokumen`, `/pelanggan/notifikasi`, `/pelanggan/survei`, `/pelanggan/profil`

## High-Risk CRUD Bugs

### 1. Landing page admin can break before page load

- `app/Http/Controllers/Admin/LandingPage/LandingPageController.php:14` queries request-dependent DB state inside `__construct()`.
- This breaks tooling like `route:list` and can 404 or explode before normal action handling.
- Any request without valid `?type=` is unsafe.

### 2. PPID management links use wrong query parameter

- `resources/views/dashboard/ppid/index.blade.php:16`
- `resources/views/dashboard/ppid/index.blade.php:21`
- `resources/views/dashboard/ppid/index.blade.php:26`
- `resources/views/dashboard/ppid/index.blade.php:31`
- These send `?tipe=` while `app/Http/Controllers/Admin/LandingPage/LandingPageController.php:26` expects `type`.
- Result: PPID manage buttons route into broken landing-page CRUD flows.

### 3. Admin layanan UI exposes invalid workflow actions

- `resources/views/dashboard/layanan/show.blade.php:196` allows team assignment when status is `baru` or `verifikasi`.
- `app/Http/Controllers/Admin/Layanan/PermohonanManagementController.php:103` forces transition to `penugasan`.
- `app/Models/Permohonan.php:68` only allows `baru -> verifikasi`, not `baru -> penugasan`.
- Status: fixed in this pass by aligning the UI and adding controller-side transition guards.

### 4. Billing flow also conflicts with workflow rules

- `resources/views/dashboard/layanan/show.blade.php:222` allows billing from `verifikasi` or `penugasan`.
- `app/Http/Controllers/Admin/Layanan/PermohonanManagementController.php:130` transitions to `pembayaran`.
- `app/Models/Permohonan.php:69` does not allow `verifikasi -> pembayaran`.
- Status: fixed in this pass by aligning the UI and adding controller-side transition guards.

### 5. Pelanggan and admin views use wrong `JenisLayanan` property name

- Schema uses `name`: `database/migrations/2022_11_17_030244_create_jenis_layanan_table.php:18`.
- Many views use `nama`, for example:
  - `resources/views/pelanggan/permohonan/create.blade.php:26`
  - `resources/views/pelanggan/permohonan/index.blade.php:30`
  - `resources/views/pelanggan/permohonan/show.blade.php:15`
  - `resources/views/pelanggan/tracking/index.blade.php:30`
  - `resources/views/pelanggan/pembayaran/index.blade.php:23`
  - `resources/views/dashboard/layanan/show.blade.php:25`
  - `resources/views/dashboard/master-tim/index.blade.php:31`
- Status: fixed in this pass via `app/Models/JenisLayanan.php:15` compatibility accessor.

### 6. Admin layanan survey block is coded against the wrong relationship shape

- `app/Models/Permohonan.php:123` defines `surveiKepuasan()` as `hasOne`.
- `resources/views/dashboard/layanan/show.blade.php:145` uses `count()`.
- `resources/views/dashboard/layanan/show.blade.php:148` iterates with `@foreach`.
- Status: fixed in this pass.

### 6b. Multiple dashboard views call `Str::limit()` without qualification/import

- Confirmed runtime failures already hit:
  - `resources/views/dashboard/pengumuman/index.blade.php:28`
  - `resources/views/dashboard/layanan/index.blade.php:54`
- Additional pages with the same pattern and likely same failure mode:
  - `resources/views/dashboard/layanan/show.blade.php:102`
  - `resources/views/dashboard/layanan/survei-analytics.blade.php:107`
  - `resources/views/dashboard/foto-layanan/index.blade.php:23`
- Status: fixed for all confirmed admin and pelanggan runtime hits in this pass.

### 7. Pelanggan profile reads a non-existent field

- `resources/views/pelanggan/profil/index.blade.php:40` uses `$user->nama_instansi`.
- User schema stores `instansi`, not `nama_instansi`; see `database/migrations/2014_10_12_000000_create_users_table.php` and workflow migration additions in `database/migrations/2026_04_12_060000_create_layanan_workflow_tables.php:20`.
- Status: fixed in this pass.

### 8. Numbering templates and numbering service do not agree

- Seeder format uses `{YYYY}`, `{MM}`, `{SEQ}` in `database/seeders/LayananOperasionalSeeder.php:27`.
- Generator replaces only `{ID}`, `{KODE}`, `{TAHUN}`, `{COUNTER}` in `app/Services/NomorPermohonanService.php:30`.
- Status: fixed in this pass.

## Medium-Risk CRUD Bugs

### 9. Login redirect sends verified non-admin users into admin path

- `app/Http/Controllers/LoginController.php:41` redirects verified users to `/dashboard`.
- Non-admin users are then blocked by `app/Http/Middleware/IsAdmin.php:22`.
- Status: fixed in this pass.

### 10. Pelanggan wizard file rules and UI copy disagree

- UI claims `rar/zip` support in `resources/views/pelanggan/permohonan/create.blade.php:106`.
- Accepted file types exclude them in `resources/views/pelanggan/permohonan/create.blade.php:110`.
- Backend validation also excludes them in `app/Http/Controllers/Pelanggan/PermohonanController.php:43`.
- Result: user-facing upload instructions are false.

### 11. Master Survei controller does not fill required `unsur`

- Migration requires `unsur` in `database/migrations/2026_04_12_060000_create_layanan_workflow_tables.php:124`.
- `app/Http/Controllers/Admin/MasterSurveiController.php` only handles `pertanyaan`, `urutan`, `is_active`.
- Status: fixed in this pass.

### 12. Tracking query is embedded directly inside the Blade view

- `resources/views/pelanggan/tracking/index.blade.php:14` through `resources/views/pelanggan/tracking/index.blade.php:21` runs database logic in the template.
- This is not just a style issue; it makes request handling, caching, authorization review, and testing harder.

### 13. Public route exists for storage symlink creation

- `routes/web.php:99` exposes `/linkstorage` with no auth.
- Even if idempotent on many environments, this is an unsafe backend action on a public route.

## Low-Risk or Structural Issues

### 14. Legacy and new service tracking systems coexist

- Old system: `/profile/status-layanan` via `StatusLayanan`.
- New system: `/pelanggan/*` via `Permohonan` workflow.
- Mixed models increase confusion and can cause duplicated or inconsistent user flows.

### 15. Local environment dependencies are brittle

- `.env` expects Docker hostnames like `db` and `mailpit`.
- Without Docker, many artisan commands fail immediately.

## CRUD Status By Module

- Auth CRUD/status flows: implemented and live-tested; pelanggan redirect bug is fixed.
- Admin Web CRUD: largely present, but landing-page and PPID flows are unstable.
- Admin Layanan CRUD/actions: substantial implementation and now live-tested for list/detail flows; landing-page/PPID remain the main admin-web risk area.
- Pelanggan CRUD/self-service: broadly present and live-tested; submission, dashboard, tracking, pembayaran, dokumen, notifikasi, profil, and bantuan all passed in Playwright.

## Priority Fix Order

1. Refactor `LandingPageController` to remove DB work from `__construct()` and unify `type` query usage.
2. Remove or protect the public `/linkstorage` route.
3. Decide whether to keep or remove the missing mascot asset request on `/dashboard`.
4. Clean up pelanggan wizard copy so upload instructions match actual accepted file types.
5. Move tracking query logic out of `resources/views/pelanggan/tracking/index.blade.php` and into its controller.
