# Akun Pelanggan Report

Date:
- 2026-04-23

Spec source:
- `docs/architecture/ROLE_ACCESS.md`

Expected by spec:
- Full access to pelanggan dashboard features:
- pengajuan
- tracking
- profile
- related pelanggan menu set

Seed/code mapping:
- Role: `pelanggan`
- User used in browser audit: `id=7`, `yasir.haq98@gmail.com`

Actual rendered navbar:
- `Dashboard`
- `Ajukan Permohonan`
- `Tracking Layanan`
- `Pembayaran`
- `Dokumen`
- `Notifikasi`
- `Profil Pelanggan`
- `Bantuan`

Actual route checks:
- `/pelanggan`: `200`
- `/pelanggan/permohonan`: `200`
- `/pelanggan/dokumen`: `200`
- `/dashboard`: redirect path lands on `/` and ends in `500`

Findings:
- Pelanggan shell runtime is fixed for the main portal routes.
- Navbar now matches the expected pelanggan menu set in the live browser.
- Cross-area admin denial is still noisy: hitting `/dashboard` redirects pelanggan to `/`, but the homepage currently throws a separate `500`, so the final user-visible result is still broken.

Mismatch status:
- Intended menu structure: `match`
- Main pelanggan runtime: `match`
- Cross-area admin access handling: `partial mismatch`
