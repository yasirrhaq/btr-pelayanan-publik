Product Requirements Document (PRD): Sistem Informasi Balai Teknik Rawa (BTR)
1. Pendahuluan
Dokumen ini merinci persyaratan teknis dan fungsional untuk pengembangan Website Balai Teknik Rawa yang mencakup portal publik, sistem manajemen operasional layanan (Admin Layanan), manajemen konten (Admin Web), dan portal mandiri bagi pelanggan.

2. Struktur Pengguna & Hak Akses
Sistem menggunakan Role-Based Access Control (RBAC) dengan pembagian sebagai berikut:

Pengunjung Umum: Akses tanpa login ke halaman profil dan informasi publik.

Admin Master: Akses penuh ke seluruh fitur pengaturan sistem dan konten web.

Admin Web - Editor: Terbatas pada manajemen publikasi dan berita.

Admin Layanan (Master/Bidang): Mengelola alur kerja layanan teknis sesuai bidangnya (Advis, Lab, Data, atau Lainnya).

Staf Teknis (Analis/Penyelia/Teknisi): Hak akses khusus pada tahapan pelaksanaan teknis di modul Laboratorium.

Pelanggan: Mengelola profil pribadi, mengajukan layanan, dan mengunduh hasil secara mandiri.

3. Modul 1: Halaman Publik (Frontend)
Tujuan: Wajah digital instansi untuk memberikan informasi layanan dan transparansi data kepada masyarakat.

Fitur Utama:
Dashboard Statistik Real-time: Menampilkan widget jumlah antrean, proses, dan penyelesaian layanan secara transparan.

Profil Instansi: Informasi detail mengenai Visi & Misi, Sejarah, Struktur Organisasi, dan Fasilitas Balai.

Portal Berita & Publikasi: Menampilkan berita terkini, pengumuman, galeri foto/video, serta dokumen rencana strategis (Renstra).

Layanan Informasi PPID: Penyediaan informasi berkala, serta merta, dan setiap saat sesuai standar UU Keterbukaan Informasi Publik.

Interaksi Pengguna: Fitur pencarian global, akses bantuan "Tanya Kaura", dan tautan media sosial.

4. Modul 2: Halaman Admin Layanan (Manajemen Operasional)
Tujuan: Mengelola siklus hidup permohonan layanan secara internal dari verifikasi hingga penyerahan.

Fitur Utama:
Dashboard Analitik: Grafik pemantauan volume layanan dan skor Survei Kepuasan Masyarakat (SKM).

Manajemen Workflow Layanan:

Layanan Advis Teknik: Alur verifikasi Katim, penugasan pelaksana, dan finalisasi laporan.

Layanan Laboratorium: Alur kaji ulang permintaan, manajemen billing pembayaran, pelaksanaan pengujian, analisis analis, hingga evaluasi penyelia.

Layanan Data & Informasi: Alur penyiapan dan verifikasi format data.

Layanan Lainnya: Alur peminjaman fasilitas hingga tahap pengembalian.

Sistem Billing & PNBP: Integrasi input kode billing dan verifikasi bukti pembayaran pelanggan.

Pusat Notifikasi: Mengelola konfirmasi persetujuan dari pelanggan terkait biaya dan estimasi waktu.

5. Modul 3: Halaman Admin Web (Content Management System)
Tujuan: Mengelola seluruh aset digital dan konfigurasi teknis situs web.

Fitur Utama:
Manajemen Konten (CMS): Editor teks dan media untuk profil instansi, banner slider, berita, dan pengumuman.

Manajemen SDM & Fasilitas: Pengelolaan basis data pegawai dan katalog fasilitas yang tersedia di Balai.

Manajemen Dokumen Layanan: Pengelolaan file PDF untuk standar pelayanan dan maklumat pelayanan.

Pengaturan Sistem: Konfigurasi identitas web (Kop surat, Footer, Media Sosial) dan manajemen akun pengguna sistem (Admin).

6. Modul 4: Portal Akun Pelanggan (Self-Service)
Tujuan: Memudahkan pelanggan dalam mengajukan permohonan dan memantau progres secara mandiri.

Fitur Utama:
Dashboard Pelanggan: Ringkasan status permohonan aktif (Contoh: Menunggu Pembayaran, Tahap Pelaksanaan).

E-Service (Pengajuan Mandiri): Formulir pengajuan layanan 4 langkah (Pilih Layanan, Konfirmasi Data, Detail Teknis, dan Finalisasi).

Tracking System: Visualisasi timeline progres layanan dalam bentuk persentase dan riwayat aktivitas.

Manajemen Pembayaran: Akses kode billing dan portal unggah bukti pembayaran.

