### **Mapping Fitur dengan Desain**

Berikut adalah daftar referensi desain berdasarkan nomor halaman yang dipetakan langsung ke dalam struktur direktori sistem:

**1. Modul: Portal Publik (Direktori: `Publik`)**
* **Beranda Utama, Navigasi, & Banner**: Halaman 1.
* **Widget Statistik Real-time (Antri, Proses, Selesai)**: Halaman 1.
* **Berita Terkini & Publikasi**: Halaman 1.
* **Footer (Kontak, Lokasi, & Link Terkait)**: Halaman 1.

**2. Modul: Admin Layanan (Direktori: `Admin Layanan`)**
* **Dashboard Operasional (Summary & Grafik SKM)**: Halaman 1.
* **Rekap Layanan per Bidang**:
    * Advis Teknik: Halaman 2.
    * Laboratorium: Halaman 10.
    * Data dan Informasi: Halaman 22.
    * Layanan Lainnya: Halaman 28.
* **Alur Progres Detail (Formulir Verifikasi, Penugasan, dsb)**:
    * Advis Teknik: Halaman 3 s/d 9.
    * Laboratorium (termasuk Kaji Ulang & Analisis): Halaman 11 s/d 21.
    * Data dan Informasi: Halaman 23 s/d 27.
    * Layanan Lainnya (termasuk Pengembalian): Halaman 29 s/d 34.
* **Survei Kepuasan Masyarakat (SKM)**: Halaman 35 s/d 36.
* **Manajemen Data Pelanggan**: Halaman 37 s/d 38.
* **Manajemen Dokumen Final**: Halaman 39.
* **Pusat Notifikasi (Persetujuan Pelanggan)**: Halaman 40 s/d 41.

**3. Modul: Admin Web / CMS (Direktori: `Admin Web`)**
* **Dashboard Admin Master**: Halaman 1.
* **Profil Balai (Identitas, Sejarah, Visi Misi)**: Halaman 2 s/d 6.
* **Manajemen SDM & Fasilitas**: Halaman 7 s/d 9.
* **Manajemen Informasi Layanan (Tarif/Standar)**: Halaman 10 s/d 14.
* **Publikasi (Banner, Berita, Galeri, Pengumuman, PPID)**: Halaman 15 s/d 26.
* **Halaman Master - Hak Akses (RBAC)**: Halaman 27.
* **Halaman Master - Sistem (Kop & Identitas Web)**: Halaman 28.

**4. Modul: Akun Pelanggan (Direktori: `Akun Pelanggan`)**
* **Dashboard Pelanggan (Summary Status)**: Halaman 1.
* **Wizard Ajukan Permohonan (Langkah 1 s/d 4)**: Halaman 2 s/d 11.
* **Tracking Layanan (Timeline Progres)**: Halaman 12.
* **Halaman Pembayaran (Nomor Billing & Bukti Bayar)**: Halaman 13.
* **Halaman Dokumen Hasil & Survei SKM**: Halaman 14 s/d 15.
* **Notifikasi & Konfirmasi Persetujuan**: Halaman 16 s/d 17.
* **Profil Pelanggan & Kategori Instansi**: Halaman 18 s/d 19.

> **Catatan untuk Halaman Master Baru (Tim & Format Nomor):**
> Desain untuk **Master Tim** dan **Master Format Nomor Permohonan** secara visual mengikuti pola desain pada direktori `Admin Web/Pengaturan/Hak Akses` (Halaman 27), menggunakan struktur tabel dinamis dengan tombol aksi untuk manajemen data.

---

### **Directory Tree Design**

Struktur direktori di bawah ini mencerminkan organisasi file dan halaman sesuai dengan modul yang didefinisikan dalam PRD:

```text
├───Admin Layanan
│   ├───Advis Teknis
│   ├───All Pages
│   ├───Bantuan
│   ├───Dashboard
│   ├───Data dan Informasi
│   ├───Data Pelanggan
│   ├───Dokumen Final
│   ├───Laboratorium
│   ├───Layanan Lainnya
│   ├───Notifikasi
│   └───Survei Kepuasan
├───Admin Web
│   ├───All pages
│   ├───Dashboard
│   ├───Layanan
│   ├───Pengaturan
│   │   ├───Hak Akses (Master Akun)
│   │   ├───Master Tim
│   │   ├───Master Format
│   │   ├───Master Survei
│   │   └───Sistem
│   ├───Profil
│   │   ├───Fasilitas
│   │   ├───Identitas
│   │   └───SDM
│   ├───Publikasi
│   │   ├───Banner
│   │   ├───Berita
│   │   ├───Galeri
│   │   ├───Pengumuman
│   │   ├───PPID
│   │   └───Renstra
│   └───Tautan
├───Akun Pelanggan
│   ├───Ajukan Permohonan
│   │   ├───Advis Teknis
│   │   ├───Laboratorium
│   │   └───Permohonan Data
│   ├───All Pages
│   ├───Bantuan
│   ├───Dashboard
│   ├───Dokumen
│   ├───Notifikasi
│   ├───Pembayaran
│   ├───Profil Pelanggan
│   └───Tracking Layanan
└───Publik
```