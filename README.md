# Website SMK Infokom Kota Bogor

Website sekolah lengkap dengan **Front-End (publik)** dan **Back-End (Admin Dashboard)**,
dibangun menggunakan **PHP Native** dan **MySQL**, sesuai referensi desain yang diberikan.

## 🗂 Struktur Folder

```
smk-infokom/
├── admin/                  # Panel admin (back-end)
│   ├── includes/           # Sidebar & topbar admin
│   ├── ijk-login.php
│   ├── ijk-dashboard.php
│   ├── ijk-data-siswa.php
│   ├── ijk-data-guru.php
│   ├── ijk-program-keahlian.php
│   ├── ijk-prestasi.php
│   ├── ijk-ekstrakurikuler.php
│   ├── ijk-berita.php
│   ├── ijk-galeri.php
│   ├── ijk-ppdb.php
│   └── ijk-pengaturan.php
├── assets/
│   ├── css/ (ijk-style.css untuk publik, ijk-admin.css untuk admin)
│   └── js/
├── config/
│   └── ijk-database.php        # Konfigurasi koneksi database
├── database/
│   └── ijk-smk_infokom.sql     # File database (import ini terlebih dahulu)
├── includes/
│   ├── ijk-header.php / ijk-footer.php (front-end, footer berisi Google Maps)
│   └── ijk-functions.php       # Helper & fungsi umum
├── uploads/                 # Folder upload gambar berita & galeri
├── ijk-index.php                # Beranda
├── ijk-profil.php
├── ijk-akademik.php
├── ijk-program-keahlian.php
├── ijk-prestasi.php
├── ijk-galeri.php
├── ijk-berita.php
├── ijk-kontak.php
└── ijk-ppdb.php
```

## ⚙️ Cara Instalasi (Local - XAMPP/Laragon)

1. **Salin folder** `smk-infokom` ke folder web server Anda:
   - XAMPP: `C:/xampp/htdocs/smk-infokom-ijk`
   - Laragon: `C:/laragon/www/smk-infokom-ijk`

2. **Buat database**:
   - Buka phpMyAdmin (`http://localhost/phpmyadmin`)
   - Buat database baru bernama `smk_infokom` (atau import langsung, database akan otomatis dibuat oleh file SQL)
   - Import file `database/ijk-smk_infokom.sql`

3. **Atur koneksi database** di `config/ijk-database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'smk_infokom');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
   Sesuaikan `DB_USER` dan `DB_PASS` dengan konfigurasi MySQL Anda.

4. **Buka website**:
   - Front-end: `http://localhost/smk-infokom-ijk/ijk-index.php`
   - Admin: `http://localhost/smk-infokom-ijk/admin/ijk-login.php`

5. **Login Admin default**:
   - Username: `admin`
   - Password: `admin123`

## 🗺️ Mengatur Google Maps di Footer