Unduh Hasil Mandiri: Fitur unduh Laporan Hasil Pengujian (LHP) atau dokumen final lainnya yang hanya terbuka setelah pelanggan mengisi survei kepuasan.

7. Persyaratan Non-Fungsional
Keamanan: Data pelanggan harus terlindungi dan dokumen hasil hanya bisa diakses oleh pemilik akun yang sah.

Responsivitas: Website harus dapat diakses dengan baik melalui perangkat desktop maupun mobile, utamakan mobile first approach.

Integritas Data: Sistem harus memastikan bahwa setiap tahapan layanan (workflow) dilakukan secara berurutan sesuai otorisasi.

Berikut adalah versi bersih **Integrated Product Requirements Document (PRD)** untuk Sistem Informasi Terpadu Balai Teknik Rawa (BTR). Dokumen ini telah disusun secara komprehensif tanpa kode sitasi sehingga siap untuk langsung disalin (copy-paste) ke dalam dokumentasi proyek Anda.

---

# Detailed PRD: Sistem Informasi Terpadu Balai Teknik Rawa (BTR)

## 1. Pendahuluan
Dokumen ini merinci persyaratan fungsional dan teknis untuk pengembangan ekosistem digital Balai Teknik Rawa (BTR). Sistem ini bertujuan untuk mengotomatisasi layanan teknis (E-Service), meningkatkan transparansi proses kepada pelanggan, serta memudahkan manajemen konten publik dan data internal secara terpusat.

## 2. Struktur Pengguna & Hak Akses (RBAC)
Sistem menerapkan pengaturan hak akses berbasis peran (Role-Based Access Control) yang ketat untuk menjaga integritas alur kerja:

| Kelompok | Peran (Role) | Tanggung Jawab Utama |
| :--- | :--- | :--- |
| **Admin Web** | **Admin Web - Master** | Akses penuh manajemen user via Halaman Master, konfigurasi sistem, dan identitas balai. |
| | **Admin Web - Editor** | Manajemen konten publikasi: berita, banner slider, dan galeri. |
| **Admin Layanan** | **Admin Layanan - Master** | Monitoring seluruh rekapitulasi layanan, kontrol data master layanan, dan akses dokumen final. |
| | **Katim (Ketua Tim)** | Verifikasi teknis permohonan, penugasan Tim Kerja, dan validasi laporan akhir. |
| | **Admin Bidang** | Administrasi: verifikasi billing PNBP, input nominal biaya manual, notifikasi, dan penyerahan. |
| | **Analis/Penyelia/Teknisi** | Teknis (khusus Lab): pengisian lembar kerja sesuai penugasan tim dan evaluasi hasil draft. |
| **Eksternal** | **Akun Pelanggan** | Pengajuan layanan mandiri, pembayaran, tracking progres, dan unduh dokumen hasil. |

## 3. Arsitektur Data & Entitas Utama
Basis data dikelola secara relasional dengan entitas utama sebagai berikut:
* **Entitas Profil**: Data akun pelanggan (Nama, Instansi, Kategori Instansi, KTP, Kontak) dan User Admin.
* **Entitas Permohonan**: Data layanan (Nomor PL, Jenis Layanan, Perihal, Progres, Deadline).
* **Entitas Tim**: Pemetaan hirarki: Layanan -> Nama Tim -> Anggota (Katim, Penyelia, Analis, Teknisi).
* **Entitas Format Nomor**: Template penomoran otomatis per jenis layanan.
* **Entitas Workflow Logs**: Log riwayat status permohonan dengan timestamp dan identitas aktor.
* **Entitas Dokumen**: Penyimpanan file Surat Pengantar, KTP, dan Laporan Hasil (LHP/Advis).
* **Entitas Keuangan**: Data transaksi PNBP (Nomor Billing, Nominal Biaya, Bukti Bayar, Status Verifikasi).
* **Entitas Survei (SKM)**: Data kuesioner berdasarkan 9 unsur pelayanan.

## 4. Logika Bisnis & Aturan Sistem (Business Rules)

### 4.1 Mekanisme "Gatekeeper" Unduhan
* **Aturan**: Pelanggan dilarang mengunduh dokumen hasil sebelum mengisi survei kepuasan.
* **Logika**: Tombol unduh hanya akan aktif (enabled) setelah pelanggan menyelesaikan pengisian formulir SKM.

### 4.2 Alur Berurutan (Sequence Control)
* **Verifikasi**: Tahap penugasan tidak dapat dibuka sebelum Katim menyetujui hasil verifikasi permohonan.
* **Pembayaran**: Untuk layanan berbayar, proses teknis (pelaksanaan) hanya dimulai setelah status pembayaran divalidasi oleh Admin Bidang sebagai "Sudah Dibayar".

