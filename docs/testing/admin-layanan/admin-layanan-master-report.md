# Admin Layanan - Master Report

Date:
- 2026-04-23

Spec source:
- `.docs/ROLE_ACCESS.md`

Expected by spec:
- Full access to all layanan menus and features.

Seed/code mapping:
- Role: `admin-layanan-master`
- User used in browser audit: `id=3`, `layanan@baltekrawa.go.id`

Actual rendered navbar:
- `Dashboard`
- `Advis Teknik`
- `Laboratorium`
- `Data dan Informasi`
- `Layanan Lainnya`
- `Survei Kepuasan`
- `Data Pelanggan`
- `Dokumen Final`

Actual route checks:
- `/dashboard/layanan/data-pelanggan`: `200`
- `/dashboard/layanan/survei-analytics`: `200`
- `/dashboard/posts`: `403`

Findings:
- Full layanan access is present.
- Cross-area isolation from admin web is now enforced for the checked route.
- `Notifikasi` and `Bantuan` are still absent from the actual sidebar because no live admin-layanan routes are wired for them.

Mismatch status:
- Layanan sidebar: `partial match`
- Isolation from admin web area: `match`
