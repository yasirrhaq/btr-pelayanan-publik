# Pengumuman Attachment Modal Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Make pengumuman attachments preview in a modal on admin and public pages, and ensure admin delete also removes the stored attachment file.

**Architecture:** Centralize the attachment metadata in Blade via small per-item data attributes and render one reusable modal per page using Alpine. On delete, remove the file from the `public` storage disk before soft-deleting the record so the database and filesystem stay in sync.

**Tech Stack:** Laravel 8, Blade, Alpine.js, Storage facade, Playwright

---

### Task 1: Fix attachment cleanup on delete

**Files:**
- Modify: `app/Http/Controllers/Admin/PengumumanController.php`

**Step 1:** Import the storage facade.

**Step 2:** Delete the old attachment file from the `public` disk before deleting the record.

**Step 3:** Keep the delete safe when there is no file.

### Task 2: Add admin preview modal

**Files:**
- Modify: `resources/views/dashboard/pengumuman/index.blade.php`

**Step 1:** Replace the `target="_blank"` attachment link with a preview trigger button.

**Step 2:** Add one Alpine-powered modal that supports image, PDF iframe, and download fallback.

**Step 3:** Keep the admin table layout intact.

### Task 3: Add public preview modal

**Files:**
- Modify: `resources/views/frontend/pengumuman/index.blade.php`
- Modify: `resources/views/frontend/pengumuman/show.blade.php`

**Step 1:** Replace public attachment links/buttons with modal triggers.

**Step 2:** Reuse the same preview rules: image, PDF iframe, unsupported download fallback.

**Step 3:** Keep the existing page design and copy intact.

### Task 4: Verify live behavior

**Files:**
- Modify: `tests/playwright/01-public-pages.spec.ts`
- Modify: `tests/playwright/03-admin-web.spec.ts`

**Step 1:** Add a public pengumuman modal-open assertion.

**Step 2:** Add an admin pengumuman modal-open assertion.

**Step 3:** Run both test files and confirm no regressions.