### 4.3 Notifikasi Multichannel (Portal & WhatsApp Business)
* **Sinkronisasi**: Setiap pengiriman notifikasi memicu dua aksi: update list notifikasi di portal pelanggan dan pengiriman pesan otomatis via WhatsApp Business API ke nomor pelanggan.
* **Header Notifikasi**: Notifikasi muncul pada ikon lonceng di area profil (kanan atas) dalam bentuk dropdown yang menampilkan 5 update status terbaru.

### 4.4 Perhitungan SLA Dinamis
* **Otomatisasi**: Sistem menghitung hari kerja secara otomatis berdasarkan tanggal mulai dan selesai.
* **Kalender Indonesia**: Perhitungan wajib memotong hari Sabtu, Minggu, Libur Nasional, dan Cuti Bersama sesuai kalender resmi Indonesia.

### 4.5 Penomoran Otomatis (Master Format)
* **Aturan**: Nomor permohonan diterbitkan otomatis sesuai format di Halaman Master per layanan.
* **Format**: Pola default adalah `ID_LAYANAN/KODE/BTR.KODE/TAHUN`. Tahun diambil otomatis dari tahun berjalan (current year).

## 5. Rincian Modul Sistem

### 5.1 Portal Publik (Frontend)
* **Dashboard Transparansi**: Widget statistik antrean (Antri, Proses, Selesai) secara real-time.
* **CMS Publikasi**: Manajemen Profil, SDM, Berita, Pengumuman, dan Layanan Informasi PPID.

### 5.2 Admin Layanan (Backend Workflow)
* **Modul Layanan**: Pengelolaan teknis per bidang (Lab, Advis, Data, Lainnya) dari tahap permohonan hingga laporan akhir.
* **Manajemen Tim**: Fitur bagi Katim untuk memilih "Tim Kerja" (pre-defined) saat tahap penugasan.

### 5.3 Modul Manajemen Data Master (Khusus Master Admin)
* **Master Akun**: Pintu tunggal pembuatan akun admin dan pengaturan Role (RBAC).
* **Master Tim**: Pengaturan hirarki operasional: **Layanan -> Nama Tim -> Anggota**.
* **Master Format Nomor**: Pengaturan template penomoran otomatis per jenis layanan.
* **Master Survei**: Pengaturan pertanyaan kuesioner 9 unsur pelayanan.

### 5.4 Portal Pelanggan (Self-Service)
* **Wizard Ajukan Permohonan (4 Langkah)**: Alur pendaftaran layanan yang terbagi menjadi langkah: Pilih Layanan -> Data Profil (Pilih Kategori Instansi) -> Detail Teknis (Upload Dokumen) -> Selesai.
* **Tracking Progres**: Visualisasi timeline dan progress bar (0-100%).

## 6. Persyaratan Non-Fungsional
* **Keamanan**: Enkripsi dokumen final dan proteksi data pribadi.
* **Integrasi API**: Koneksi stabil dengan WhatsApp Business API.
* **Responsivitas**: Antarmuka optimal untuk akses desktop dan mobile.
* **Kapasitas**: Server mendukung penyimpanan dokumen teknis hingga 2MB per file.

## 7. Detail Fungsional Halaman & Formulir

### 7.1 Admin Layanan
* **Halaman Rekap**: Tabel dinamis dengan filter bidang dan indikator progres.
* **Formulir Pembayaran**: Fitur bagi Admin Bidang untuk input biaya nominal secara manual hasil kaji ulang teknis.
* **Formulir Penugasan**: Fitur pilih Tim Kerja dari dropdown Master Tim dan pemilihan tanggal via kalender (auto-calculate SLA).

### 7.2 Admin Web (CMS)
* **Formulir SDM**: Input data pegawai, status kepegawaian, dan foto profil.
* **Formulir PPID**: Tab khusus untuk 4 kategori informasi publik.

### 7.3 Portal Pelanggan
* **Header Notifikasi**: Dropdown pada ikon lonceng profil untuk melihat update tanpa pindah halaman.
* **Survei SKM**: Rating 9 unsur pelayanan sebagai syarat membuka kunci unduhan dokumen hasil.

## 8. Security & Data Protection
* **Autentikasi**: Session management kuat dan penyimpanan API Key WhatsApp secara aman di environment variables.
* **Proteksi Data**: Enkripsi file KTP dan dokumen hasil pada server. Akses dokumen hasil menggunakan Signed URLs (tautan sementara).
* **Upload Security**: Validasi ekstensi file secara ketat dan pemindaian malware pada setiap file yang diunggah.

---