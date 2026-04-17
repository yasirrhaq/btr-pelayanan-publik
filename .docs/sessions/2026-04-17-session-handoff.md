# Session Handoff — 2026-04-17

## Scope Completed

### Public shell and content
- Unified public pages onto `mainTailwind`
- Fixed shared header/footer alignment
- Fixed footer text color consistency
- Refined public pages:
  - `visi-misi`
  - `tugas`
  - `sejarah`
  - `struktur-organisasi`
  - `info-pegawai`
  - `fasilitas-balai`
  - `advis-teknis`
  - `pengujian-laboratorium`

### Image and fallback handling
- Added local fallback handling in `app/Helper.php`
- Updated `KontenWebSeeder` with local dummy assets
- Seeded default images for sparse public content

### Berita and pengumuman
- Rebuilt public `/berita`
- Rebuilt `berita/{slug}` detail page
- Seeded dummy berita posts
- Switched berita list from broken AJAX flow to server-side rendering
- Added full-card click behavior and improved card layout
- Added partial remove support for berita image and pengumuman lampiran
- Replaced checkbox delete UX with preview-card + `X` remove UX

### Auth and admin role behavior
- Fixed pelanggan login redirect to pelanggan dashboard
- Fixed email validation to allow internal/demo domains
- Fixed admin layanan redirect to `/dashboard/layanan`
- Scoped editor/admin sidebar behavior
- Added mobile admin burger toggle and overlay
- Reduced oversized mobile logout button styling

### Homepage widgets
- Enhanced `Pelayanan Kami` cards
- Reworked `Informasi Permohonan Layanan`
- Switched layanan stats source from legacy `user_status_layanan` to real `permohonan`
- Mapped homepage buckets to real workflow statuses
- Reworked lab info cards to:
  - `Lab Air`
  - `Lab Tanah`
  - `Topografi`

### Galeri / publikasi
- Added migration to restore `galeri_foto.type`
- Enabled wizard-like tabs for:
  - `Foto`
  - `Video`
  - `Dokumen`
- Added type-aware upload flow in `FotoVideoController`
- Updated galeri show page for foto/video/dokumen rendering
- Seeded demo galeri video + dokumen rows
- Switched public `/video` page to use `galeri_foto.type = video`
- Removed `walls.io` usage from public video page

### PPID admin
- Moved PPID under `Publikasi` in sidebar
- Built new PPID tabbed admin page matching design direction
- Added dedicated `PpidController`
- Auto-created PPID landing page types:
  - `Kebijakan PPID`
  - `Info Berkala`
  - `Info Serta Merta`
  - `Info Setiap Saat`
- Added file upload and preview handling for PPID
- Replaced plain textarea with `Jodit`
- Added attachment upload endpoint for editor content

### Editor standardization
- Replaced `/dashboard/ppid` rich text editor with `Jodit`
- Replaced `/dashboard/posts/create` and `/dashboard/posts/{slug}/edit` rich text editor with `Jodit`
- Added post editor image upload endpoint in `DashboardPostController`
- Removed old `Trix` usage from post create/edit forms

### Profil identitas admin
- Rebuilt `/dashboard/profil-singkat` into tabbed admin flow based on `design/Admin Web/Profil/Identitas`
- Added tabs:
  - `Tentang Kami`
  - `Sejarah`
  - `Visi & Misi`
  - `Tugas & Fungsi`
  - `Maskot`
- Wired admin saves into existing public content sources:
  - `Tentang Kami` -> `UrlLayanan`
  - `Maskot` -> `UrlLayanan`
  - `Sejarah` -> `LandingPage`
  - `Visi / Misi` -> `LandingPage`
  - `Tugas / Fungsi` -> `LandingPage`
- Added Jodit upload endpoint for profil editor content
- Updated homepage `Tentang Kami` to render managed rich text and image
- Updated public `visi-misi` and `tugas` pages to render managed images when present

### Profil SDM / admin chrome
- Upgraded `/dashboard/info-pegawai` to support structured employee data:
  - `nip`
  - `jenis_kepegawaian`
  - `pangkat_golongan`
  - `jabatan`
  - `instansi`
  - `email`
