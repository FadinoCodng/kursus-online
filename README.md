# EduTech - Platform Kursus Online Sederhana

Proyek ini dibangun untuk memenuhi **Soal Technical Test Magang: Pembuatan Website Kelas Online Sederhana** menggunakan **Laravel 13** dan **PHP 8.3/8.5** dengan arsitektur modern, rapi, dan mudah di-maintain.

---

## 📌 Informasi Teknis Singkat

- **Framework**: Laravel 13 (`v13.40.0`)
- **Bahasa Pemrograman**: PHP 8.3 / PHP 8.5
- **Database**: SQLite (Default bawaan & siap pakai tanpa konfigurasi tambahan) / MySQL (Laragon ready)
- **Dependency Manager**: Composer 2
- **Frontend / Styling**: Bootstrap 5.3 + Bootstrap Icons (Mobile Responsive & Clean UI)
- **Admin Dashboard Layout**: Modern Tabler / AdminLTE inspired layout

---

## 🚀 Fitur Unggulan & Pemenuhan Soal

### 1. Fitur Wajib
- [x] **Landing Page Pengunjung**:
  - Hero section menarik dengan statistik lembaga.
  - Katalog daftar kelas dengan pencarian judul/instruktur dan filter per kategori.
  - Halaman detail kelas lengkap (fasilitas, deskripsi, info instruktur, dan kelas terkait).
  - Formulir pendaftaran kelas (Nama, Email, No Telepon/WhatsApp, Catatan).
  - Informasi kontak lembaga dan footer responsif (HP & Laptop).
- [x] **Autentikasi Admin**:
  - Login dan Logout aman menggunakan session Laravel.
  - Proteksi rute admin (`auth` middleware).
- [x] **Dashboard Admin**:
  - Ringkasan statistik: Total Kelas (Published & Draft), Total Pendaftar (Diterima, Pending, Ditolak), dan Kategori.
  - Tabel khusus **5 Pendaftar Terbaru** dengan aksi cepat terima/tolak.
- [x] **Kelola Kelas (CRUD)**:
  - Judul, deskripsi, kategori, instruktur, harga (atau gratis), upload thumbnail ke Storage Laravel.
  - Status kelas menggunakan **PHP 8.1+ Backed Enum** (`App\Enums\CourseStatus`: `draft`, `published`).
  - Hanya kelas berstatus `published` yang tampil di Landing Page publik.
- [x] **Kelola Kategori (CRUD)**:
  - Relasi `hasMany` (1 kategori memiliki banyak kelas).
  - Filter interaktif di Landing Page.
- [x] **Kelola Pendaftar**:
  - Filter pendaftar berdasarkan kelas dan status pendaftaran.
  - Ubah status pendaftar: `pending`, `diterima`, `ditolak` menggunakan **PHP Enum** (`App\Enums\RegistrationStatus`).
  - **Validasi Anti-Duplikat**: Satu email tidak dapat mendaftar dua kali di kelas yang sama (tervalidasi di Form Request & Unique Database Constraint).
- [x] **Pencarian & Pagination**:
  - Berlaku pada daftar kelas di Landing Page dan Dashboard Admin.
- [x] **Ketentuan Teknis**:
  - Menggunakan `php artisan migrate --seed` untuk generate schema & akun admin siap pakai.
  - Relasi Eloquent lengkap (`belongsTo`, `hasMany`, `scopePublished`).
  - Form Request Validation dengan custom error message berbahasa Indonesia.
  - Blade Layout yang reusable (`layouts/app.blade.php` & `layouts/admin.blade.php`).

### 2. Fitur Bonus (Nilai Tambah)
- [x] **Ekspor Data Pendaftar ke CSV / Excel**: Tombol ekspor tersedia di menu pendaftar dengan filter yang aktif dan encoding UTF-8 BOM agar rapi di Microsoft Excel.
- [x] **Halaman Blog / Artikel Sederhana**: Pengunjung dapat membaca tips teknologi, dan Admin dapat membuat/mengubah artikel melalui CRUD admin.
- [x] **Automated Test**: Pengujian otomatis menggunakan Feature Test PHPUnit / Pest (`tests/Feature/CourseRegistrationTest.php`) dengan 7 test suite yang semuanya berstatus **PASSING (100%)**.

---

## 🔑 Akun Default Admin

Setelah menjalankan migration & seeder, gunakan kredensial berikut untuk login ke Dashboard Admin:

- **URL Login**: `http://127.0.0.1:8000/login`
- **Email**: `admin@kursusonline.com`
- **Password**: `password123`

---

## 🛠️ Langkah Instalasi & Menjalankan Aplikasi

Pastikan PHP (minimal versi 8.3) dan Composer sudah terpasang di komputer Anda.

### 1. Masuk ke Direktori Project
```bash
cd E:\FadinoLengkap\kursus-online
```

### 2. Install Dependensi (Jika belum)
```bash
composer install
```

### 3. Konfigurasi Environment & Key
File `.env` sudah otomatis dibuat. Generate application key jika diperlukan:
```bash
php artisan key:generate
```

### 4. Jalankan Migrasi & Seeder Database
```bash
php artisan migrate --seed
```
*Perintah ini akan membuat seluruh tabel, mengisi kategori teknologi, kelas dummy, data pendaftar awal, artikel blog, serta akun admin.*

### 5. Buat Symlink Storage (Untuk Gambar Kelas)
```bash
php artisan storage:link
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Buka browser dan akses:
- **Landing Page**: `http://127.0.0.1:8000`
- **Dashboard Admin**: `http://127.0.0.1:8000/login`

---

## 🧪 Menjalankan Automated Test

Aplikasi telah dilengkapi pengujian otomatis untuk alur kritis:
- Uji filter landing page (hanya tampilkan kelas published)
- Uji registrasi kelas online
- Uji pencegahan email ganda pada kelas yang sama
- Uji proteksi dashboard bagi tamu non-admin
- Uji perubahan status pendaftar oleh admin

Jalankan pengujian dengan perintah:
```bash
php artisan test
```

---

## 🎨 Kredit Template & Framework

- **CSS Framework**: [Bootstrap 5.3](https://getbootstrap.com/)
- **Icons**: [Bootstrap Icons v1.11](https://icons.getbootstrap.com/)
- **Typography**: [Google Fonts - Plus Jakarta Sans](https://fonts.google.com/specimen/Plus+Jakarta+Sans)
- **Gambar Dummy**: [Unsplash](https://unsplash.com/) (Free License)
