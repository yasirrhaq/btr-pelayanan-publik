# Public Page Image Fallback Design

> Superseded in part on 2026-04-17.
> `info-pegawai` is no longer planned as a temporary image-overview page.
> Current implementation uses structured employee records, card layout, optional standalone photos, and initials fallback when no photo exists.

**Goal:** Stabilize the public-facing profile and service pages after the layout unification by combining better spacing, safer image fallbacks, and seeded dummy images.

**Approved Direction:** Hybrid fix. We will improve both content data and presentation. Empty image paths in seeded content will be replaced with local dummy assets, and the affected Blade views will stop assuming every record has a valid image.

**Scope:**
- `visi-misi`, `tugas`, `sejarah`
- `struktur-organisasi`
- `info-pegawai`
- `fasilitas-balai`
- `advis-teknis`
- `pengujian-laboratorium`

**Design Notes:**
- Use the unified public shell in `resources/views/frontend/layouts/mainTailwind.blade.php`
- Increase breathing room with larger section padding, centered headings, constrained readable text width, and card-based image presentation
- Replace brittle direct `asset($item->path_image)` rendering with safe fallback logic
- Prefer local assets over remote placeholders so the pages render consistently offline and in tests
- Keep `info-pegawai.jpg` only as historical source/reference asset; the public employee page is now fully data-driven

**Fallback Asset Strategy:**
- Informational landing pages: `assets/balaiRawa.png`
- Structure image: `assets/struktur.png`
- Employee reference sheets: `assets/info-pegawai.jpg` and `assets/info-pegawai-non-pns.jpg`
- Facilities and gallery-like cards: `assets/fotoDumy.jpeg`
- Service pages: `assets/advis-gambar.png`

**Data Strategy:**
- Update `database/seeders/KontenWebSeeder.php` so default seeded records use local assets instead of empty strings where that improves first-run UX
- Preserve future dynamic behavior by keeping view-level fallbacks in place even after seeding is improved

**Implementation Constraints:**
- Do not assume DB is fully populated
- Do not rely on remote image services
- Avoid reintroducing the old `mainNew` layout or legacy page shell