- Added `urutan` field for employee display order and wired admin/public sorting to it
- Added photo-only remove support on employee edit form without deleting the record
- Seeded real employee records from existing `public/assets/info-pegawai*.jpg` reference sheets
- Changed public `/info-pegawai` cards to use structured fields and initials fallback when no standalone photo exists
- Updated admin sidebar:
  - real BTR logo mark on the left using `assets/logo.png`
  - `Informasi Pegawai` and `Struktur Organisasi` split into separate profile submenu items
  - `Layanan` converted into grouped submenu
  - logout button now uses power icon
- Updated admin topbar:
  - profile block now opens dropdown actions instead of direct-link navigation
  - added current `menu / submenu / subsubmenu` context mapping based on route and active tab

### Public navigation and pelanggan shell
- Reworked public topbar dropdowns to follow the approved grouped structure:
  - `Profil`
  - `Layanan`
  - `Publikasi`
  - `Saran dan Pengaduan`
- Changed desktop public nav so subsubmenu items only appear when hovering the submenu item
- Added public `/dokumen` page and route
  - aggregates `pengumuman.lampiran_path`
  - aggregates `galeri_foto.type = dokumen`
  - also scans berita body links for direct document files when present
- Updated public `Dokumen` menu item to point to the new public page
- Restyled pelanggan shell to match the newer admin visual language while keeping pelanggan-specific navigation:
  - sidebar now uses `assets/logo.png`
  - top-right user block now opens a dropdown
  - logout uses the power icon style
  - mobile sidebar now uses the same body-toggle behavior as admin
- Consolidated admin and pelanggan topbar markup into one shared partial:
  - `resources/views/partials/btr/topbar.blade.php`
  - admin and pelanggan wrappers now pass role label and dropdown links only
- Normalized pelanggan topbar CSS closer to admin topbar so both shells read as one system
- Removed stale admin dropdown link to `/profile/status-layanan`

### Pelanggan profile flow
- Consolidated customer account flow around `/pelanggan/profil`
- Added `Pelanggan\ProfilController`
- Added `/pelanggan/profil/edit` for full profile editing
- Legacy `/profile` and `/profile/password` now redirect into pelanggan profile flow
- Editable profile fields now include:
  - `Nama Pelanggan`
  - `Email`
  - `Kategori Instansi`
  - `Nama Instansi`
  - `No. Telp (wa)`
  - `Alamat`
  - `Foto Profil`
- Non-editable profile identifiers remain:
  - `Username`
  - `NIK / No. Paspor / NIM`
- Password remains in dedicated flow at `/pelanggan/profil/password`
- Fixed `kategori_instansi` profile edit bug:
  - replaced invalid `orderBy('name')` with `orderBy('nama')`
  - fixed select option labels to use `nama`
  - replaced brittle Blade selected directive with explicit `selected` output

### Shared shell cleanup
- Extracted shared alert rendering into:
  - `resources/views/partials/btr/alerts.blade.php`
- Extracted shared shell JS into:
  - `resources/views/partials/btr/shell-scripts.blade.php`
- Rewired these layouts to use the shared partials:
  - `dashboard.layouts.main`
  - `pelanggan.layouts.main`
  - `profile.layouts.main`
- Current shared-shell status:
  - topbar markup shared
  - shell alerts shared
  - shell JS shared
  - sidebars still separate by area

### Karya ilmiah / renstra
- Public `karya-ilmiah` routes/menu removed earlier per request
- Admin `Renstra` restored after clarification
- Current state:
  - admin `Renstra` still exists
  - public `karya-ilmiah` remains removed

## Important Files Changed

