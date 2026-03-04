# Sistem Informasi Panduan Layanan UPTD PPA
**Perlindungan Perempuan & Anak — Dinas Komunikasi dan Informatika**

---

## 📋 Deskripsi Sistem

Sistem informasi berbasis web yang bersifat **informatif dan edukatif** untuk memberikan panduan layanan perlindungan perempuan dan anak. Sistem ini:

- ✅ **TIDAK** menyimpan data pribadi korban
- ✅ **TIDAK** memproses laporan resmi secara online
- ✅ **TIDAK** menggantikan aplikasi BEBUNGE
- ✅ Menyajikan panduan alur layanan (pelaporan, pendampingan psikolog, bantuan hukum)
- ✅ Menyajikan referensi dasar hukum dan FAQ
- ✅ Menyediakan panel admin untuk mengelola konten

---

## 🎨 Desain & Warna

**Palet Utama:**
- **Biru**: `#36A9F0` (button FAQ, footer, admin panel)
- **Merah**: `#E93235` (button Bantuan Darurat, urgent markers)
- **Hijau**: `#2B9348` (logo text, button "Mulai dari pelaporan")
- **Pink Disclaimer**: `#FFE4E1` (background disclaimer bar)

**Tipografi:**
- Heading: *DM Serif Display*
- Body: *Outfit*

---

## 📁 Struktur File

```
uptd_ppa/
├── index.php                  # Beranda (hero + card grid)
├── panduan.php                # Halaman panduan dinamis (slug: pelaporan|psikolog|hukum)
├── dasar-hukum.php            # Dasar hukum + tabel peraturan
├── faq.php                    # FAQ dengan accordion
├── css/
│   └── style.css              # Master stylesheet
├── includes/
│   ├── config.php             # Koneksi database
│   ├── header.php             # Navbar + mobile menu
│   └── footer.php             # Footer + modal darurat + base JS
├── admin/
│   ├── login.php              # Halaman login admin
│   ├── auth.php               # Middleware session check
│   ├── logout.php             # Logout handler
│   ├── admin_layout.php       # Shell layout admin (sidebar + topbar)
│   ├── dashboard.php          # Dashboard admin (stats + quick links)
│   ├── panduan.php            # CRUD Panduan Layanan
│   ├── dasar-hukum.php        # CRUD Dasar Hukum
│   ├── faq.php                # CRUD FAQ
│   └── kontak.php             # CRUD Kontak Darurat
├── images/                    # ⚠️ Folder ini harus Anda isi dengan icon
│   ├── logo_ppa.jpg           # Logo utama (navbar + admin)
│   ├── pict1_icon.png         # Hero image besar (shield dengan heart)
│   ├── dasar_hukum.webp       # Icon book (card pelaporan + button "Mulai dari pelaporan")
│   ├── psikologi.png          # Icon heart (card pendampingan)
│   ├── hukum_icon.webp        # Icon scales (card bantuan hukum)
│   └── sirine_icon.png        # Icon siren (button bantuan darurat + modal)
├── database.sql               # Schema + seed data
└── README.md                  # File ini
```

---

## 🖼️ Icon yang Dibutuhkan

Pastikan folder `images/` berisi file-file berikut dengan nama **PERSIS**:

| Nama File            | Fungsi                                      | Ukuran Rekomendasi |
|----------------------|---------------------------------------------|--------------------|
| `logo_ppa.jpg`       | Logo di navbar & admin panel                | 80×80px            |
| `pict1_icon.png`     | Hero image kiri (ilustrasi shield+heart)    | 280×280px          |
| `dasar_hukum.webp`   | Icon book (pelaporan + dasar hukum)         | 52×52px            |
| `psikologi.png`      | Icon heart (pendampingan psikolog)          | 52×52px            |
| `hukum_icon.webp`    | Icon scales (bantuan hukum)                 | 52×52px            |
| `sirine_icon.png`    | Icon siren (bantuan darurat)                | 20×20px (button)   |

> **Catatan:** Jika file icon tidak tersedia, sistem tetap akan berjalan — hanya gambar tidak akan muncul. Anda dapat menggunakan placeholder sementara.

---

## ⚙️ Instalasi & Deployment

### **Persyaratan Sistem**
- PHP 7.4 atau lebih tinggi
- MySQL 5.7+ atau MariaDB 10.3+
- Apache/Nginx dengan mod_rewrite
- XAMPP, Laragon, atau stack LAMP/WAMP

### **Langkah Instalasi**

#### 1. **Ekstrak File**
Ekstrak `uptd_ppa.zip` ke direktori web server:
```bash
# Untuk XAMPP
C:\xampp\htdocs\uptd_ppa\

# Untuk Laragon
C:\laragon\www\uptd_ppa\
```

#### 2. **Import Database**
- Buka phpMyAdmin: `http://localhost/phpmyadmin`
- Buat database baru: `uptd_ppa`
- Import file `database.sql` ke database tersebut
- Database akan terisi seed data siap pakai

#### 3. **Konfigurasi Koneksi Database** (Opsional)
Jika kredensial MySQL Anda berbeda, edit `includes/config.php`:
```php
$db_host = 'localhost';
$db_name = 'uptd_ppa';
$db_user = 'root';          // Ganti jika berbeda
$db_pass = '';              // Ganti jika ada password
```

#### 4. **Upload Icon**
Masukkan file icon ke folder `images/` sesuai tabel di atas.

