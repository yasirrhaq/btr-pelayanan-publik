# Admin Web - Editor Report

Date:
- 2026-04-23

Spec source:
- `.docs/ROLE_ACCESS.md`

Expected by spec:
- Limited only to publication menus.

Seed/code mapping:
- Role: `admin-editor`
- User used in browser audit: `id=2`, `editor@baltekrawa.go.id`

Actual rendered navbar:
- `Berita`
- `Galeri`
- `Pengumuman`

Actual route checks:
- `/dashboard/posts`: `200`
- `/dashboard/hak-akses`: `403`
- `/dashboard/ppid`: `403`
- `/dashboard/layanan`: `403`

Findings:
- Sidebar/menu scope matches the publication-only spec.
- Route-level protection is now aligned for the checked non-editor routes.

Mismatch status:
- Sidebar/menu visibility: `match`
- Route protection: `match`

Recommended smoke flow:
1. Login.
2. Open `/dashboard/posts`.
3. Confirm only `Berita`, `Galeri`, `Pengumuman` appear.
4. Attempt `/dashboard/hak-akses`, `/dashboard/ppid`, and `/dashboard/layanan`.
5. Expect `403`.
