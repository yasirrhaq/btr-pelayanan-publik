# Bug Fix And Live CRUD Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Stabilize backend-connected pages, capture the bug inventory in `BUG_LIST.md`, add live CRUD coverage, and update the audit documentation with verified results.

**Architecture:** Start from the live runtime failures already reproduced in Playwright, fix the shared view/model mismatches causing crashes, then add targeted Playwright CRUD flows for the affected admin and pelanggan paths. Keep changes minimal and local: prefer model accessors for schema/view compatibility, fix Blade/runtime errors directly, then tighten workflow UI guards to match backend rules.

**Tech Stack:** Laravel 8, Blade, MySQL via Docker Compose, Playwright, PHP 8.2

---

### Task 1: Record the bug inventory

**Files:**
- Create: `BUG_LIST.md`
- Modify: `docs/testing/CRUD_AUDIT_REPORT.md`

**Step 1:** List confirmed runtime bugs from Playwright and prior audits.

**Step 2:** Group by severity, route, root cause, and status.

**Step 3:** Mark which bugs will be fixed in this pass and which remain deferred.

### Task 2: Fix shared runtime view crashes

**Files:**
- Modify: `resources/views/dashboard/pengumuman/index.blade.php`
- Modify: `resources/views/dashboard/layanan/index.blade.php`
- Modify: `resources/views/dashboard/layanan/show.blade.php`
- Modify: `resources/views/dashboard/layanan/survei-analytics.blade.php`
- Modify: `resources/views/dashboard/foto-layanan/index.blade.php`

**Step 1:** Replace unqualified `Str::limit(...)` usage with `\Illuminate\Support\Str::limit(...)`.

**Step 2:** Rerun the failing Playwright pages to verify the 500 errors are gone.

### Task 3: Fix schema/view compatibility mismatches

**Files:**
- Modify: `app/Models/JenisLayanan.php`
- Modify: `resources/views/pelanggan/profil/index.blade.php`

**Step 1:** Add a compatibility accessor so legacy Blade calls to `nama` resolve from the real `name` column.

**Step 2:** Replace pelanggan profile usage of `nama_instansi` with the real `instansi` field.

**Step 3:** Rerun pelanggan Playwright coverage.

### Task 4: Fix permohonan detail relation and workflow guard mismatches

**Files:**
- Modify: `resources/views/dashboard/layanan/show.blade.php`
- Modify: `app/Http/Controllers/Admin/Layanan/PermohonanManagementController.php`

**Step 1:** Update survey rendering to match the `hasOne` `surveiKepuasan` relationship.

**Step 2:** Limit assign-tim and billing UI/actions to states allowed by `Permohonan::allowedTransitions()`.

**Step 3:** Add defensive controller checks that return a user-facing error instead of throwing if a forbidden transition is attempted.

### Task 5: Add live CRUD regression tests

**Files:**
- Modify: `tests/playwright/03-admin-web.spec.ts`
- Modify: `tests/playwright/04-admin-layanan.spec.ts`
- Modify: `tests/playwright/05-pelanggan-portal.spec.ts`

**Step 1:** Add a safe create/delete flow for `Pengumuman`.

**Step 2:** Add a safe pelanggan tracking/detail sanity flow and an admin layanan detail navigation flow.

**Step 3:** Keep test data self-cleaning where possible.

### Task 6: Run verification and refresh docs

**Files:**
- Modify: `docs/testing/CRUD_AUDIT_REPORT.md`
- Modify: `docs/testing/UI_UX_AUDIT_REPORT.md`
- Modify: `docs/testing/SECURITY_AUDIT_REPORT.md`
- Modify: `BUG_LIST.md`

**Step 1:** Run `npx playwright test --reporter=list`.

**Step 2:** Update docs with pass/fail counts, fixed bugs, and any remaining defects.

**Step 3:** Mark bug statuses in `BUG_LIST.md` as fixed or remaining.
