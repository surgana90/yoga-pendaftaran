<?php
// Struktur Halaman PHP/HTML untuk process.php
$page_title = "Hasil Pendaftaran";
$active_page = "form"; // Tetap tandai 'form' aktif karena ini adalah hasil dari form

// --- 1. INCLUDE FILE KONFIGURASI DATABASE ---
// Pastikan file db_config.php berada di lokasi yang benar
include 'db_config.php';

// --- Definisi Fungsi Bantuan ---
function sanitizeInput($conn, $data) {
    // Bersihkan data dan gunakan fungsi real_escape_string dari MySQLi
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // Escape string untuk keamanan tambahan sebelum Prepared Statement
    return $conn->real_escape_string($data); 
}

// --- Mulai Logika Pemrosesan Form ---

$error_messages = [];
$form_data = [];
$is_valid = true;
$db_status_message = "Data belum diproses.";

// Pastikan form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil dan bersihkan data
    // Catatan: Hanya membersihkan input di sini, escaping MySQLi akan dilakukan sebelum Prepared Statement.
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $level = isset($_POST['level']) ? trim($_POST['level']) : '';
    $motivasi = isset($_POST['motivasi']) ? trim($_POST['motivasi']) : '';
    $setuju_post = isset($_POST['setuju']); // Cek apakah checkbox ada di POST
    $setuju = $setuju_post ? 'Ya' : 'Tidak';
    $waktu_daftar = isset($_POST['waktu_daftar']) ? trim($_POST['waktu_daftar']) : date('Y-m-d H:i:s');


    // --- Validasi Sederhana di Server ---

    // 1. Validasi Nama
    if (empty($nama) || strlen($nama) < 5) {
        $error_messages[] = "Nama lengkap wajib diisi dan minimal 5 karakter.";
        $is_valid = false;
    }

    // 2. Validasi Email
    if (empty($email)) {
        $error_messages[] = "Email wajib diisi.";
        $is_valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Format email tidak valid.";
        $is_valid = false;
    }

    // 3. Validasi Level
    $valid_levels = ['Pemula', 'Dasar', 'Menengah'];
    if (empty($level) || !in_array($level, $valid_levels)) {
        $error_messages[] = "Pilihan level pelatihan tidak valid.";
        $is_valid = false;
    }

    // 4. Validasi Motivasi
    if (empty($motivasi) || strlen($motivasi) < 20) {
        $error_messages[] = "Motivasi wajib diisi dan minimal 20 karakter.";
        $is_valid = false;
    }
    
    // 5. Validasi Persetujuan
    if (!$setuju_post) {
        $error_messages[] = "Anda wajib menyetujui syarat dan ketentuan.";
        $is_valid = false;
    }

    // Jika validasi berhasil, simpan data ke MySQL
    if ($is_valid) {
        
        // --- LOGIKA PENYIMPANAN DATA KE MYSQL DENGAN PREPARED STATEMENT ---
        
        // Konversi persetujuan ke format BOOLEAN (1 atau 0) untuk database
        $setuju_db = $setuju_post ? 1 : 0;
        
        // Prepared Statement untuk mencegah SQL Injection
        $sql = "INSERT INTO registrations (nama, email, level, motivasi, setuju, waktu_daftar_client) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter ke statement
            $stmt->bind_param("ssssis", $nama, $email, $level, $motivasi, $setuju_db, $waktu_daftar);
            
            // Eksekusi statement
            if ($stmt->execute()) {
                $db_status_message = '<p style="color: #28a745; font-weight: bold;">[DATABASE]: Data berhasil disimpan ke MySQL.</p>';
            } else {
                 // Penggunaan struktur kontrol IF/ELSE untuk menangani error
                if ($conn->errno == 1062) {
                     // Error 1062 = Duplicate entry (karena email_unique)
                    $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Gagal menyimpan data: Email sudah terdaftar!</p>';
                } else {
                    $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Error saat menyimpan data: ' . $stmt->error . '</p>';
                    $is_valid = false; // Gagal menyimpan = dianggap gagal
                    $error_messages[] = "Gagal menyimpan data ke database. Silakan coba lagi.";
                }
            }
            // Tutup statement
            $stmt->close();
        } else {
            $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Error saat menyiapkan statement: ' . $conn->error . '</p>';
            $is_valid = false;
            $error_messages[] = "Kesalahan internal server.";
        }
        
        // Data yang ditampilkan di halaman hasil (walaupun penyimpanan gagal, kita tetap menampilkan data yang diinput)
        $form_data = [
            'nama' => $nama,
            'email' => $email,
            'level' => $level,
            'motivasi' => $motivasi,
            'setuju' => $setuju,
            'waktu_daftar' => $waktu_daftar,
            'status_pendaftaran' => ($is_valid ? 'TERDAFTAR' : 'GAGAL DISIMPAN')
        ];
    }

} else {
    // Jika diakses tanpa POST, arahkan kembali ke form.php
    header('Location: form.php');
    exit;
}