1. Buka [Google Maps](https://maps.google.com), cari lokasi sekolah Anda.
2. Klik tombol **Bagikan** → **Sematkan peta** → salin kode `<iframe>...</iframe>`.
3. Login ke admin → menu **Pengaturan** → tempel kode iframe tersebut ke kolom
   "Kode Embed Google Maps" → simpan.
4. Peta akan otomatis tampil di **footer** seluruh halaman front-end dan halaman Kontak.

## 🔑 Fitur Utama

**Front-End (Publik):**
- Beranda dengan hero section, statistik, tentang sekolah, program keahlian, fasilitas, berita, galeri
- Halaman Profil, Akademik, Program Keahlian, Prestasi, Galeri, Berita (dengan detail), Kontak (+ Maps), PPDB (form pendaftaran)

**Back-End (Admin Dashboard):**
- Login admin dengan password ter-enkripsi (bcrypt)
- Dashboard dengan kartu statistik, grafik jumlah siswa (Chart.js), data terbaru, berita terbaru, log aktivitas
- CRUD Data Siswa
- CRUD Data Guru & Staff
- CRUD Program Keahlian
- CRUD Prestasi
- CRUD Ekstrakurikuler
- CRUD Berita & Informasi (dengan upload gambar)
- CRUD Galeri (dengan upload gambar)
- Kelola Pendaftar PPDB (terima/tolak)
- Pengaturan umum sekolah (kontak, sosial media, Google Maps)
- Log aktivitas admin otomatis tercatat di setiap aksi

## 🔒 Keamanan yang Diterapkan
- Password di-hash menggunakan `password_hash()` (bcrypt)
- Semua query database menggunakan **Prepared Statement (PDO)** untuk mencegah SQL Injection
- Output di-escape menggunakan `htmlspecialchars()` untuk mencegah XSS
- Halaman admin dilindungi session (`requireLogin()`)

## 📌 Catatan
- Ganti password admin default setelah instalasi pertama kali (tambahkan menu ubah password jika diperlukan).
- Untuk hosting online, sesuaikan `BASE_URL` di `config/ijk-database.php` jika website ditempatkan di sub-folder.
- Gambar hero/galeri default menggunakan gambar contoh dari Unsplash — ganti dengan foto asli sekolah Anda melalui menu admin.

## 🆕 Update: Mitra Kerja Sama, BKK, dan Animasi Sentuhan

### Fitur baru
- **Mitra Kerja Sama**: kelola logo & data perusahaan mitra lewat menu admin **Mitra Kerja Sama**. Logo tampil bergerak otomatis (marquee) di beranda dan halaman BKK, berhenti sejenak saat disentuh/di-hover.
- **BKK (Bursa Kerja Khusus)**: kelola lowongan kerja lewat menu admin **BKK / Lowongan**, tampil di halaman publik `ijk-bkk.php` (link "BKK" di navbar). Lowongan otomatis tersembunyi dari daftar publik kalau statusnya "Tutup" atau sudah lewat batas akhir.
- **Animasi**: kartu-kartu muncul dengan efek geser+fade saat di-scroll, angka statistik di beranda menghitung naik, tombol punya efek riak (ripple) saat disentuh/diklik, dan kartu punya efek cahaya lembut mengikuti posisi jari/kursor.

### Jika meng-import database versi lama (sebelum fitur ini ada)
Jalankan `database/ijk-update_mitra_bkk.sql` di phpMyAdmin (tab SQL, pilih database yang dipakai project — cek namanya di `config/ijk-database.php` baris `DB_NAME`). Untuk instalasi baru, cukup import `database/ijk-smk_infokom.sql` seperti biasa.

### Cara pakai
1. Login admin → menu **Mitra Kerja Sama** → tambahkan beberapa perusahaan/instansi mitra beserta logonya.
2. Menu **BKK / Lowongan** → tambahkan lowongan, pilih mitra terkait (opsional), isi batas akhir pendaftaran.
3. Buka halaman beranda — logo mitra otomatis tampil bergerak di atas pita kuning "Bergabunglah Bersama Kami".
4. Klik menu **BKK** di navbar untuk melihat daftar lowongan publik.

### Catatan teknis
- Folder upload logo mitra: `uploads/mitra/` (dibuat otomatis kalau belum ada saat upload pertama).
- CSS/JS beranda punya cache-busting otomatis (`?v=<?= filemtime(...) ?>`) — jadi setelah edit `ijk-style.css` atau `ijk-main.js`, browser tidak perlu lagi hard refresh (`Ctrl+Shift+R`) untuk lihat perubahan.
- Animasi menghormati pengaturan "Reduce Motion" di perangkat pengguna (otomatis nonaktif kalau pengguna mematikan animasi di sistem operasinya).

## 🆕 Update: Semua Nama File Diberi Prefix `ijk-`

Supaya tidak bentrok saat file dari project ini tercampur dengan project PHP lain yang
kebetulan punya nama file umum yang sama (`index.php`, `login.php`, `dashboard.php`,
`functions.php`, `style.css`, dan sebagainya), seluruh file kode (PHP, CSS, JS, SQL)
di project ini sudah diberi awalan `ijk-`. Folder (`admin/`, `includes/`, `assets/`,
`config/`, `database/`, `uploads/`) tetap memakai nama aslinya.

**Satu pengecualian**: `index.php` di folder utama sengaja TIDAK diberi prefix dan
dibiarkan sebagai file kecil yang hanya mengalihkan (redirect) ke `ijk-index.php`.
Ini supaya membuka alamat folder tanpa nama file
(misal `http://localhost/smk-infokom-ijk/`) tetap otomatis menampilkan beranda,
karena web server secara default mencari file bernama persis `index.php`.
Kalau file `index.php` ini nanti tertimpa oleh project lain, halaman lain di
project ini (yang diakses lewat nama filenya langsung, seperti `ijk-profil.php`)
tetap aman dan tidak terpengaruh.

## 🆕 Update: Dropdown Akademik & Informasi

- Sub-menu **Akademik** sekarang memakai halaman terpisah: Kalender Akademik, Jadwal Pelajaran, Kurikulum, E-Learning, dan Ekstrakurikuler.
- Menu **BKK** di navbar utama dihapus dan dipindahkan ke dropdown **Informasi** bersama Berita & Informasi.
- Halaman `ijk-akademik.php` sekarang menjadi halaman indeks yang mengarahkan ke masing-masing sub-halaman akademik.
