<?php
// Struktur Halaman PHP/HTML untuk form.php
$page_title = "Pendaftaran Workshop";
$active_page = "form";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <!-- Link ke file CSS eksternal -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="header">
        <h1>Pendaftaran Workshop Coding Dasar</h1>
    </header>

    <nav id="navbar">
        <ul>
            <li class="<?php echo ($active_page == 'home' ? 'active' : ''); ?>"><a href="index.php">Beranda</a></li>
            <li class="<?php echo ($active_page == 'form' ? 'active' : ''); ?>"><a href="form.php">Daftar Sekarang</a></li>
            <li class="<?php echo ($active_page == 'about' ? 'active' : ''); ?>"><a href="about.php">Tentang Kami</a></li>
        </ul>
    </nav>

    <div id="container">
        <div class="main-content">
            <h2>Isi Form Pendaftaran di Bawah Ini</h2>
            <p>Silakan lengkapi data Anda untuk bergabung dengan workshop kami.</p>

            <!-- Form utama yang mengirim data ke process.php menggunakan method POST -->
            <form id="registrationForm" action="process.php" method="POST">
                
                <!-- Text Field: Nama Lengkap -->
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" required placeholder="Cth: Budi Santoso">
                    <div id="namaError" class="error-message"></div>
                </div>

                <!-- Text Field: Email (untuk validasi JS/PHP format) -->
                <div class="form-group">
                    <label for="email">Email Aktif:</label>
                    <input type="text" id="email" name="email" required placeholder="Cth: email@contoh.com">
                    <div id="emailError" class="error-message"></div>
                </div>

                <!-- Select/Dropdown: Level Pelatihan -->
                <div class="form-group">
                    <label for="level">Pilih Level Pelatihan:</label>
                    <select id="level" name="level" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pemula">Pemula (Belum pernah coding)</option>
                        <option value="Dasar">Dasar (Pernah coba HTML/CSS)</option>
                        <option value="Menengah">Menengah (Pernah coba PHP/JS dasar)</option>
                    </select>
                    <div id="levelError" class="error-message"></div>
                </div>

                <!-- Textarea: Motivasi -->
                <div class="form-group">
                    <label for="motivasi">Mengapa Anda ingin ikut workshop ini? (Min. 20 Karakter):</label>
                    <textarea id="motivasi" name="motivasi" required placeholder="Tuliskan motivasi Anda..."></textarea>
                    <div id="motivasiError" class="error-message"></div>
                </div>
                
                <!-- Checkbox: Persetujuan -->
                <div class="form-group">
                    <input type="checkbox" id="setuju" name="setuju" value="ya">
                    <label for="setuju" style="display: inline;">Saya menyetujui syarat dan ketentuan pendaftaran.</label>
                    <div id="setujuError" class="error-message"></div>
                </div>

                <!-- Hidden field untuk mengirimkan waktu pendaftaran -->
                <input type="hidden" name="waktu_daftar" value="<?php echo date('Y-m-d H:i:s'); ?>">

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="button-submit">Kirim Pendaftaran</button>
                </div>
            </form>
            
        </div>
    </div>

    <footer id="footer">
        &copy; <?php echo date("Y"); ?> Workshop Coding Dasar. Dibuat dengan PHP, HTML, CSS, dan JS.
    </footer>

    <!-- Link ke file JavaScript eksternal (diasumsikan berada di js/script.js) -->
    <script src="js/script.js"></script>
</body>
</html>