# Security Audit Report

Date: 2026-04-14
Repository: `btr-pelayanan-publik`
Method: static code audit plus environment/runtime inspection

## Runtime Note

- Direct Chrome DevTools control was not available in this CLI session.
- Live browser validation was performed with Playwright after repairing the nginx container.
- Final live Playwright verification now passes `68/68` tests.

## Scope

- Auth and account recovery
- Route protection and RBAC
- File upload and file access
- Publicly exposed utility routes
- Environment and deployment hygiene

## Critical Findings

### 1. Public utility route can create storage symlink

- `routes/web.php:99` exposes `/linkstorage` without auth.
- This is an administrative filesystem action on a public GET route.
- Risk: unauthorized environment manipulation and accidental public exposure.

### 2. Real route protection still depends on `is_admin`, not RBAC permissions

- Admin area is guarded by `routes/web.php:135` using `admin` middleware.
- `app/Http/Middleware/IsAdmin.php:22` only checks `is_admin == 1`.
- Granular `role` and `permission` middleware are registered in `app/Http/Kernel.php:70`, `app/Http/Kernel.php:71` but not actually used on these route groups.
- Risk: any `is_admin` user can access all admin web and admin layanan surfaces, regardless of seeded role intent.

### 3. `.env.example` / environment hygiene risk

- Current repo state includes operational-looking mail sender details in environment templates and a checked-in `.env` exists in workspace root.
- Risk: accidental secret leakage and misconfigured production promotion.

## High Findings

### 4. Password reset tokens have no expiry or throttled lifecycle

- `app/Http/Controllers/ForgotPasswordController.php:27` stores a random reset token directly on the user row.
- `app/Http/Controllers/ForgotPasswordController.php:45` accepts any matching token.
- `app/Http/Controllers/ForgotPasswordController.php:62` resets password if token matches, with no expiry check.
- Risk: long-lived password reset tokens remain valid until used or overwritten.

### 5. Email verification token is not invalidated after use

- `app/Http/Controllers/RegisterController.php:64` creates `verification_token`.
- `app/Http/Controllers/RegisterController.php:82` marks user verified.
- Token is not cleared after successful verification.
- Risk: stale verification tokens remain in database longer than needed.

### 6. User enumeration in forgot-password flow

- `app/Http/Controllers/ForgotPasswordController.php:23` validates `exists:users`.
- Response behavior differs for invalid email, unverified email, and valid verified email.
- Risk: attacker can distinguish account existence and verification state.

### 7. Unsafe direct file deletion patterns

- Multiple controllers use raw `unlink()` on DB-backed paths, for example:
  - `app/Http/Controllers/DashboardPostController.php:123`
  - `app/Http/Controllers/AdminKaryaIlmiahController.php:124`
  - `app/Http/Controllers/AdminFasilitasBalaiController.php:119`
  - `app/Http/Controllers/AdminInfoPegawaiController.php:115`
  - `app/Http/Controllers/Admin/LandingPage/LandingPageController.php:141`
- Risk: path handling is inconsistent and bypasses storage abstraction safeguards.

## Medium Findings

### 8. Public file access relies on public disk paths

- Admin views expose direct `asset('storage/...')` links for uploaded files, such as:
  - `resources/views/dashboard/layanan/show.blade.php:123`
  - `resources/views/dashboard/pengumuman/index.blade.php:38`
- Final customer downloads are gated through controller authorization in `app/Http/Controllers/Pelanggan/DokumenController.php:25`, which is good.
- Risk: other uploaded artifacts on public disk may still be guessable or directly accessible if URLs leak.

### 9. Local test-login route is safe only if environment never drifts

- `routes/web.php:64` exposes `/test-login/{userId}` in `local` environment.
- This is acceptable for local testing, but dangerous if environment labeling is misconfigured.

### 10. Debug-friendly local config is still active in tracked `.env`

- `.env:2` sets `APP_ENV=local`.
- `.env:4` sets `APP_DEBUG=true`.
- Risk depends on deployment practice, but checked-in local env files increase accidental exposure chance.

## Positive Findings

- CSRF middleware is enabled for the web stack in `app/Http/Kernel.php:37`.
- Auth routes use throttling in `routes/web.php:111` and `routes/web.php:117`.
- Pelanggan routes perform ownership checks in core controllers:
  - `app/Http/Controllers/Pelanggan/PermohonanController.php:91`
  - `app/Http/Controllers/Pelanggan/PembayaranController.php:15`
  - `app/Http/Controllers/Pelanggan/DokumenController.php:29`
  - `app/Http/Controllers/Pelanggan/SurveiController.php:19`
  - `app/Http/Controllers/Pelanggan/NotifikasiController.php:22`
- Final document download is gated by survey completion in `app/Http/Controllers/Pelanggan/DokumenController.php:33` and unlocked explicitly in `app/Http/Controllers/Pelanggan/SurveiController.php:68`.

## Security Bugs Affecting Backend-Connected Pages

- Login redirect mismatch was fixed in this pass: `app/Http/Controllers/LoginController.php:41` now sends verified pelanggan users to `/pelanggan`.
- Auth expiry handling was improved in this pass: `app/Exceptions/Handler.php:41` now catches page-expired/CSRF mismatch errors and redirects users back to the auth form with a fresh token instead of leaving them on a raw `419` page.
- Landing-page constructor DB call: `app/Http/Controllers/Admin/LandingPage/LandingPageController.php:14` can break administrative tooling and create unstable request handling.
- PPID management broken routing: `resources/views/dashboard/ppid/index.blade.php:16` through `:31` use wrong query key and can push admins into failing pages.

## Priority Fix Order

1. Remove or strictly protect `/linkstorage`.
2. Move admin authorization from `is_admin` to real role/permission middleware.
3. Add expiry and invalidation for reset and verification tokens.
4. Replace raw `unlink()` usage with consistent storage-disk deletion.
5. Separate local-only testing helpers from route files or hard-disable outside explicit test mode.
6. Clean tracked environment files and replace any real-looking credentials with placeholders.
