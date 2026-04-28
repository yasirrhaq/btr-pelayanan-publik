# Session Report — Public Pages and Berita Refresh

Date: 2026-04-16

## Scope

- Unify public page shell under `mainTailwind`
- Fix mismatched public header/footer behavior
- Add local image fallback strategy for sparse content data
- Seed realistic dummy berita content
- Rebuild `/berita` and `berita/{slug}` UI

## Completed

### Public shell cleanup

- Migrated remaining public pages away from `mainNew` / `main`
- Added `@yield('customCss')` support and jQuery compatibility in `resources/views/frontend/layouts/mainTailwind.blade.php`
- Fixed footer text color inheritance in `resources/views/frontend/partials/footerTailwind.blade.php`

### Public content page redesign

- `resources/views/frontend/visimisi.blade.php` → text-first polished layout
- `resources/views/frontend/tugas.blade.php` → text-first polished layout
- `resources/views/frontend/sejarah.blade.php` → split layout with supporting image
- `resources/views/frontend/struktur.blade.php` → simplified image-first layout
- `resources/views/frontend/info-pegawai.blade.php` → simplified image-only layout
- `resources/views/frontend/fasilitas-balai.blade.php` → card layout with safe image fallback
- `resources/views/frontend/advis-teknis.blade.php` and `resources/views/frontend/pengujian-laboratorium.blade.php` → cleaner responsive service layouts
- `resources/views/frontend/layouts/landing-page-content.blade.php` → modernized shared profile renderer

### Fallback image strategy

- `app/Helper.php` now resolves local public assets and falls back to `assets/fotoDumy.jpeg`
- `database/seeders/KontenWebSeeder.php` now seeds and backfills local dummy images for:
  - banner
  - info pegawai
  - struktur organisasi
  - fasilitas balai
  - galeri foto

### Berita refresh

- Seeded 5 realistic dummy berita posts in `database/seeders/KontenWebSeeder.php`
- Rebuilt `resources/views/frontend/beritaDetail.blade.php`
- Rebuilt `resources/views/berita/index.blade.php`
- Replaced legacy AJAX rendering with server-side filtering and pagination in `app/Http/Controllers/PostController.php`
- Set berita pagination to 4 items per page
- Made whole cards clickable
- Added category badge highlight using `#FEF3C7`
- Standardized local image fallback on berita list and detail pages

## Bugs fixed during session

- `/berita` used wrong legacy Blade view
- `/berita` shell mismatched header/footer styling
- `/berita` AJAX broke from missing `BASE_URL`
- `/berita` AJAX returned `419` from missing CSRF header
- `/berita` repeated loading state on every page load
- profile/service pages broke visually when `path_image` data was empty

## Commands run

```bash
docker compose exec app php artisan db:seed --class="Database\Seeders\KontenWebSeeder"
docker compose exec app php artisan view:clear
docker compose exec app php artisan migrate:status
docker compose exec db mysql -ularavel -plaravel -D pupr -e "SELECT COUNT(*) AS posts_count FROM posts;"
```

## Result

- Docker-based seeding succeeded
- `posts_count = 5`
- `/berita` now renders directly from server with filtering and pagination
- public profile/service pages now share one visual shell and local fallback image behavior

## Follow-up

- Replace Tailwind CDN with compiled asset pipeline for production
- Convert info pegawai from image-only placeholder to real per-pegawai card data model later
- Consider same modernization pass for `foto`, `video`, and `karyailmiah`
