# Homepage Pengumuman Restoration Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Restore the homepage `Pengumuman` ticker so it uses real `pengumuman` data while keeping `Berita Terkini` backed by `posts`.

**Architecture:** Query active/published `Pengumuman` records separately in the homepage controller and pass them as their own dataset. Update the homepage ticker view to render `pengumuman` titles and keep the lower news section unchanged, then verify with a live homepage test.

**Tech Stack:** Laravel 8, Blade, MySQL via Docker, Playwright

---

### Task 1: Wire homepage controller data

**Files:**
- Modify: `app/Http/Controllers/HomeController.php`

**Step 1:** Import `App\Models\Pengumuman`.

**Step 2:** Query active/latest homepage announcements.

**Step 3:** Pass them to `frontend.home` as a separate variable from `terkini`.

### Task 2: Restore homepage ticker binding

**Files:**
- Modify: `resources/views/frontend/home.blade.php`

**Step 1:** Change the top ticker condition to use the new `pengumuman` collection.

**Step 2:** Render date + title from `pengumuman` rows instead of `posts`.

**Step 3:** Keep the lower `Berita Terkini` section untouched.

### Task 3: Add regression coverage

**Files:**
- Modify: `tests/playwright/01-public-pages.spec.ts`

**Step 1:** Add a homepage assertion that the ticker renders without app error.

**Step 2:** Prefer a structural assertion that does not require specific seeded text.

### Task 4: Verify live behavior

**Files:**
- Modify: `BUG_LIST.md`
- Modify: `.docs/CRUD_AUDIT_REPORT.md`

**Step 1:** Run the relevant Playwright public page test file.

**Step 2:** If homepage ticker is restored, note the fix in docs.