#### 5. **Akses Sistem**
- **Website Publik**: `http://localhost/uptd_ppa/`
- **Admin Panel**: `http://localhost/uptd_ppa/admin/login.php`

---

## 🔐 Kredensial Admin Default

| Field    | Value      |
|----------|------------|
| Username | `admin`    |
| Password | `admin123` |

> **PENTING:** Segera ganti password setelah instalasi pertama dengan mengedit tabel `admin` di database. Password disimpan ter-hash dengan bcrypt.

**Cara ganti password:**
```php
// Generate hash baru
$new_pass = password_hash('password_baru', PASSWORD_BCRYPT);
// Update di database
UPDATE admin SET password_hash = '$new_pass' WHERE username = 'admin';
```

---

## 🗄️ Struktur Database

### Tabel: `admin`
Login admin (password bcrypt)

### Tabel: `panduan`
Konten panduan (slug, judul, deskripsi, konten HTML, urutan, aktif)

### Tabel: `dasar_hukum`
Referensi UU & peraturan (nama_uu, tentang, ringkasan, urutan, aktif)

### Tabel: `faq`
FAQ dengan kategori (pertanyaan, jawaban, kategori, urutan, aktif)

### Tabel: `kontak_darurat`
Nomor kontak darurat (nama, nomor, keterangan, is_utama [flag urgent], urutan, aktif)

---

## 📱 Fitur Utama

### **Website Publik**
1. **Beranda** — Hero + 4 card panduan
2. **Panduan Pelaporan** — Alur pelaporan via BEBUNGE
3. **Panduan Pendampingan Psikolog** — Tahapan dukungan kesehatan jiwa
4. **Panduan Bantuan Hukum** — Hak korban & prosedur hukum
5. **Dasar Hukum** — Tabel peraturan + accordion hak korban
6. **FAQ** — Accordion dengan kategori
7. **Modal Bantuan Darurat** — Nomor kontak urgent (pull dari DB)

### **Admin Panel**
1. **Dashboard** — Stat cards + quick links
2. **Kelola Panduan** — CRUD panduan layanan
3. **Kelola Dasar Hukum** — CRUD peraturan
4. **Kelola FAQ** — CRUD FAQ
5. **Kelola Kontak Darurat** — CRUD nomor telepon (dengan flag urgent)

---

## 🔒 Keamanan

- ✅ Password di-hash dengan `password_hash()` (bcrypt)
- ✅ SQL injection dicegah dengan PDO prepared statements
- ✅ XSS dicegah dengan `htmlspecialchars()` di semua output
- ✅ HTML content disanitasi dengan `strip_tags()` whitelist
- ✅ Session-based auth di semua halaman admin
- ✅ **TIDAK ADA** form input di website publik (read-only untuk publik)

---

## 📝 Seed Data yang Tersedia

Sistem sudah terisi data contoh:
- 1 akun admin (username: `admin`)
- 3 panduan (pelaporan, psikolog, hukum)
- 5 dasar hukum (UU KDRT, Perlindungan Anak, dll)
- 5 FAQ
- 4 kontak darurat (UPTD PPA, Polisi, Ambulans, Hotline)

---

## 🎯 Panduan Penggunaan Admin

### Login
1. Buka `http://localhost/uptd_ppa/admin/login.php`
2. Masukkan username & password default
3. Klik **Login**

### Mengelola Konten

#### **Tambah Panduan Baru**
1. Sidebar → **Panduan Layanan** → **+ Tambah Panduan**
2. Isi:
   - **Judul** (akan auto-generate slug)
   - **Deskripsi** (sub-judul)
   - **Konten** (bisa pakai HTML: `<h3>`, `<p>`, `<ol>`, `<strong>`)
   - **Urutan** (1, 2, 3...)
   - Centang **Aktif** jika ingin langsung tampil di website
3. Klik **Simpan**

#### **Edit Konten**
1. Pilih menu yang ingin diedit (Panduan / Dasar Hukum / FAQ / Kontak)
2. Klik tombol **✏️ Edit** di baris yang diinginkan
3. Ubah data → **Simpan**

#### **Hapus Konten**
1. Klik tombol **🗑️ Hapus**
2. Konfirmasi di dialog popup
3. Data terhapus permanen

#### **Mengatur Kontak Darurat "Urgent"**
1. **Kontak Darurat** → **✏️ Edit** kontak yang ingin ditandai urgent
2. Centang **🚨 Prioritas Urgent**
3. Simpan → Nomor akan tampil merah di modal darurat

---

## 🧪 Testing Checklist

- [ ] Database ter-import dengan benar
- [ ] Icon semua muncul di website
- [ ] Admin bisa login
- [ ] CRUD semua berfungsi (Tambah / Edit / Hapus)
- [ ] Perubahan di admin langsung tercermin di website publik
- [ ] Modal darurat bisa dibuka dan menampilkan nomor kontak
- [ ] Responsive di mobile (test di viewport 375px)
- [ ] FAQ accordion bisa dibuka/ditutup
- [ ] Disclaimer bar muncul di beranda

---

## 📞 Support & Feedback

Sistem ini dikembangkan sebagai **draft magang** oleh Diskominfo. Untuk feedback, hubungi:
- **Diskominfo** setempat
- **UPTD PPA** terkait

---

## 📄 Lisensi

Sistem ini dikembangkan untuk keperluan internal pemerintah daerah dan bersifat **informatif** semata. Tidak untuk komersial.

---

**© 2026 Dinas Komunikasi dan Informatika**  
Draft Magang — Sistem Informasi Panduan Layanan UPTD PPA
