# Admin Web - Master Report

Date:
- 2026-04-23

Spec source:
- `docs/architecture/ROLE_ACCESS.md`

Expected by spec:
- Full access to all admin web menus and features.

Seed/code mapping:
- Role: `admin-master`
- User used in browser audit: `id=1`, `baltekrawa1@gmail.com`

Actual rendered navbar:
- `Dashboard`
- `Identitas`
- `Struktur Organisasi`
- `Informasi Pegawai`
- `Fasilitas`
- `Informasi Pelayanan`
- `Layanan`
- `Tracking Layanan`
- `Banner`
- `Berita`
- `Galeri`
- `Pengumuman`
- `Renstra`
- `PPID`
- `Tautan`
- `Hak Akses`
- `Master Tim`
- `Master Survei`
- `Sistem`

Actual route checks:
- `/dashboard`: `200`
- `/dashboard/posts`: `200`
- `/dashboard/layanan`: `200`
- `/dashboard/hak-akses`: `500`

Findings:
- Navbar broadly matches full-access expectation.
- Actual menu exceeds the original design screenshot because `Master Tim` and `Master Survei` are exposed under `Pengaturan`.
- `/dashboard/hak-akses` is not blocked, but currently broken by missing route `admin.hak-akses.create`.
- Admin Web - Master can also access Admin Layanan routes at `/dashboard/layanan`.

Mismatch status:
- Spec match on broad access: `match`
- Design screenshot parity: `partial`
- Runtime stability: `failed on hak-akses`

Recommended smoke flow:
1. Login.
2. Open `/dashboard`.
3. Confirm all main admin-web groups visible.
4. Open `Berita`, `Pengumuman`, `PPID`, `Renstra`, `Tautan`.
5. Open `Hak Akses`.
6. Record current `500` as defect until fixed.
