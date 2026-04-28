# Session Memory — BTR Pelayanan Publik
> Last updated: 2026-04-28

## Current State Snapshot

- `main` includes the recent media/public/admin fixes through commit `6e2cf52`
- Docker stack is healthy:
  - `btr_app` healthy
  - `btr_db` healthy
  - `btr_nginx` up
- PPID public detail no longer returns blank body
- Hak Akses / RBAC admin path is browser-verified
- berita create/edit now support `lampiran` and the missing `admin.posts.attachment` route is fixed
- `/foto` is now an aggregated gallery with search, category filter, pagination, and same-page lightbox
- `/video` is now a managed gallery with upload + YouTube sources and stable `/video/embed/{slug}` embeds for Jodit reuse

## 2026-04-28 Follow-up Work

### Media and public content
- `pengumuman` now uses:
  - slug public URLs
  - title-only search
  - custom pagination
  - dedicated thumbnail image
  - real `views` counter
  - Jodit editor with image upload
- `foto` now aggregates:
  - admin gallery photos
  - berita featured images
  - embedded `<img>` from berita body
  - pengumuman thumbnails
  - embedded `<img>` from pengumuman content
- `video` now supports:
  - local upload source
  - YouTube source
  - category filter
  - managed embed route `/video/embed/{slug}`
  - admin `Copy URL` and `Copy Embed`

### Public/admin stability fixes
- `PublicPpidController` now returns normal Blade responses again instead of pre-rendered string responses
- `resources/views/frontend/ppid/show.blade.php` now uses `$currentSection` to avoid the direct-route blank-body issue
- Playwright admin bypass uses seeded admin `id=1`, not `id=2`
- `DashboardPostController` attachment uploader route is registered as `admin.posts.attachment`
- `LandingPageController` constructor now guards requests without `type`, so `/dashboard/landing-page` no longer breaks
- `TranslateResponse` now returns the original response if translation output collapses to empty content

### Commits pushed on 2026-04-28
- `61d1ca3` `fix: restore ppid public and admin checks`
- `c576c8c` `feat: refresh cms editors and profile flows`
- `6e2cf52` `chore: harden startup and public responses`

## What This Session Did

This session is a **continuation** from a prior context that ran out. The prior context built all the backend + frontend for the app. This session resumed, fixed infrastructure issues, and set up end-to-end Playwright testing.

---

## 1. Infrastructure Fix (Docker / PHP-FPM)

**Problem:** App was returning 502 after `docker-compose up -d`.

**Root cause:** PHP-FPM was bound to `127.0.0.1:9000` (loopback only). Nginx in a separate container could not reach it via the internal network.

**Fix:**
```bash
docker exec btr_app sh -c "sed -i 's/listen = 127.0.0.1:9000/listen = 9000/' /usr/local/etc/php-fpm.d/www.conf && php-fpm -D"
```
Config file: `/usr/local/etc/php-fpm.d/www.conf` — change `listen = 127.0.0.1:9000` → `listen = 9000`.

After restart, `curl http://localhost:8080/` returns 200.

---

## 2. Database Migrations & Seeding

Two pending migrations were run:
- `2026_04_12_053625_create_permission_tables` — spatie/laravel-permission tables
- `2026_04_12_060000_create_layanan_workflow_tables` — all workflow tables

Full seeder (`db:seed`) fails with duplicate entry because users already exist. Run only:
```bash
docker exec btr_app php artisan db:seed --class=RolesAndPermissionsSeeder --force
```

Roles seeded: `admin-bidang`, `admin-editor`, `admin-layanan-master`, `admin-master`, `analis`, `katim`, `pelanggan`, `penyelia`, `teknisi`.

Role assignments made manually via tinker:
- `yasir.haq98@gmail.com` → `pelanggan`
- `baltekrawa1@gmail.com` → `admin-master`

---

## 3. Test Credentials

| User | Email | Password | Role |
|------|-------|----------|------|
| Admin (CMS + Layanan) | `baltekrawa1@gmail.com` | `adminbaltekrawa123` | `admin-master`, `is_admin=1` |
| Pelanggan | `yasir.haq98@gmail.com` | `12345` | `pelanggan`, `is_admin=0` |

Access control: Admin dashboard uses `is_admin == 1` check (IsAdmin middleware), NOT spatie roles.

---

## 4. Captcha Bypass for Testing

The login and register forms use `mews/captcha` with a required HTML field. To allow automated testing:

**Controller change** (`LoginController.php` + `RegisterController.php`): captcha validation rule is now conditional:
```php
if (!config('captcha.disable', false)) {
    $rules['captcha'] = 'required|captcha';
}
```

**Env variable** in container `.env`:
```
CAPTCHA_DISABLE=true
```

**Playwright helper** also removes the HTML `required` attribute from the captcha input before submitting (browser-level validation would block otherwise):
```ts
await page.evaluate(() => {
  const cap = document.querySelector('input[name="captcha"]') as HTMLInputElement | null;
  if (cap) cap.removeAttribute('required');
});
await page.locator('button[type="submit"]').click({ force: true });
```

---

## 5. Bug Fixed: JenisLayanan Missing `permohonan` Relationship

**Error:** `Call to undefined method App\Models\JenisLayanan::permohonan()` on `/dashboard/layanan`.

**Fix** in `app/Models/JenisLayanan.php`:
```php
public function permohonan()
{
    return $this->hasMany(Permohonan::class);
}
```

---

## 6. Playwright Test Suite Setup

### Files Created
```
playwright.config.ts              — baseURL: http://localhost:8080, timeout: 60s, 1 worker
tests/playwright/helpers.ts       — loginAsAdmin, loginAsPelanggan, hasAppError helpers
tests/playwright/01-public-pages.spec.ts   — 17 tests: all public-facing pages
tests/playwright/02-auth.spec.ts           — 6 tests: login, logout, redirects
tests/playwright/03-admin-web.spec.ts      — 24 tests: all CMS admin pages
tests/playwright/04-admin-layanan.spec.ts  — 6 tests: Admin Layanan dashboard + workflows
tests/playwright/05-pelanggan-portal.spec.ts — 11 tests: all Pelanggan portal pages
```

### Run Commands
```bash
# Full suite
npx playwright test --reporter=list

# Single suite
npx playwright test tests/playwright/01-public-pages.spec.ts --reporter=list

# HTML report
npx playwright show-report
```

### Known Flakiness
3 tests occasionally hit the 60s timeout on `page.goto('/login')` — caused by captcha image generation spiking server response. All pass on retry (retries: 1 configured). Not a real failure.

---

## 7. Prior Session Work (from context summary)

The previous session (before context compaction) built:
- All migration + model + service files for the workflow engine
- All views for Pelanggan portal, Admin Layanan, Admin Web CMS enhancements
- Routes for all modules
- `public/css/pelanggan.css` — full design system CSS for customer portal
- Controllers: HakAksesController, MasterTimController, MasterSurveiController, PengumumanController

See `docs/operations/IMPLEMENTATION_TRACKER.md` for complete feature status.

---

## 8. Docker Commands Reference

```bash
docker-compose up -d                          # Start all containers
docker-compose ps                             # Check status
docker exec btr_app php artisan migrate       # Run migrations
docker exec btr_app php artisan config:clear  # Clear config cache
docker exec btr_app php artisan tinker        # Interactive REPL
docker exec btr_app php artisan db:seed --class=RolesAndPermissionsSeeder --force
```

Ports:
- App: `http://localhost:8080`
- DB: `localhost:3307` (MySQL, db: `pupr`)
