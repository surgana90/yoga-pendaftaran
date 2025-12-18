<?php
// File: db_config.php
// Konfigurasi koneksi database MySQL lokal (phpMyAdmin)

// --- GANTI NILAI BERIKUT SESUAI DENGAN PENGATURAN LOKAL ANDA ---
define('DB_SERVER', 'localhost'); // Biasanya 'localhost' untuk XAMPP/WAMP
define('DB_USERNAME', 'root');    // Username default XAMPP/WAMP
define('DB_PASSWORD', '');        // Password default XAMPP/WAMP (kosong)
define('DB_NAME', 'workshop_db'); // Ganti dengan nama database yang Anda buat di phpMyAdmin

/**
 * Membuat koneksi database.
 * Gunakan MySQLi, karena lebih modern daripada ekstensi mysql_ lama.
 */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    // Hentikan skrip dan tampilkan pesan error koneksi
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>