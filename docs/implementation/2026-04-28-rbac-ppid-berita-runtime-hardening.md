# 2026-04-28 RBAC, PPID, Berita, and Runtime Hardening

## Scope
- resolved the PPID public blank-body regression
- aligned Playwright admin bypass with the real seeded `admin-master` account
- completed the Hak Akses / RBAC admin-account management flow
- completed berita `lampiran` and editor attachment plumbing
- hardened startup/runtime behavior in Docker and public translation flow

## Key Fixes

### PPID public
- `PublicPpidController` now returns standard Blade responses again
- `frontend/ppid/show.blade.php` now uses `currentSection` instead of a top-level `section` variable
- direct public PPID routes like `/ppid/kebijakan-ppid` now return full HTML bodies again

### Admin auth and RBAC
- Playwright helper now logs in as seeded admin user `id=1`
- Hak Akses now supports:
  - create admin account
  - assign/sync roles
  - assign direct permissions
  - toggle active/inactive state
- dashboard sidebars now hide or expose modules based on permission checks instead of broad static assumptions
- login now blocks inactive accounts explicitly

### Berita and dokumen
- added missing route `admin.posts.attachment`
- berita create/edit pages now load correctly with Jodit attachment upload config
- berita supports optional `lampiran`
- `/dokumen` now includes berita attachments as first-class items
- `posts.lampiran_path` migration is guarded against duplicate-column reruns

### Runtime hardening
- `LandingPageController` constructor now handles requests without `type`
- `TranslateResponse` keeps the original response if translation output becomes empty
- `docker-compose.yml` now includes app healthcheck and nginx dependency on app health

## Verification
- `php -l` passed for touched PHP files
- focused Playwright runs passed:
  - PPID public/admin checks
  - Hak Akses list/create checks
  - berita create form check
  - landing-page admin check
  - dokumen public check
- `docker compose ps` shows:
  - `btr_app` healthy
  - `btr_db` healthy
  - `btr_nginx` up

## Commits
- `61d1ca3` `fix: restore ppid public and admin checks`
- `c576c8c` `feat: refresh cms editors and profile flows`
- `6e2cf52` `chore: harden startup and public responses`
