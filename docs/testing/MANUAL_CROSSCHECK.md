# Manual Cross-Check Guide

Purpose:
- manual verification for every report under `docs/testing`
- use this when you want to confirm the current RBAC behavior without Playwright

Base URL:
- `http://localhost:8080`

General notes:
- open a fresh incognito/private window for each role
- if already logged in, logout first
- use the sidebar and direct URL access checks together
- `403 Forbidden` means route protection worked
- `500` means runtime bug, not valid access control

## 1. Admin Web

Reports covered:
- `docs/testing/admin-web/admin-web-master-report.md`
- `docs/testing/admin-web/admin-web-editor-report.md`

### 1.1 Admin Web - Master

Credential:
- username/email: `baltekrawa1@gmail.com`
- password: `adminbaltekrawa123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. After login, visit `/dashboard`.
4. Check the sidebar.
5. Expand `Profil`.
6. Expand `Layanan`.
7. Expand `Publikasi`.
8. Expand `Pengaturan`.
9. Visit `/dashboard/posts`.
10. Visit `/dashboard/pengumuman`.
11. Visit `/dashboard/ppid`.
12. Visit `/dashboard/renstra` if available in UI, otherwise visit `/renstra` for public page check only.
13. Visit `/dashboard/situs-terkait`.
14. Visit `/dashboard/hak-akses`.
15. Visit `/dashboard/layanan`.

Expected result:
- sidebar shows full admin web menu set
- `Profil` contains `Identitas`, `Struktur Organisasi`, `Informasi Pegawai`, `Fasilitas`
- `Layanan` contains `Informasi Pelayanan`, `Layanan`, `Tracking Layanan`
- `Publikasi` contains `Banner`, `Berita`, `Galeri`, `Pengumuman`, `Renstra`, `PPID`
- `Pengaturan` contains `Hak Akses`, `Master Tim`, `Master Survei`, `Sistem`
- `/dashboard/posts` opens successfully
- `/dashboard/pengumuman` opens successfully
- `/dashboard/ppid` opens successfully
- `/dashboard/situs-terkait` opens successfully
- `/dashboard/hak-akses` should open successfully
- `/dashboard/layanan` is allowed for this role

If failed:
- if `/dashboard/hak-akses` gives `500`, record runtime bug
- if expected menu missing, record sidebar mismatch

### 1.2 Admin Web - Editor

Credential:
- username/email: `editor@baltekrawa.go.id`
- password: `editor123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Go to `/dashboard/posts`.
4. Check the sidebar.
5. Click `Berita`.
6. Click `Galeri`.
7. Click `Pengumuman`.
8. Manually visit `/dashboard/hak-akses`.
9. Manually visit `/dashboard/ppid`.
10. Manually visit `/dashboard/layanan`.

Expected result:
- sidebar only shows publication menus
- visible menus are `Berita`, `Galeri`, `Pengumuman`
- `Dashboard`, `Profil`, `Layanan`, `Tautan`, `Pengaturan` are not visible
- `/dashboard/hak-akses` returns `403`
- `/dashboard/ppid` returns `403`
- `/dashboard/layanan` returns `403`

If failed:
- if restricted routes open, record RBAC leak
- if restricted routes return `500`, record runtime bug plus access-control mismatch

## 2. Admin Layanan

Reports covered:
- `docs/testing/admin-layanan/admin-layanan-master-report.md`
- `docs/testing/admin-layanan/admin-layanan-advis-report.md`
- `docs/testing/admin-layanan/admin-layanan-lab-report.md`
- `docs/testing/admin-layanan/admin-layanan-data-report.md`
- `docs/testing/admin-layanan/admin-layanan-lainnya-report.md`
- `docs/testing/admin-layanan/layanan-katim-report.md`
- `docs/testing/admin-layanan/layanan-analis-report.md`
- `docs/testing/admin-layanan/layanan-teknisi-report.md`

### 2.1 Admin Layanan - Master

Credential:
- username/email: `layanan@baltekrawa.go.id`
- password: `layanan123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Visit `/dashboard/layanan`.
4. Check the sidebar.
5. Click `Advis Teknik`.
6. Click `Laboratorium`.
7. Click `Data dan Informasi`.
8. Click `Layanan Lainnya`.
9. Click `Survei Kepuasan`.
10. Click `Data Pelanggan`.
11. Click `Dokumen Final`.
12. Manually visit `/dashboard/posts`.

Expected result:
- sidebar shows `Dashboard`, `Advis Teknik`, `Laboratorium`, `Data dan Informasi`, `Layanan Lainnya`, `Survei Kepuasan`, `Data Pelanggan`, `Dokumen Final`
- layanan pages open successfully
- `/dashboard/posts` returns `403`

If failed:
- if `/dashboard/posts` opens, record cross-area RBAC leak

### 2.2 Layanan - Katim

Credential:
- username/email: `katim@baltekrawa.go.id`
- password: `katim123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Visit `/dashboard/layanan`.
4. Check the sidebar.
5. Manually visit `/dashboard/layanan/data-pelanggan`.
6. Manually visit `/dashboard/layanan/survei-analytics`.
7. Manually visit `/dashboard/posts`.
8. Open one permohonan from `/dashboard/layanan/permohonan` or from the dashboard table if available.

