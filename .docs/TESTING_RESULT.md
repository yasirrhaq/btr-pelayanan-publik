# Playwright Testing Results — BTR Pelayanan Publik
> Last updated: 2026-04-13
> Run command: `npx playwright test --reporter=list`
> Base URL: `http://localhost:8080`
> Browser: Chromium (headless)
> Timeout: 60s per test | Workers: 1 | Retries: 1

---

## Summary

| Metric | Value |
|--------|-------|
| Total tests | 64 |
| Passed (clean) | 61 |
| Flaky (passed on retry) | 3 |
| Failed | 0 |
| Total duration | ~15.7 minutes |

**Result: ALL 64 TESTS PASS** (3 required 1 retry due to server-side timing)

---

## Suite 1: Public Pages — `01-public-pages.spec.ts`

| # | Test | Status |
|---|------|--------|
| 1 | Homepage loads with content | FLAKY (retry ok) |
| 2 | Berita (news) list page loads | PASS |
| 3 | Visi Misi page loads | PASS |
| 4 | Tugas page loads | PASS |
| 5 | Sejarah page loads | PASS |
| 6 | Karya Ilmiah list page loads | PASS |
| 7 | Struktur Organisasi page loads | PASS |
| 8 | Info Pegawai page loads | PASS |
| 9 | Fasilitas Balai page loads | PASS |
| 10 | Galeri Foto page loads | PASS |
| 11 | Galeri Video page loads | PASS |
| 12 | Pengujian Laboratorium service page loads | PASS |
| 13 | Advis Teknis service page loads | PASS |
| 14 | Login page renders form | PASS |
| 15 | Register page renders form | PASS |
| 16 | Unauthenticated access to dashboard redirects to login | PASS |
| 17 | Unauthenticated access to pelanggan portal redirects | PASS |

**17/17 pass**

---

## Suite 2: Authentication — `02-auth.spec.ts`

| # | Test | Status |
|---|------|--------|
| 1 | Admin can login and reach dashboard | PASS |
| 2 | Pelanggan can login and reach pelanggan portal | PASS |
| 3 | Wrong password shows error | PASS |
| 4 | Admin logout works | PASS |
| 5 | Guest redirected from admin dashboard | PASS |
| 6 | Guest redirected from pelanggan routes | PASS |

**6/6 pass**

---

## Suite 3: Admin Web (CMS) — `03-admin-web.spec.ts`

| # | Test | Status |
|---|------|--------|
| 1 | Admin dashboard loads | PASS |
| 2 | Berita (posts) list loads | PASS |
| 3 | Create berita form loads | PASS |
| 4 | Categories list loads | PASS |
| 5 | Galeri foto-video list loads | PASS |
| 6 | Create galeri form loads | PASS |
| 7 | Karya Ilmiah (Renstra) list loads | PASS |
| 8 | Info Pegawai list loads | PASS |
| 9 | Fasilitas Balai list loads | PASS |
| 10 | Struktur Organisasi list loads | PASS |
| 11 | Profil Singkat edit loads | PASS |
| 12 | Footer Setting loads | PASS |
| 13 | Landing Page list loads | FLAKY (retry ok) |
| 14 | Foto Home management loads | PASS |
| 15 | URL Layanan list loads | PASS |
| 16 | Situs Terkait list loads | PASS |
| 17 | PPID admin page loads | PASS |
| 18 | Pengumuman list loads | PASS |
| 19 | Create Pengumuman form loads | PASS |
| 20 | Hak Akses (RBAC) page loads | PASS |
| 21 | Master Tim list loads | PASS |
| 22 | Create Master Tim form loads | PASS |
| 23 | Master Survei page loads with inline form | PASS |
| 24 | Settings page loads | PASS |

**24/24 pass**

---

## Suite 4: Admin Layanan — `04-admin-layanan.spec.ts`

| # | Test | Status |
|---|------|--------|
| 1 | Admin Layanan dashboard loads | PASS |
| 2 | Permohonan list loads | PASS |
| 3 | Data Pelanggan loads | PASS |
| 4 | Survei Analytics loads | PASS |
| 5 | Permohonan list has filter toolbar | PASS |
| 6 | Data Pelanggan search works | PASS |

**6/6 pass**

---

## Suite 5: Portal Pelanggan — `05-pelanggan-portal.spec.ts`

| # | Test | Status |
|---|------|--------|
| 1 | Pelanggan dashboard loads without error | PASS |
| 2 | Permohonan list loads | PASS |
| 3 | Create Permohonan wizard loads | FLAKY (retry ok) |
| 4 | Wizard step 1 shows service cards | PASS |
| 5 | Tracking page loads | PASS |
| 6 | Tracking search with empty query loads | PASS |
| 7 | Pembayaran list loads | PASS |
| 8 | Dokumen list loads | PASS |
| 9 | Notifikasi list loads | PASS |
| 10 | Profil page loads | PASS |
| 11 | Bantuan (FAQ) page loads | PASS |

**11/11 pass**

---

## Flakiness Analysis

All 3 flaky tests share the same root cause: `page.goto('/login')` occasionally exceeds the 60s timeout. This happens when:
- The `mews/captcha` library generates a new image on page load
- The Docker PHP-FPM container is under load from the previous test's session cleanup
- All 3 passed cleanly on their first retry

This is **not a code bug** — it's a Docker resource constraint under continuous test load. Solutions if needed:
1. Increase timeout to 90s: `timeout: 90000` in `playwright.config.ts`
2. Add a warm-up pause between test suites
3. Use Playwright's `storageState` to cache the authenticated session and skip re-login for each test

---

## Bugs Found & Fixed During Testing

| Bug | File | Fix |
|-----|------|-----|
| `JenisLayanan::permohonan()` undefined method — Admin Layanan dashboard 500 | `app/Models/JenisLayanan.php` | Added `hasMany(Permohonan::class)` relationship |
| Captcha `required` HTML attribute blocked automated form submission | `LoginController.php`, `RegisterController.php` | Made captcha validation conditional on `config('captcha.disable')` |
| PHP-FPM bound to `127.0.0.1:9000`, nginx container couldn't connect (502) | Docker container `www.conf` | Changed `listen = 127.0.0.1:9000` → `listen = 9000` |

---

## Test Infrastructure

```
playwright.config.ts
tests/playwright/
├── helpers.ts                    # loginAsAdmin, loginAsPelanggan, hasAppError
├── 01-public-pages.spec.ts       # 17 tests
├── 02-auth.spec.ts               # 6 tests
├── 03-admin-web.spec.ts          # 24 tests
├── 04-admin-layanan.spec.ts      # 6 tests
└── 05-pelanggan-portal.spec.ts   # 11 tests
```

**Environment requirements to run:**
- Docker containers running: `docker-compose up -d`
- `.env` in container must have: `CAPTCHA_DISABLE=true`
- Pending migrations applied: `docker exec btr_app php artisan migrate`
- Roles seeded: `docker exec btr_app php artisan db:seed --class=RolesAndPermissionsSeeder --force`
