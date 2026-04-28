# Admin Layanan - Advis Report

Date:
- 2026-04-23

Spec source:
- `docs/architecture/ROLE_ACCESS.md`

Expected by spec:
- Access to layanan advis area.
- No access to Lab, Data dan Informasi, or Layanan Lainnya.

Current implementation status:
- No seeded role named `admin-layanan-advis`.
- No user mapped to an advis-only menu role.
- No role-specific menu gating found for the layanan sidebar.

Browser audit status:
- Not runnable as a dedicated role because no matching seeded user exists.

Mismatch status:
- Spec-to-code role mapping: `missing`

Findings:
- The spec requires this role.
- Current RBAC seed/code does not implement it as a dedicated role.
- Current layanan sidebar is static, so even if a user were mapped into layanan pages, the menu would still overexpose all layanan items unless the sidebar is refactored.

Recommended next step:
1. Introduce a dedicated role and test user.
2. Apply role middleware and sidebar filtering for advis-only access.
3. Re-run browser audit after role exists.
