# Admin Layanan - Data Report

Date:
- 2026-04-23

Spec source:
- `docs/architecture/ROLE_ACCESS.md`

Expected by spec:
- Access to data dan informasi area.
- No access to Advis Teknik, Laboratorium, or Layanan Lainnya.

Current implementation status:
- No seeded role named `admin-layanan-data`.
- No user mapped to a data-only menu role.
- Current layanan sidebar is static and not role-filtered.

Browser audit status:
- Not runnable as a dedicated role because no matching seeded user exists.

Mismatch status:
- Spec-to-code role mapping: `missing`

Findings:
- The spec requires this role.
- Current RBAC seed/code does not expose it as a dedicated role.
