# UI/UX Audit Report

Date: 2026-04-14
Repository: `btr-pelayanan-publik`
Method: code audit against current Blade templates and Vercel Web Interface Guidelines

## Runtime Note

- App was recovered and browser automation was executed through Playwright after recreating nginx.
- Final live Playwright verification now passes `68/68` tests.
- Confirmed visual runtime issue: admin dashboard requests `/img/mascot.png` and receives `404`, leaving a broken illustration slot on the dashboard.

## Scope

- Public header and navigation
- Login and register flows
- Pelanggan submission wizard
- Admin sidebar and major action screens
- Representative dashboard/admin patterns reused across the app

## Critical Findings

### Accessibility

- `resources/views/frontend/partials/headerTailwind.blade.php:17` - search input has no visible `<label>` and no `aria-label`.
- `resources/views/frontend/partials/headerTailwind.blade.php:19` - icon-only search submit button lacks `aria-label`.
- `resources/views/frontend/partials/headerTailwind.blade.php:120` - desktop dropdown trigger button has no expanded state attributes and relies on hover behavior for access.
- `resources/views/frontend/partials/headerTailwind.blade.php:135` - same issue for Layanan dropdown.
- `resources/views/frontend/partials/headerTailwind.blade.php:147` - same issue for Publikasi dropdown.
- `resources/views/frontend/partials/headerTailwind.blade.php:161` - same issue for Saran dan Pengaduan dropdown.
- `resources/views/login/index.blade.php:137` - password visibility toggle is icon-only and lacks `aria-label`.
- `resources/views/register/index.blade.php:142` - password visibility toggle is icon-only and lacks `aria-label`.
- `resources/views/register/index.blade.php:169` - confirm-password visibility toggle is icon-only and lacks `aria-label`.
- `resources/views/dashboard/master-tim/create.blade.php:53` - delete-row icon button uses `title` only; missing `aria-label`.
- `resources/views/dashboard/master-tim/edit.blade.php:51` - same issue.

### Focus states

- `resources/views/frontend/partials/headerTailwind.blade.php:18` - `focus:outline-none` on search input with no visible focus replacement.
- `resources/views/frontend/partials/headerTailwind.blade.php:193` - same issue on mobile search input.
- `resources/views/login/index.blade.php:177` - `focus:outline-none` is paired with ring styling, acceptable.
- `resources/views/register/index.blade.php:318` - `focus:outline-none` is paired with ring styling, acceptable.

## Major Findings

### Forms

- `resources/views/pelanggan/tracking/index.blade.php:9` - tracking input lacks a `<label>` or `aria-label`.
- `resources/views/frontend/partials/headerTailwind.blade.php:17` - search field lacks autocomplete hints and a programmatic label.
- `resources/views/login/index.blade.php:105` - email input has a label, but no explicit `autocomplete="email"`.
- `resources/views/register/index.blade.php:76` - name input has no `autocomplete`.
- `resources/views/register/index.blade.php:93` - username input has no `autocomplete`, and should usually disable spellcheck.
- `resources/views/register/index.blade.php:198` - identity number input should use a more explicit input mode or pattern if numeric-only is intended.
- `resources/views/pelanggan/permohonan/create.blade.php:121` - required checkboxes have no `name`, so they do not participate in backend validation and are purely client-side.
- `resources/views/pelanggan/permohonan/create.blade.php:127` - same issue for anti-gratification confirmation.

### Copy and consistency

- `resources/views/frontend/partials/headerTailwind.blade.php:17` - placeholder uses `...` instead of ellipsis `…`.
- `resources/views/pelanggan/permohonan/create.blade.php:83` - same issue.
- `resources/views/pelanggan/permohonan/create.blade.php:91` - same issue.
- `resources/views/dashboard/layanan/show.blade.php:188` - same issue.
- `resources/views/dashboard/layanan/show.blade.php:229` - same issue.
- `resources/views/dashboard/layanan/show.blade.php:248` - same issue.
- `resources/views/dashboard/posts/index.blade.php:18` - same issue.

### Motion and performance hygiene

- `resources/views/login/index.blade.php:176` - uses `transition-all`; should limit to explicit properties.
- `resources/views/register/index.blade.php:250` - uses `transition-all`.
- `resources/views/register/index.blade.php:317` - uses `transition-all`.
- `resources/views/frontend/home.blade.php:153` - uses `transition-all`.
- `resources/views/frontend/home.blade.php:169` - uses `transition-all`.
- `resources/views/frontend/home.blade.php:184` - uses `transition-all`.
- `resources/views/frontend/home.blade.php:446` - uses `transition-all`.

### Images and layout stability

- `resources/views/login/index.blade.php:23` - logo image has classes for size but no explicit `width` and `height` attributes.
- `resources/views/login/index.blade.php:62` - same issue on mobile logo.
- `resources/views/register/index.blade.php:12` - header logo lacks explicit dimensions.
- `resources/views/frontend/partials/headerTailwind.blade.php:103` - main site logo lacks explicit width/height attrs.

## Structural UX Findings

- `resources/views/frontend/partials/headerTailwind.blade.php:119` through `resources/views/frontend/partials/headerTailwind.blade.php:171` - desktop nav dropdowns are hover-driven and not clearly keyboard navigable.
- `resources/views/pelanggan/permohonan/create.blade.php:143` through `resources/views/pelanggan/permohonan/create.blade.php:176` - wizard progression is pure front-end DOM toggling, not URL-backed; step state is not deep-linkable and can be lost on validation rerender.
- `resources/views/pelanggan/tracking/index.blade.php:14` through `resources/views/pelanggan/tracking/index.blade.php:21` - DB logic in Blade complicates future UX improvements like empty/loading/error states.
- `resources/views/dashboard/layouts/sidebar.blade.php:27` and `resources/views/dashboard/layouts/sidebar.blade.php:49` - collapsible groups are buttons, but state visibility appears CSS-driven; no visible `aria-expanded` pattern found.

## Positive Notes

- Login and register forms generally use real `<label>` elements.
- Major action buttons are mostly real `<button>` elements, not clickable `div`s.
- Mobile menu toggle in `resources/views/frontend/partials/headerTailwind.blade.php:175` already has `aria-label="Menu"`.
- Most inline validation messages are rendered near their fields.

## Priority UI/UX Fix Order

1. Add labels or `aria-label`s to all search fields and icon-only buttons.
2. Replace hover-only desktop dropdown behavior with keyboard-accessible expanded menus.
3. Replace `focus:outline-none` in header search inputs with visible focus styles.
4. Remove `transition-all` and define explicit properties.
5. Add explicit image dimensions on repeated logos and content images.
6. Make pelanggan wizard state resilient across validation errors and refreshes.