// Tutup koneksi setelah semua selesai
$conn->close();

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
        <h1>Hasil Pendaftaran Workshop</h1>
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
            
            <?php if ($is_valid): ?>
                
                <h2>Pendaftaran Berhasil!</h2>
                <p>Terima kasih <strong><?php echo htmlspecialchars($form_data['nama']); ?></strong>, validasi berhasil dilakukan.</p>
                
                <!-- Status MySQL akan ditampilkan di sini -->
                <div id="db-status">
                    <?php echo $db_status_message; ?>
                </div>

                <!-- Menampilkan hasil pengolahan dalam format HTML yang rapi -->
                <div class="result-box">
                    <h3>Ringkasan Data Pendaftaran</h3>
                    
                    <p><strong>Status:</strong> <span style="color: #28a745; font-weight: bold;">BERHASIL VALIDASI</span></p>
                    <p><strong>Waktu Pendaftaran:</strong> <?php echo htmlspecialchars($form_data['waktu_daftar']); ?></p>
                    <hr>
                    <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($form_data['nama']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($form_data['email']); ?></p>
                    <p><strong>Level Dipilih:</strong> <?php echo htmlspecialchars($form_data['level']); ?></p>
                    <p><strong>Setuju Syarat & Ketentuan:</strong> <?php echo htmlspecialchars($form_data['setuju']); ?></p>
                    <p><strong>Motivasi Utama:</strong></p>
                    <blockquote style="margin: 0 0 10px 15px; padding: 10px; border-left: 3px solid #007bff; background-color: #f0f8ff;">
                        <?php echo nl2br(htmlspecialchars($form_data['motivasi'])); ?>
                    </blockquote>
                    <p>Detail informasi workshop akan dikirimkan ke email Anda.</p>
                </div>

            <?php else: ?>

                <h2>Pendaftaran Gagal!</h2>
                <p>Terjadi kesalahan saat memproses pendaftaran Anda. Mohon periksa kembali data yang Anda masukkan.</p>
                
                <!-- Tampilkan pesan error (Looping) -->
                <div class="alert alert-error">
                    <strong>Alasan Kegagalan:</strong>
                    <ul>
                        <?php 
                        // Penggunaan struktur kontrol LOOP (foreach)
                        foreach ($error_messages as $error) {
                            echo "<li>" . htmlspecialchars($error) . "</li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- Tampilkan status database jika ada error spesifik dari DB -->
                <?php if (!empty($db_status_message) && $db_status_message !== "Data belum diproses."): ?>
                    <div id="db-status">
                        <?php echo $db_status_message; ?>
                    </div>
                <?php endif; ?>
                
                <p style="text-align: center;">
                    <a href="form.php" class="button-submit" style="background-color: #dc3545; text-decoration: none;">&laquo; Kembali ke Form Pendaftaran</a>
                </p>

            <?php endif; ?>

        </div>
    </div>

    <footer id="footer">
        &copy; <?php echo date("Y"); ?> Workshop Coding Dasar. Dibuat dengan PHP, HTML, CSS, dan JS.
    </footer>

</body>
</html>