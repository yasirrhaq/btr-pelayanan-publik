# Public Page Image Fallback Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Make unified public pages resilient and visually roomy by seeding local dummy images and refactoring the affected Blade pages to use safe fallbacks and improved spacing.

**Architecture:** Keep one public layout (`mainTailwind`) and fix the unstable pages at the content layer. Centralize image fallback behavior in helpers and Blade templates, then modernize the affected pages into a few reusable presentation patterns instead of relying on cramped legacy wrappers.

**Tech Stack:** Laravel 8, Blade, Bootstrap compatibility CSS, Tailwind utility classes, PHP seeders.

---

### Task 1: Seed local fallback images

**Files:**
- Modify: `database/seeders/KontenWebSeeder.php`

**Steps:**
1. Replace empty `path_image` defaults for seeded `InfoPegawai`, `StrukturOrganisasi`, and `FasilitasBalai` records with local asset paths.
2. Add sensible local banner/gallery fallbacks only where they improve first-run UI.
3. Keep seeding idempotent by preserving existing `count()`/`firstOrCreate()` logic.

### Task 2: Strengthen shared image fallback behavior

**Files:**
- Modify: `app/Helper.php`

**Steps:**
1. Make `imageExists()` work with public relative paths instead of `file_exists($path)` on raw strings.
2. Use a local fallback asset instead of remote Unsplash.
3. Preserve compatibility with existing views that already call `imageExists()`.

### Task 3: Refactor shared landing-page content rendering

**Files:**
- Modify: `resources/views/frontend/layouts/landing-page-content.blade.php`

**Steps:**
1. Replace cramped Bootstrap-only wrappers with a roomier section/article structure.
2. Add safe image fallback rendering for optional landing-page images.
3. Constrain text width for readability.

### Task 4: Refactor image-heavy public pages

**Files:**
- Modify: `resources/views/frontend/struktur.blade.php`
- Modify: `resources/views/frontend/info-pegawai.blade.php`
- Modify: `resources/views/frontend/fasilitas-balai.blade.php`

**Steps:**
1. Replace direct raw image output with fallback-aware cards/figure blocks.
2. Add roomier vertical rhythm and clearer section headings.
3. Keep pagination intact.

### Task 5: Refactor service pages

**Files:**
- Modify: `resources/views/frontend/advis-teknis.blade.php`
- Modify: `resources/views/frontend/pengujian-laboratorium.blade.php`

**Steps:**
1. Convert the content into responsive two-column hero/detail cards.
2. Use fallback-aware image rendering.
3. Keep current CTA behavior (`/login` for guests, service URL for authenticated users).

### Task 6: Verify scope and regressions

**Files:**
- Inspect: affected public Blade files

**Steps:**
1. Confirm all targeted pages still extend `frontend.layouts.mainTailwind`.
2. Confirm no targeted page directly depends on empty `path_image` values anymore.
3. Summarize any remaining pages that still need full redesign later.
