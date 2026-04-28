# 2026-04-28 Managed Video Embed And Public Video Refresh

## Scope
- upgraded galeri video from upload-only records into managed video sources
- added YouTube support alongside local uploaded video files
- added stable public embed route for reuse inside Jodit content
- refreshed public `/video` page with category filter, search, and custom pagination

## Key Changes
- `galeri_foto` now carries:
  - `slug`
  - `category`
  - `source_type`
  - `source_url`
- `path_image` is now nullable so YouTube-backed records do not require a local file
- admin galeri video create/edit:
  - category select
  - source type select (`upload` / `youtube`)
  - YouTube URL input
- admin video list/detail:
  - `Copy URL`
  - `Copy Embed`
- public routes:
  - `/video`
  - `/video/embed/{slug}`

## Embed Model
- berita/pengumuman should paste the managed iframe snippet, not raw YouTube links
- embed route stays stable even if admin later changes the underlying video source on the same record
- slug is created on record creation and kept stable on later edits

## Verification
- `php -l` passed for touched PHP files
- migrations applied:
  - `2026_04_28_000001_add_video_fields_to_galeri_foto_table`
  - `2026_04_28_000002_make_path_image_nullable_on_galeri_foto_table`
- `php artisan route:list --name=video` confirms:
  - `video.index`
  - `video.embed`
- Playwright:
  - `tests/playwright/03-admin-web.spec.ts -g "Galeri video supports YouTube source and managed embed route"` passed
  - `tests/playwright/01-public-pages.spec.ts -g "Galeri Video page loads"` passed
