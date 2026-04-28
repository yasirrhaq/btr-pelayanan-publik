# Pengumuman Jodit Design

Date: 2026-04-27

## Goal

Make admin `pengumuman` use the same rich-text editing flow as `berita`, including inline image upload from Jodit, so embedded images can be rendered publicly and extracted by the foto gallery.

## Chosen Approach

Reuse the existing `berita` Jodit pattern with a dedicated `pengumuman` upload endpoint.

- Add `admin.pengumuman.attachment` for Jodit image uploads.
- Keep uploads image-only to match the existing `berita` editor behavior.
- Replace plain textarea usage in admin create/edit with Jodit.
- Render `pengumuman->isi` as trusted HTML on the public detail page when rich markup exists.
- Preserve old plain-text rows by falling back to escaped text with line breaks when the content does not contain HTML.

## Why

- Minimal new behavior: same editor contract, same upload shape, separate folder.
- Supports embedded gallery images without inventing a second content model.
- Avoids breaking older pengumuman records that were written as plain text.

## Verification

- Lint `PengumumanController.php` and `routes/web.php`.
- Confirm `dashboard/pengumuman/attachment` route is registered.
- Manually test admin create/edit image insertion and public rendering.
