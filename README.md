
# Website Pendaftaran Workshop Coding Dasar

Website ini merupakan aplikasi web sederhana untuk pendaftaran **Workshop Coding Dasar**.  
Aplikasi dirancang sebagai project pembelajaran untuk memahami dasar **HTML, CSS, JavaScript, PHP, dan MySQL**.

---

## 🚀 Fitur Utama
- Halaman Beranda berisi informasi workshop
- Form pendaftaran peserta workshop
- Validasi form (client-side & server-side)
- Penyimpanan data pendaftaran ke database MySQL
- Halaman hasil pendaftaran
- Halaman Tentang Kami

---

## 🗂 Struktur Data (Database)
Tabel utama: `pendaftaran_workshop`

| Field | Keterangan |
|------|------------|
| nama_lengkap | Nama peserta |
| email | Email aktif |
| level_pelatihan | Level pelatihan |
| motivasi | Alasan mengikuti workshop |
| persetujuan | Persetujuan syarat |
| waktu_pendaftaran | Waktu daftar |

---

## 📝 Input Form
- **Nama Lengkap** (text)
- **Email Aktif** (email)
- **Level Pelatihan** (select)
- **Motivasi** (textarea)
- **Persetujuan Syarat** (checkbox)
- **Kirim Pendaftaran** (submit)

---

## 🛠 Stack Teknologi
- HTML5
- CSS3
- JavaScript
- PHP
- MySQL

---

## 📁 Struktur Folder
```text
project-workshop/
├── index.php        # Halaman Beranda
├── daftar.php       # Form pendaftaran
├── hasil.php        # Hasil pendaftaran
├── tentang.php      # Tentang Kami
├── koneksi.php      # Koneksi database
├── css/
│   └── style.css    # Styling utama
└── js/
    └── validasi.js  # Validasi form
```

---

## ▶️ Cara Menjalankan Aplikasi
1. Install **XAMPP / Laragon**
2. Salin folder project ke `htdocs`
3. Import database MySQL
4. Jalankan Apache & MySQL
5. Buka browser dan akses:
   ```
   [http://localhost/Web_workshop/index.php]
   ```

---

## ⚙ Cara Kerja Aplikasi
1. User membuka halaman pendaftaran
2. Mengisi form data peserta
3. JavaScript melakukan validasi awal
4. Data dikirim ke server (POST)
5. PHP memproses & menyimpan ke MySQL
6. Sistem menampilkan hasil pendaftaran

---

## 🎨 Tema & Styling
- Warna dominan biru & putih
- Desain minimalis dan modern
- Menggunakan CSS box model
- Tombol interaktif dengan hover effect

---

## 📱 Responsive Design
Aplikasi mendukung tampilan:
- Desktop
- Tablet
- Smartphone

Layout menyesuaikan ukuran layar agar tetap nyaman digunakan.

---

## 🔐 Keamanan Dasar
- Validasi input client & server
- Sanitasi data input
- Penggunaan metode POST
- Validasi format email

---

## 📄 Lisensi
Project ini dibuat untuk **keperluan pembelajaran dan tugas akademik**.  
Tidak diperkenankan digunakan untuk tujuan komersial tanpa izin.

---

