# Pelanggan Role Audit

Audit basis:
- Spec: `docs/architecture/ROLE_ACCESS.md`
- Actual UI: headless Playwright run on 2026-04-23
- Seed/code source: `database/seeders/UsersSeeder.php`, `resources/views/pelanggan/layouts/sidebar.blade.php`, `resources/views/pelanggan/layouts/header.blade.php`, `routes/web.php`

Reports in this folder:
- `akun-pelanggan-report.md`
- `../MANUAL_CROSSCHECK.md` section `3. Pelanggan`

High-signal summary:
- Seeded pelanggan role exists.
- Browser audit could authenticate the pelanggan user.
- Pelanggan shell currently fails with runtime `500`, so navbar could not be fully rendered in the browser.