- `app/Helper.php`
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/LoginController.php`
- `app/Http/Controllers/PostController.php`
- `app/Http/Controllers/DashboardPostController.php`
- `app/Http/Controllers/VideoController.php`
- `app/Http/Controllers/Admin/PengumumanController.php`
- `app/Http/Controllers/Admin/PpidController.php`
- `app/Http/Controllers/Admin/GaleriFotoVideo/FotoVideoController.php`
- `app/Http/Controllers/AdminProfilSingkatController.php`
- `database/seeders/KontenWebSeeder.php`
- `database/migrations/2026_04_17_000004_add_urutan_to_info_pegawai_table.php`
- `database/seeders/LayananOperasionalSeeder.php`
- `database/migrations/2026_04_17_000002_add_type_back_to_galeri_foto_table.php`
- `resources/views/frontend/home.blade.php`
- `resources/views/frontend/video.blade.php`
- `resources/views/frontend/visimisi.blade.php`
- `resources/views/frontend/tugas.blade.php`
- `resources/views/frontend/beritaDetail.blade.php`
- `resources/views/berita/index.blade.php`
- `resources/views/dashboard/ppid/index.blade.php`
- `resources/views/dashboard/posts/create.blade.php`
- `resources/views/dashboard/posts/edit.blade.php`
- `resources/views/dashboard/profil-singkat/index.blade.php`
- `resources/views/dashboard/profil-singkat/edit.blade.php`
- `app/Http/Controllers/AdminInfoPegawaiController.php`
- `resources/views/dashboard/info-pegawai/index.blade.php`
- `resources/views/dashboard/info-pegawai/create.blade.php`
- `resources/views/dashboard/info-pegawai/edit.blade.php`
- `resources/views/dashboard/info-pegawai/show.blade.php`
- `resources/views/frontend/info-pegawai.blade.php`
- `resources/views/dashboard/layouts/sidebar.blade.php`
- `resources/views/dashboard/layouts/header.blade.php`
- `resources/views/frontend/partials/headerTailwind.blade.php`
- `resources/views/frontend/partials/footerTailwind.blade.php`
- `resources/views/frontend/dokumen.blade.php`
- `app/Http/Controllers/PublicDokumenController.php`
- `resources/views/pelanggan/layouts/main.blade.php`
- `resources/views/pelanggan/layouts/sidebar.blade.php`
- `resources/views/pelanggan/layouts/header.blade.php`
- `resources/views/partials/btr/topbar.blade.php`
- `resources/views/partials/btr/alerts.blade.php`
- `resources/views/partials/btr/shell-scripts.blade.php`
- `app/Http/Controllers/Pelanggan/ProfilController.php`
- `resources/views/pelanggan/profil/edit.blade.php`
- `resources/views/pelanggan/profil/password.blade.php`
- `routes/web.php`
- `public/css/admin.css`
- `public/css/pelanggan.css`

## DB / Seeder State

- `KontenWebSeeder` seeded berita and galeri demo content
- `KontenWebSeeder` now also seeds structured `info_pegawai` rows from current asset references
- `LayananOperasionalSeeder` seeded demo layanan stats rows earlier, but homepage widget now reads from real `permohonan`
- `galeri_foto.type` restored via migration and backfilled to `image`

## Verified Commands Run

```bash
docker compose up -d
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --class="Database\Seeders\KontenWebSeeder"
docker compose exec app php artisan db:seed --class="Database\Seeders\LayananOperasionalSeeder"
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear
```

## Current Open Questions / Follow-up

1. PPID editor
- Jodit loaded from CDN
- rich editing works
- image upload wired to Laravel endpoint

2. Profil identitas follow-up
- `Maskot` admin tab now stores content/image
- no dedicated public `maskot` page has been wired yet
- if client wants public mascot page/section later, add route + frontend block

3. Renstra vs dokumen
- admin `Renstra` kept
- public `karya-ilmiah` removed
- product meaning between `Renstra`, `dokumen`, and former public `karya-ilmiah` should be finalized later

4. Admin dead code
- some old controllers/views remain even where routes/menu changed
- can be cleaned later if client confirms

5. Dokumen source coverage
- public `/dokumen` now surfaces real file sources that exist today:
  - pengumuman lampiran
  - galeri dokumen
  - berita body-linked files if any exist
- berita still does not have a dedicated attachment column like pengumuman

6. Shared shell refactor status
- topbar/header is now shared between admin and pelanggan
- main shell wrappers and sidebars are still separate files
- they can be consolidated further later if needed, but current highest-value duplication is already reduced

7. Tailwind CDN warning
- still present in browser console on frontend/admin pages using CDN script
- non-blocking, but should move to compiled asset flow later

## Suggested Next Steps

1. Test PPID end-to-end
- open `/dashboard/ppid`
- save each tab
- verify uploaded file preview and editor content persist

2. Test profil identitas end-to-end
- open `/dashboard/profil-singkat`
- save each tab
- verify `Tentang Kami`, `Sejarah`, `Visi & Misi`, `Tugas & Fungsi`, `Maskot`
- verify homepage and public profile pages reflect changes

3. Decide final doc architecture
- `Renstra`
- `PPID`
- `Dokumen`
- public document page strategy

4. Next queued UI work
- validate seeded employee roster against latest client master list
- decide whether standalone per-employee photos should be uploaded later for rows currently using initials fallback

5. If ready, create commit for remaining uncommitted work and push
