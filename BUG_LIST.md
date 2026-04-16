# Bug List

Date: 2026-04-14

## Fixed In This Pass

| Severity | Area | Route/Page | Root Cause | Status |
| --- | --- | --- | --- | --- |
| High | Frontend Public | `/berita` | Listing route still rendered legacy `berita.index` on `mainNew`, causing shell mismatch with header/footer | Fixed |
| High | Frontend Public | `/berita` | AJAX listing depended on `BASE_URL` global from old layout and broke after move to `mainTailwind` | Fixed |
| High | Frontend Public | `/berita` | AJAX POST lacked CSRF header and returned `419` | Fixed |
| Medium | Frontend Public | `/berita` | Client-side loading caused repeated `Sedang memuat berita...` flashes and unstable card rendering | Fixed via server-side rendering |
| Medium | Frontend Public | profile/service pages | Public pages used mixed layout stacks and empty image data, causing cramped inconsistent UI | Fixed |
| High | Admin Web | `/dashboard/pengumuman` | Blade used `Str::limit()` without namespace/import | Fixed |
| High | Admin Layanan | `/dashboard/layanan/permohonan` | Blade used `Str::limit()` without namespace/import | Fixed |
| Medium | Admin Layanan | `/dashboard/layanan/show` | Survey UI treated `surveiKepuasan` as a collection instead of a single relation | Fixed |
| Medium | Admin Layanan | `/dashboard/layanan/show` | Assign-tim and billing panels were shown for statuses that backend workflow rejects | Fixed |
| Medium | Admin Layanan | assign/billing/payment actions | Controller lacked guard rails for forbidden transitions | Fixed |
| Medium | Shared data model | `JenisLayanan`-backed pages | Views expected `nama` while schema stores `name` | Fixed via model accessor |
| Low | Pelanggan | `/pelanggan/profil` | View used `nama_instansi` instead of `instansi` | Fixed |
| Medium | Auth | `/login` | Verified pelanggan users were redirected to `/dashboard` instead of `/pelanggan` | Fixed |
| Medium | Auth | `/login`, `/register` | Expired or mismatched CSRF/session state showed raw `419 Page Expired` instead of recovering gracefully | Fixed |
| Medium | Admin Web | `/dashboard/master-survei` | Create/update flow did not provide required `unsur` field | Fixed |
| Medium | Numbering | pelanggan permohonan creation | `FormatNomor` seed placeholders and `NomorPermohonanService` replacement tokens were inconsistent | Fixed |
| High | Pelanggan | `/pelanggan`, `/pelanggan/permohonan`, `/pelanggan/notifikasi` | Blade used `Str::limit()` without namespace/import | Fixed |

## Still Open

| Severity | Area | Route/Page | Root Cause | Status |
| --- | --- | --- | --- | --- |
| Low | Admin Web | `/dashboard` | `/img/mascot.png` is missing and returns 404; inline fallback masks the impact | Open |
| Medium | Dev tooling | host-side `php artisan route:list` | Local host `.env` still points to Docker hostname `db`, and `LandingPageController` constructor performs DB work during route discovery | Open |
| Medium | PPID | `/dashboard/ppid` manage links | PPID cards still link with `?tipe=` while controller expects `type` | Open |

## Verification Notes

- Runtime app recovered by recreating nginx.
- Follow-up verification is performed with Playwright live browser tests.
- Final verification result: `68 passed`, `0 failed`.
- Auth token-mismatch recovery verified with Playwright on login and register.
- Related audit docs are updated after the rerun.
- Public berita page now uses server-side filtering/pagination and local fallback images.
