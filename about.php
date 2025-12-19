<?php
// Struktur Halaman PHP/HTML untuk about.php
$page_title = "Tentang Kami";
$active_page = "about";
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
        <h1>Informasi Tentang Workshop</h1>
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
            <h2>Visi & Misi Workshop</h2>
            
            <p><strong>Visi:</strong> Menjadi platform edukasi coding terkemuka di Indonesia yang mencetak talenta digital berkualitas dan siap kerja.</p>
            
            <p><strong>Misi:</strong></p>
            <ol>
                <li>Menyediakan kurikulum yang relevan dengan kebutuhan industri saat ini.</li>
                <li>Memberikan pelatihan berbasis praktik dan proyek nyata.</li>
                <li>Menciptakan komunitas belajar yang suportif dan kolaboratif.</li>
            </ol>

            <h3>Fasilitator Kami</h3>
            <p>Tim kami terdiri dari para developer senior dengan pengalaman lebih dari 10 tahun di industri teknologi. Mereka berkomitmen untuk membagikan pengetahuan terbaik dan mendampingi Anda hingga mahir.</p>

            <h3>Kontak Kami</h3>
            <p>Jika ada pertanyaan lebih lanjut, silakan hubungi kami:</p>
            <ul>
                <li>Email: info@codingdasar.com</li>
                <li>Telepon: (021) 123-4567</li>
            </ul>
        </div>
    </div>

    <footer id="footer">
        &copy; <?php echo date("Y"); ?> Workshop Coding Dasar. Dibuat dengan PHP, HTML, CSS, dan JS.
    </footer>

</body>
</html>