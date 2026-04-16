# Sejarah Berita Redesign Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Upgrade `sejarah`, `berita`, and `beritaDetail` public pages and seed realistic local dummy posts.

**Architecture:** Build one custom `sejarah` layout instead of shared profile partial. Rework `berita` list and detail pages around local assets and modern card/article patterns. Seed news content directly in `KontenWebSeeder` using existing `Category` and `Post` models.

**Tech Stack:** Laravel 8, Blade, Eloquent seeders, local public assets.

---

### Task 1: Seed dummy berita posts

**Files:**
- Modify: `database/seeders/KontenWebSeeder.php`

**Steps:**
1. Add 4-6 realistic BTR post records.
2. Map each post to existing seeded categories.
3. Use only local asset paths for images.

### Task 2: Redesign sejarah page

**Files:**
- Modify: `resources/views/frontend/sejarah.blade.php`

**Steps:**
1. Replace shared partial call with dedicated split layout.
2. Render text and one fallback-safe image.
3. Match current public design tokens.

### Task 3: Redesign berita list page

**Files:**
- Modify: `resources/views/frontend/berita.blade.php`

**Steps:**
1. Add stronger page hero.
2. Show latest post as featured block.
3. Render remaining posts in cleaner responsive cards.

### Task 4: Redesign berita detail page

**Files:**
- Modify: `resources/views/frontend/beritaDetail.blade.php`

**Steps:**
1. Remove cramped legacy layout.
2. Add article-first detail view with sidebar for latest posts.
3. Use local fallback images.

### Task 5: Verify rendering assumptions

**Files:**
- Inspect: `resources/views/frontend/sejarah.blade.php`
- Inspect: `resources/views/frontend/berita.blade.php`
- Inspect: `resources/views/frontend/beritaDetail.blade.php`
- Inspect: `database/seeders/KontenWebSeeder.php`

**Steps:**
1. Confirm no remote news image fallback remains.
2. Confirm seeded posts work with current `PostController` queries.
3. Confirm pages stay on `frontend.layouts.mainTailwind`.
