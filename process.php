<?php
// Struktur Halaman PHP/HTML untuk process.php
$page_title = "Hasil Pendaftaran";
$active_page = "form";

// --- 1. INCLUDE FILE KONFIGURASI DATABASE ---
include 'db_config.php';

// --- Definisi Fungsi Bantuan ---
function sanitizeInput($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $conn->real_escape_string($data);
}

$error_messages = [];
$form_data = [];
$is_valid = true;
$db_status_message = "Data belum diproses.";

// Pastikan form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Ambil dan bersihkan data (sementara, prepared statements akan dipakai untuk DB)
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $level = isset($_POST['level']) ? trim($_POST['level']) : '';
    $motivasi = isset($_POST['motivasi']) ? trim($_POST['motivasi']) : '';
    $setuju_post = isset($_POST['setuju']);
    $setuju = $setuju_post ? 'Ya' : 'Tidak';
    $waktu_daftar = isset($_POST['waktu_daftar']) ? trim($_POST['waktu_daftar']) : date('Y-m-d H:i:s');

    // --- Validasi Server ---
    if (empty($nama) || strlen($nama) < 5) {
        $error_messages[] = "Nama lengkap wajib diisi dan minimal 5 karakter.";
        $is_valid = false;
    }
    if (empty($email)) {
        $error_messages[] = "Email wajib diisi.";
        $is_valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Format email tidak valid.";
        $is_valid = false;
    }
    $valid_levels = ['Pemula', 'Dasar', 'Menengah'];
    if (empty($level) || !in_array($level, $valid_levels)) {
        $error_messages[] = "Pilihan level pelatihan tidak valid.";
        $is_valid = false;
    }
    if (empty($motivasi) || strlen($motivasi) < 20) {
        $error_messages[] = "Motivasi wajib diisi dan minimal 20 karakter.";
        $is_valid = false;
    }
    if (!$setuju_post) {
        $error_messages[] = "Anda wajib menyetujui syarat dan ketentuan.";
        $is_valid = false;
    }

    // Jika validasi berhasil, simpan data ke MySQL
    if ($is_valid) {
        $setuju_db = $setuju_post ? 1 : 0;
        $sql = "INSERT INTO registrations (nama, email, level, motivasi, setuju, waktu_daftar_client) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            // bind_param harus sesuai tipe: s = string, i = integer
            $stmt->bind_param("ssssds", $nama, $email, $level, $motivasi, $setuju_db, $waktu_daftar);
            if ($stmt->execute()) {
                $db_status_message = '<p style="color: #28a745; font-weight: bold;">[DATABASE]: Data berhasil disimpan ke MySQL.</p>';
            } else {
                if ($conn->errno == 1062) {
                    $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Gagal menyimpan data: Email sudah terdaftar!</p>';
                } else {
                    $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Error saat menyimpan data: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . '</p>';
                    $is_valid = false;
                    $error_messages[] = "Gagal menyimpan data ke database. Silakan coba lagi.";
                }
            }
            $stmt->close();
        } else {
            $db_status_message = '<p style="color: #dc3545; font-weight: bold;">[DATABASE]: Error saat menyiapkan statement: ' . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . '</p>';
            $is_valid = false;
            $error_messages[] = "Kesalahan internal server.";
        }
    }

    // Siapkan data ringkasan untuk ditampilkan (tetap tampilkan input user meskipun DB gagal)
    $form_data = [
        'nama' => $nama,
        'email' => $email,
        'level' => $level,
        'motivasi' => $motivasi,
        'setuju' => $setuju,
        'waktu_daftar' => $waktu_daftar,
        'status_pendaftaran' => ($is_valid ? 'TERDAFTAR' : 'GAGAL')
    ];

} else {
    // Jika diakses tanpa POST, arahkan kembali ke form
    header('Location: form.php');
    exit;
}

// Tutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header id="header">
        <h1>Hasil Pendaftaran Workshop</h1>
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

            <?php if ($is_valid): ?>

                <h2>Pendaftaran Berhasil!</h2>
                <p>Terima kasih <strong><?php echo htmlspecialchars($form_data['nama'], ENT_QUOTES, 'UTF-8'); ?></strong>, pendaftaran Anda telah diterima.</p>

                <div id="db-status">
                    <?php echo $db_status_message; ?>
                </div>

                <div class="result-box">
                    <h3>Ringkasan Data Pendaftaran</h3>
                    <p><strong>Status:</strong> <span style="color: #28a745; font-weight: bold;">BERHASIL</span></p>
                    <p><strong>Waktu Pendaftaran:</strong> <?php echo htmlspecialchars($form_data['waktu_daftar'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <hr>
                    <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($form_data['nama'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($form_data['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Level Dipilih:</strong> <?php echo htmlspecialchars($form_data['level'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Setuju Syarat & Ketentuan:</strong> <?php echo htmlspecialchars($form_data['setuju'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Motivasi Utama:</strong></p>
                    <blockquote style="margin: 0 0 10px 15px; padding: 10px; border-left: 3px solid #0d6efd; background-color: #f0f8ff;">
                        <?php echo nl2br(htmlspecialchars($form_data['motivasi'], ENT_QUOTES, 'UTF-8')); ?>
                    </blockquote>
                    <p>Detail informasi workshop akan dikirimkan ke email Anda.</p>
                </div>

            <?php else: ?>

                <h2>Pendaftaran Gagal!</h2>
                <p>Terjadi kesalahan saat memproses pendaftaran Anda. Mohon periksa kembali data yang Anda masukkan.</p>

                <div class="alert alert-error">
                    <strong>Alasan Kegagalan:</strong>
                    <ul>
                        <?php foreach ($error_messages as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

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

    <!-- Include shared JS (validation + toast) -->
    <script src="js/script.js"></script>
    <script>
    (function(){
        var type = <?php echo json_encode($is_valid ? 'success' : 'error'); ?>;
        var message = <?php
            if ($is_valid) {
                $m = 'Pendaftaran berhasil. Terima kasih ' . (isset($form_data['nama']) ? $form_data['nama'] : '') . '.';
            } else {
                $m = !empty($error_messages) ? $error_messages[0] : 'Terjadi kesalahan saat memproses pendaftaran.';
            }
            echo json_encode($m);
        ?>;

        document.addEventListener('DOMContentLoaded', function(){
            if (typeof window.showToast === 'function') {
                window.showToast(type, message, 6000);
            } else {
                console.log(type + ': ' + message);
            }
        });
    })();
    </script>

</body>
</html>