Expected result:
- sidebar shows narrowed stage-role menu, not full layanan management menu
- current expected sidebar is `Dashboard`, `Permohonan`, optionally `Dokumen Final`
- `/dashboard/layanan/data-pelanggan` returns `403`
- `/dashboard/layanan/survei-analytics` returns `403`
- `/dashboard/posts` returns `403`

Note:
- this role is still generic `katim`, not service-specific `Advis/Data/Lab/Lainnya`
- use this test only to confirm current implemented restriction, not full spec parity

### 2.3 Layanan - Analis

Credential:
- username/email: `analis@baltekrawa.go.id`
- password: `analis123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Visit `/dashboard/layanan`.
4. Check the sidebar.
5. Manually visit `/dashboard/layanan/data-pelanggan`.
6. Manually visit `/dashboard/layanan/survei-analytics`.
7. Manually visit `/dashboard/posts`.
8. Open one permohonan detail if visible.

Expected result:
- sidebar shows only `Dashboard` and `Permohonan`
- `/dashboard/layanan/data-pelanggan` returns `403`
- `/dashboard/layanan/survei-analytics` returns `403`
- `/dashboard/posts` returns `403`

### 2.4 Layanan - Teknisi

Credential:
- username/email: `teknisi@baltekrawa.go.id`
- password: `teknisi123`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Visit `/dashboard/layanan`.
4. Check the sidebar.
5. Confirm `Data Pelanggan` is not visible.
6. Manually visit `/dashboard/layanan/data-pelanggan`.
7. Manually visit `/dashboard/layanan/survei-analytics`.
8. Manually visit `/dashboard/posts`.
9. Open one permohonan detail if visible.

Expected result:
- sidebar shows only `Dashboard` and `Permohonan`
- `Data Pelanggan` is not visible in sidebar
- `/dashboard/layanan/data-pelanggan` returns `403`
- `/dashboard/layanan/survei-analytics` returns `403`
- `/dashboard/posts` returns `403`

### 2.5 Admin Layanan - Advis

Status:
- blocked for manual test

Reason:
- no seeded role/user exists for `admin-layanan-advis`

What must exist first:
1. a role named `admin-layanan-advis`
2. a user assigned to that role
3. sidebar gating for advis-only menus

Expected result once implemented:
- sidebar shows `Advis Teknik` area only
- `Laboratorium`, `Data dan Informasi`, `Layanan Lainnya` are hidden

### 2.6 Admin Layanan - Lab

Status:
- blocked for manual test

Reason:
- no seeded role/user exists for `admin-layanan-lab`

What must exist first:
1. a role named `admin-layanan-lab`
2. a user assigned to that role
3. sidebar gating for lab-only menus

Expected result once implemented:
- sidebar shows `Laboratorium` area only
- `Advis Teknik`, `Data dan Informasi`, `Layanan Lainnya` are hidden

### 2.7 Admin Layanan - Data

Status:
- blocked for manual test

Reason:
- no seeded role/user exists for `admin-layanan-data`

What must exist first:
1. a role named `admin-layanan-data`
2. a user assigned to that role
3. sidebar gating for data-only menus

Expected result once implemented:
- sidebar shows `Data dan Informasi` area only
- `Advis Teknik`, `Laboratorium`, `Layanan Lainnya` are hidden

### 2.8 Admin Layanan - Lainnya

Status:
- blocked for manual test

Reason:
- no seeded role/user exists for `admin-layanan-lainnya`

What must exist first:
1. a role named `admin-layanan-lainnya`
2. a user assigned to that role
3. sidebar gating for lainnya-only menus

Expected result once implemented:
- sidebar shows `Layanan Lainnya` area only
- `Advis Teknik`, `Laboratorium`, `Data dan Informasi` are hidden

## 3. Pelanggan

Reports covered:
- `docs/testing/pelanggan/akun-pelanggan-report.md`

### 3.1 Akun Pelanggan

Credential:
- username/email: `yasir.haq98@gmail.com`
- password: `12345`

Steps:
1. Visit `/login`.
2. Login using the credential above.
3. Visit `/pelanggan`.
4. Check the sidebar.
5. Click `Ajukan Permohonan`.
6. Click `Tracking Layanan`.
7. Click `Pembayaran`.
8. Click `Dokumen`.
9. Click `Notifikasi`.
10. Click `Profil Pelanggan`.
11. Click `Bantuan`.
12. Manually visit `/dashboard`.

Expected result:
- sidebar shows `Dashboard`, `Ajukan Permohonan`, `Tracking Layanan`, `Pembayaran`, `Dokumen`, `Notifikasi`, `Profil Pelanggan`, `Bantuan`
- `/pelanggan` opens successfully
- `/pelanggan/permohonan` opens successfully
- `/pelanggan/dokumen` opens successfully
- `/dashboard` should not grant admin access

Current known issue:
- `/dashboard` may redirect to `/` and end in homepage `500`
- record that as public/home runtime bug, not valid pelanggan access

## 4. Public Pages

Purpose:
- manual verification for the public-facing pages covered by `tests/playwright/01-public-pages.spec.ts`
- use this to confirm public routes load without runtime errors

Scope:
- homepage and public content pages
- public service information pages
- public auth entry pages
- guest redirect behavior for protected routes

General notes:
- use a fresh incognito/private window
- stay logged out for all checks in this section
- if a route depends on seeded content, record missing content separately from runtime errors
- `404` can mean missing seeded data on detail pages
- `500` means runtime bug

### 4.1 Public Pages Core Sweep

Steps:
1. Visit `/`.
2. Confirm the page renders and contains `Pengumuman`.
3. Visit `/berita`.
4. Visit `/pengumuman`.
5. If seeded data exists, open the first `Pengumuman` detail from the `/pengumuman` list and confirm the URL uses a slug.
6. If the detail page loads and shows a `Buka Lampiran` button, click it and confirm the attachment modal opens.
7. Visit `/visi-misi`.
8. Visit `/tugas`.
9. Visit `/sejarah`.
10. Visit `/karya-ilmiah`.
11. Visit `/renstra`.
12. Visit `/struktur-organisasi`.
13. Visit `/info-pegawai`.
14. Visit `/fasilitas-balai`.
15. Visit `/foto`.
16. Visit `/video`.
17. Visit `/dokumen`.
18. Visit `/ppid`.
19. Visit `/pengujian-laboratorium`.
20. Visit `/advis-teknis`.

Expected result:
- all list and landing pages render without `500`
- homepage renders visible public content
- `/pengumuman` renders visible `Pengumuman` content
- `/renstra`, `/ppid`, and `/dokumen` open successfully
- service information pages open successfully
- if seeded detail content exists, a slug-based `/pengumuman/{slug}` detail page opens successfully
- if attachment UI is present, the attachment modal opens successfully

If failed:
- if any page returns `500`, record public runtime bug
- if a detail page returns `404`, record possible missing seeded data
- if modal trigger exists but modal does not open, record public interaction bug

### 4.2 Public Auth Entry Pages

Steps:
1. Visit `/login`.
2. Confirm email input, password input, and submit button are visible.
3. Visit `/register`.
4. Confirm email input and password input are visible.

Expected result:
- login page renders successfully
- register page renders successfully
- required auth form fields are visible

If failed:
- if page loads but form fields are missing, record auth UI regression
- if page returns `500`, record public auth runtime bug

### 4.3 Guest Redirect Checks

Steps:
1. Visit `/dashboard` while logged out.
2. Confirm the result redirects to `/login` or `/`.
3. Visit `/pelanggan` while logged out.
4. Confirm the result redirects to `/login` or `/verify-email`.

Expected result:
- guest access to `/dashboard` does not grant admin access
- guest access to `/pelanggan` does not grant pelanggan access
- redirects happen without `500`

If failed:
- if protected pages open directly, record access-control leak
- if redirect ends in `500`, record runtime bug on redirect target

Reference routes:
- `/`, `/berita`, `/visi-misi`, `/tugas`, `/sejarah`, `/karya-ilmiah`, `/renstra`, `/struktur-organisasi`
- `/info-pegawai`, `/fasilitas-balai`, `/foto`, `/video`, `/dokumen`, `/ppid`, `/pengumuman`
- `/pengujian-laboratorium`, `/advis-teknis`, `/login`, `/register`

## 5. Result Template

Use this when recording manual results:

```md
Role:
- admin-editor

Credential:
- editor@baltekrawa.go.id / editor123

Checks:
1. Login to `/login`
   Expected: login success
   Actual:

2. Visit `/dashboard/posts`
   Expected: page opens
   Actual:

3. Visit `/dashboard/layanan`
   Expected: 403
   Actual:

4. Sidebar visibility
   Expected: only Berita, Galeri, Pengumuman
   Actual:

Verdict:
- pass / fail

Notes:
- ...
```
