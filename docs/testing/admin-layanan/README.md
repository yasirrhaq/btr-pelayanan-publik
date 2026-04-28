# Admin Layanan Role Audit

Audit basis:
- Spec: `.docs/ROLE_ACCESS.md`
- Actual UI: headless Playwright run on 2026-04-23
- Seed/code source: `database/seeders/UsersSeeder.php`, `database/seeders/RolesAndPermissionsSeeder.php`, `resources/views/dashboard/layanan/layouts/sidebar.blade.php`, `routes/web.php`, `app/Http/Middleware/CheckRole.php`

Reports in this folder:
- `admin-layanan-master-report.md`
- `admin-layanan-advis-report.md`
- `admin-layanan-lab-report.md`
- `admin-layanan-data-report.md`
- `admin-layanan-lainnya-report.md`
- `layanan-katim-report.md`
- `layanan-analis-report.md`
- `layanan-teknisi-report.md`
- `../MANUAL_CROSSCHECK.md` section `2. Admin Layanan`

High-signal summary:
- Spec defines menu-level roles: `Admin Layanan - Master`, `Advis`, `Lab`, `Data`, `Lainnya`.
- Current code only seeds: `admin-layanan-master`, `katim`, `admin-bidang`, `analis`, `penyelia`, `teknisi`.
- No seeded roles exist for `admin-layanan-advis`, `admin-layanan-lab`, `admin-layanan-data`, `admin-layanan-lainnya`.
- The admin layanan sidebar is currently static and does not filter menu items by role.
- Admin layanan routes use `admin` middleware only; role middleware exists but is not applied on these routes.
- Stage-role users like `katim`, `analis`, and `teknisi` can see `Data Pelanggan` and can also open `/dashboard/posts`, which conflicts with the access spec.
