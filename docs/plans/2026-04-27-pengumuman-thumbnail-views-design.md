# Pengumuman Thumbnail And Views Design

Approved direction:
- add `thumbnail_path` and `views` to `pengumuman`
- keep `lampiran_path` only for attachments
- show `3` items per page on public `pengumuman`
- increment `views` on detail open
- add a dedicated demo seeder with `12` rows so pagination is visible immediately

Implementation notes:
- public cards use a separate thumbnail image with fallback
- admin create/edit gets a separate thumbnail upload field
- the eye icon shows persisted `views` count instead of status text
- demo seeder uses local repo assets and sample attachment data only
