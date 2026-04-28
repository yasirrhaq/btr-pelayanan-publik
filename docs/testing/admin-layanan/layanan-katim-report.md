# Layanan - Katim Report

Date:
- 2026-04-23

Spec source:
- `.docs/ROLE_ACCESS.md`

Expected by spec:
- Advis Katim: `Verifikasi`, `Penugasan`
- Data Katim: `Verifikasi`, `Penugasan`
- Lainnya Katim: `Verifikasi`, `Penugasan`
- Lab Katim: `Kaji Ulang`, `Penugasan`

Seed/code mapping:
- Role: `katim`
- User used in browser audit: `id=4`, `katim@baltekrawa.go.id`

Actual rendered navbar:
- `Dashboard`
- `Permohonan`
- `Dokumen Final`

Actual route checks:
- `/dashboard/layanan/data-pelanggan`: `403`
- `/dashboard/layanan/survei-analytics`: `403`
- `/dashboard/posts`: `403`

Findings:
- Role is no longer overexposed to admin-web routes or management-only layanan pages.
- Current live shell is closer to a stage-role inbox than the earlier full layanan shell.
- Exact service-specific scoping still cannot be proven because seeded role `katim` is generic, not per-layanan (`Advis/Data/Lab/Lainnya`).

Mismatch status:
- Navbar scope: `partial match`
- Route scope: `match`
