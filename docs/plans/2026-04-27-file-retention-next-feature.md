# File Retention Next Feature

Date: 2026-04-27

## Scope

Future feature for document/file retention, especially `pdf`, `doc`, `docx`, and similar downloadable files.

## Agreed Direction

- Do not delete DB rows by default.
- Keep metadata/history rows for admin traceability and yearly reporting.
- Public access should expire after the retention window.
- Physical files may be deleted after expiry to reclaim storage.

## Recommended Model

- Add `expires_at` to file-owning records.
- Add `file_deleted_at` or similar metadata flag.
- Public queries exclude expired files.
- Admin pages may still show archived rows with a clear `expired` or `file removed` status.

## Retention Rule

- Default rule: file visible for `1 year from upload date`.
- Example: uploaded on `2026-07-01`, hidden after `2027-07-01`.

## Cleanup Strategy

- Scheduled command checks expired records.
- If expired and physical file still exists:
  - delete the physical file
  - keep the DB row
  - mark file as removed/expired
- Do not leave orphaned file paths without status.

## UX Notes

- Public users should never see expired files.
- Admin should see clear status such as:
  - `Expired`
  - `File removed from storage`

## Open Decision

- Apply this only to downloadable files first.
- Do not automatically apply 1-year expiry to normal public content images unless business rules explicitly require it.
