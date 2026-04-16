# Dokumentasi Hak Akses Pengguna (RBAC) - Website Balai Teknik Rawa

Sistem Website Balai Teknik Rawa menerapkan pengaturan hak akses berbasis peran (**Role-Based Access Control**). Akses dibagi menjadi halaman publik (tanpa login) dan halaman internal (perlu login).

---

## 1. Halaman Admin Web
Fokus pada pengelolaan konten publikasi dan informasi umum.

| No | Peran (Role) | Hak Akses |
| :-- | :--- | :--- |
| 1 | **Admin Web - Master** | Akses penuh ke seluruh menu dan fitur admin web. |
| 2 | **Admin Web - Editor** | Terbatas hanya pada menu publikasi. |

---

## 2. Halaman Admin Layanan
Fokus pada manajemen operasional layanan teknis.

### 2.1 Matriks Peran Utama
| No | Peran (Role) | Deskripsi Hak Akses |
| :-- | :--- | :--- |
| 1 | **Admin Layanan - Master** | Akses seluruh menu dan fitur layanan. |
| 2 | **Admin Layanan - Advis** | Seluruh fitur kecuali Lab, Data & Informasi, Layanan Lainnya. |
| 3 | **Admin Layanan - Lab** | Seluruh fitur kecuali Advis Teknik, Data & Informasi, Layanan Lainnya. |
| 4 | **Admin Layanan - Data** | Seluruh fitur kecuali Advis Teknik, Lab, Layanan Lainnya. |
| 5 | **Admin Layanan - Lainnya** | Seluruh fitur kecuali Advis Teknik, Lab, Data & Informasi. |

---

### 2.2 Akses Detail Tahapan Progres
Setiap layanan memiliki alur kerja dengan tanggung jawab spesifik pada tiap tahapannya.

#### A. Layanan Advis Teknik
| Role | Hak Edit (Tahapan) |
| :--- | :--- |
| **Layanan Advis - Katim** | Verifikasi, Penugasan |
| **Layanan Advis - Pelaksana** | Pelaksanaan, Laporan |
| **Layanan Advis - Admin** | Penyerahan |

#### B. Layanan Laboratorium
| Role | Hak Edit (Tahapan) |
| :--- | :--- |
| **Layanan Lab - Katim** | Kaji Ulang, Penugasan |
| **Layanan Advis - Admin** | Permohonan, Pembayaran, Penugasan, Laporan, Penyerahan |
| **Layanan Advis - Teknisi*** | Pelaksanaan |
| **Layanan Advis - Analis** | Analisis |
| **Layanan Advis - Penyelia** | Evaluasi |

> **Catatan:** Khusus Role **Layanan Lab - Teknisi**, sistem membatasi akses sehingga tidak dapat melihat atau mengelola menu **Data Pelanggan**.

#### C. Layanan Data dan Informasi
| Role | Hak Edit (Tahapan) |
| :--- | :--- |
| **Layanan Data - Katim** | Verifikasi, Penugasan |
| **Layanan Data - Pelaksana** | Penyiapan Data |
| **Layanan Data - Admin** | Penyerahan |

#### D. Layanan Lainnya
| Role | Hak Edit (Tahapan) |
| :--- | :--- |
| **Layanan Lainnya - Katim** | Verifikasi, Penugasan |
| **Layanan Lainnya - Admin** | Penyiapan Data |
| **Layanan Lainnya - Pelaksana** | Penyerahan, Pengembalian |

---

## 3. Halaman Akun Pelanggan
Halaman eksternal untuk pengguna jasa Balai Teknik Rawa.

| No | Peran (Role) | Hak Akses |
| :-- | :--- | :--- |
| 1 | **Akun Pelanggan** | Mengakses seluruh menu dan fitur pada dashboard pelanggan (pengajuan, tracking, profile). |

---