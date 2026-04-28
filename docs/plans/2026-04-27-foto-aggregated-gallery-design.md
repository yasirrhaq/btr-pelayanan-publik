# Foto Aggregated Gallery Design

Approved direction:
- build `/foto` as one aggregated gallery
- combine admin-uploaded gallery photos with images from berita and pengumuman
- support extracted embedded rich images from `berita.body` and `pengumuman.isi`
- add category dropdown, keyword search, and compact pagination
- keep same-page lightbox and add a simple `Buka Sumber` link with a link icon
- seed more than 8 admin photos so pagination is easy to inspect

Implementation notes:
- gallery categories are source-based: `Galeri`, `Berita`, `Pengumuman`
- pagination happens after aggregation and filtering
- embedded image extraction reads `<img src=\"...\">` from stored HTML
- demo seeder also appends sample embedded images to seeded berita and pengumuman records
