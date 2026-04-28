# Image Optimization Design

Date: 2026-04-27

## Goal

Allow normal staff photo uploads without frustrating size errors, while keeping public images web-friendly and storage-efficient.

## Agreed Policy

- Public images do not expire.
- Downloadable files/document retention is a separate future feature.
- Raw image uploads should allow normal phone photos.
- Images should be resized/compressed automatically after upload.
- Do not aggressively degrade quality.

## Implemented Direction

- Raise raw image validation limit to `12 MB` for:
  - berita main image
  - berita Jodit embedded image uploads
  - pengumuman thumbnail
  - pengumuman Jodit embedded image uploads
- Raise PHP container limits to:
  - `upload_max_filesize=20M`
  - `post_max_size=24M`
  - `memory_limit=256M`
- Resize oversized images to max `1600px` long edge.
- Preserve aspect ratio.
- Do not upscale smaller images.
- Preserve image format by default (`jpg/png/webp`), with optimization applied on save.
- Keep `gif` uploads as original files instead of trying to transform them.

## Why

- Staff often upload phone photos larger than `5 MB`.
- Website display does not benefit from raw multi-megapixel originals.
- Server-side optimization reduces storage and page weight without needing users to pre-edit files manually.

## Verification

- Rebuilt Docker app with new PHP limits.
- Confirmed live PHP values inside container.
- Passed focused Playwright checks for:
  - pengumuman Jodit create/public render
  - affected admin pengumuman form/create-delete checks
