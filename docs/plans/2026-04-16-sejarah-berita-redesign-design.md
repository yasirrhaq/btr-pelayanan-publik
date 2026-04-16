# Sejarah Berita Redesign Design

**Goal:** Refine `sejarah` and `berita` public experience with stronger presentation, local image fallback, and seeded dummy news content.

**Approved Direction:**
- `sejarah` keeps image support
- `berita` list gets enhanced layout
- `beritaDetail` gets redesigned too
- seed 4-6 realistic dummy BTR posts with local assets

**Design Notes:**
- `sejarah` uses split layout: readable text + one supporting historical image
- `berita` uses hero header, featured latest story, then clean news grid
- `beritaDetail` uses same visual system as list page for continuity
- all post image fallback uses local assets only
- seeded content should feel plausible for BTR operations: layanan, laboratorium, survei lapangan, workshop, kunjungan, inovasi rawa

**Fallback Assets:**
- `assets/sejarah pupr.png`
- `assets/beritautama.png`
- `assets/beritaterkini1.png`
- `assets/beritaterkini2.png`
- `assets/fotoBaner.png`
- `assets/balaiRawa.png`
