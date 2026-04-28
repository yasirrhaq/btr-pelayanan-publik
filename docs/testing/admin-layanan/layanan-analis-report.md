# Layanan - Analis Report

Date:
- 2026-04-23

Spec source:
- `.docs/ROLE_ACCESS.md`

Expected by spec:
- Lab Analis: `Analisis`

Seed/code mapping:
- Role: `analis`
- User used in browser audit: `id=5`, `analis@baltekrawa.go.id`

Actual rendered navbar:
- `Dashboard`
- `Permohonan`

Actual route checks:
- `/dashboard/layanan/data-pelanggan`: `403`
- `/dashboard/layanan/survei-analytics`: `403`
- `/dashboard/posts`: `403`

Findings:
- Role is no longer exposed to unrelated layanan management menus.
- Route isolation from both admin-web and management-only layanan pages is now working for the checked endpoints.
- Stage-specific action validation inside a permohonan detail page still needs a dedicated workflow test.

Mismatch status:
- Navbar scope: `partial match`
- Route scope: `match`
