# Layanan - Teknisi Report

Date:
- 2026-04-23

Spec source:
- `docs/architecture/ROLE_ACCESS.md`

Expected by spec:
- Lab Teknisi: `Pelaksanaan`
- Explicit note: must not see or manage `Data Pelanggan`

Seed/code mapping:
- Role: `teknisi`
- User used in browser audit: `id=6`, `teknisi@baltekrawa.go.id`

Actual rendered navbar:
- `Dashboard`
- `Permohonan`

Actual route checks:
- `/dashboard/layanan/data-pelanggan`: `403`
- `/dashboard/layanan/survei-analytics`: `403`
- `/dashboard/posts`: `403`

Findings:
- The explicit `Data Pelanggan` violation is fixed.
- Teknisi is no longer exposed to admin-web routes in the checked path set.
- Stage-specific pelaksanaan authority inside workflow detail still needs its own action-level test.

Mismatch status:
- Navbar scope: `match`
- Route scope: `match`
