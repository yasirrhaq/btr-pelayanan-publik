# Admin Web Role Audit

Audit basis:
- Spec: `.docs/ROLE_ACCESS.md`
- Actual UI: headless Playwright run on 2026-04-23
- Seed/code source: `database/seeders/UsersSeeder.php`, `database/seeders/RolesAndPermissionsSeeder.php`, `resources/views/dashboard/layouts/sidebar.blade.php`, `routes/web.php`

Reports in this folder:
- `admin-web-master-report.md`
- `admin-web-editor-report.md`
- `../MANUAL_CROSSCHECK.md` section `1. Admin Web`

High-signal summary:
- `admin-master` exists and renders a full admin-web sidebar.
- `admin-editor` exists and renders only publication menus in the sidebar.
- Route access is not consistently permission-gated.
- `admin-editor` can still reach `/dashboard/layanan`.
- `admin-editor` can hit restricted admin-web routes, but some fail with `500` because of unrelated route/view bugs rather than access denial.
