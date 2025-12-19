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
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome (ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header id="header">
        <h1>Pendaftaran Workshop Coding Dasar</h1>
    </header>

    <nav id="navbar">
        <button id="navToggle" class="navbar-toggle" aria-expanded="false" aria-controls="navMenu"><i class="fa-solid fa-bars"></i><span class="sr-only">Menu</span></button>
        <div id="navMenu" class="nav-menu">
            <ul>
                <li class="<?php echo ($active_page == 'home' ? 'active' : ''); ?>"><a href="index.php">Beranda</a></li>
                <li class="<?php echo ($active_page == 'form' ? 'active' : ''); ?>"><a href="form.php" class="nav-cta">Daftar Sekarang</a></li>
                <li class="<?php echo ($active_page == 'about' ? 'active' : ''); ?>"><a href="about.php">Tentang Kami</a></li>
            </ul>
        </div>
    </nav>

    <div id="container">
        <div class="main-content" role="main">
            <h2>Isi Form Pendaftaran di Bawah Ini</h2>
            <p>Silakan lengkapi data Anda untuk bergabung dengan workshop kami.</p>

            <!-- Form utama yang mengirim data ke process.php menggunakan method POST -->
            <form id="registrationForm" action="process.php" method="POST" novalidate>
                
                <!-- Text Field: Nama Lengkap -->
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" required placeholder="Cth: Budi Santoso" aria-describedby="namaError">
                    <div id="namaError" class="error-message" role="alert" aria-live="polite"></div>
                </div>

                <!-- Text Field: Email (untuk validasi JS/PHP format) -->
                <div class="form-group">
                    <label for="email">Email Aktif:</label>
                    <input type="email" id="email" name="email" required placeholder="Cth: email@contoh.com" aria-describedby="emailError">
                    <div id="emailError" class="error-message" role="alert" aria-live="polite"></div>
                </div>

                <!-- Select/Dropdown: Level Pelatihan -->
                <div class="form-group">
                    <label for="level">Pilih Level Pelatihan:</label>
                    <select id="level" name="level" required aria-describedby="levelError">
                        <option value="">-- Pilih --</option>
                        <option value="Pemula">Pemula (Belum pernah coding)</option>
                        <option value="Dasar">Dasar (Pernah coba HTML/CSS)</option>
                        <option value="Menengah">Menengah (Pernah coba PHP/JS dasar)</option>
                    </select>
                    <div id="levelError" class="error-message" role="alert" aria-live="polite"></div>
                </div>

                <!-- Textarea: Motivasi -->
                <div class="form-group">
                    <label for="motivasi">Mengapa Anda ingin ikut workshop ini? (Min. 20 Karakter):</label>
                    <textarea id="motivasi" name="motivasi" required placeholder="Tuliskan motivasi Anda..." aria-describedby="motivasiError"></textarea>
                    <div id="motivasiError" class="error-message" role="alert" aria-live="polite"></div>
                </div>
                
                <!-- Checkbox: Persetujuan -->
                <div class="form-group">
                    <label class="checkbox-inline"><input type="checkbox" id="setuju" name="setuju" value="ya" aria-describedby="setujuError"> Saya menyetujui syarat dan ketentuan pendaftaran.</label>
                    <div id="setujuError" class="error-message" role="alert" aria-live="polite"></div>
                </div>

                <!-- Hidden field untuk mengirimkan waktu pendaftaran -->
                <input type="hidden" name="waktu_daftar" value="<?php echo date('Y-m-d H:i:s'); ?>">

                <!-- Tombol Submit -->
                <div class="form-group">
                    <button type="submit" class="button-submit"><i class="fa-solid fa-paper-plane" style="margin-right:8px"></i>Kirim Pendaftaran</button>
                </div>
            </form>
            
        </div>
    </div>

    <footer id="footer">
        &copy; <?php echo date("Y"); ?> Workshop Coding Dasar. Dibuat dengan PHP, HTML, CSS, dan JS.
    </footer>

    <!-- Link ke file JavaScript eksternal (diasumsikan berada di js/script.js) -->
    <script src="js/script.js"></script>
    <script>
    // Show toast if redirected back with status/msg params
    (function(){
        try {
            const params = new URLSearchParams(window.location.search);
            const status = params.get('status');
            const msg = params.get('msg');
            if (status && msg) {
                // Wait until showToast is available
                function onceReady(){
                    if (typeof window.showToast === 'function'){
                        window.showToast(status === 'success' ? 'success' : 'error', decodeURIComponent(msg), 6000);
                    } else {
                        // retry shortly
                        setTimeout(onceReady, 120);
                    }
                }
                onceReady();

                // Clean URL so toast won't show again on refresh
                if (window.history && window.history.replaceState) {
                    const clean = window.location.pathname;
                    window.history.replaceState({}, document.title, clean);
                }
            }
        } catch (e) { console.error(e); }
    })();
    </script>
</body>
</html>