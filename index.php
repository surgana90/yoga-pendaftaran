<?php
// Struktur Halaman PHP/HTML untuk index.php
$page_title = "Home | Workshop Coding Dasar";
$active_page = "home";
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
        <h1>Workshop Coding Dasar: Bangun Karir Digital Anda</h1>
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
        <div class="main-content">
            <h2>Selamat Datang di Workshop Coding Dasar</h2>
            
            <p><strong>Apa yang akan Anda pelajari?</strong></p>
            <p>Workshop ini dirancang untuk pemula yang ingin memulai perjalanan mereka di dunia pemrograman. Kami akan mengajarkan dasar-dasar HTML, CSS, JavaScript, dan logika pemrograman menggunakan PHP.</p>
            
            <p>Program kami meliputi:</p>
            <ul>
                <li>Pengenalan Struktur Web (HTML5)</li>
                <li>Desain dan Tata Letak Responsif (CSS3)</li>
                <li>Interaksi Dasar Klien (JavaScript)</li>
                <li>Logika Sisi Server dan Form Handling (PHP)</li>
            </ul>

            <img src="https://placehold.co/800x200/007bff/white?text=PENAWARAN+EKSKLUSIF+WORKSHOP+CODING" alt="Banner Workshop Coding" style="width: 100%; border-radius: 8px; margin: 20px 0;">

            <h3>Siapa yang cocok?</h3>
            <p>Workshop ini sangat ideal untuk mahasiswa, profesional yang ingin beralih karir, atau siapa pun yang tertarik untuk memahami cara kerja aplikasi web dari nol. Tidak ada pengalaman coding sebelumnya yang diwajibkan!</p>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="form.php" class="button-submit" style="text-decoration: none;">Ambil Langkah Pertama Anda! &raquo;</a>
            </p>
        </div>
    </div>

    <footer id="footer">
        &copy; <?php echo date("Y"); ?> Workshop Coding Dasar. Dibuat dengan PHP, HTML, CSS, dan JS.
    </footer>

</body>
</html>