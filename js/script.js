/**
 * File: js/script.js
 * Tujuan: Validasi form di sisi klien sebelum dikirim.
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    // Pastikan kita berada di halaman yang memiliki form ini
    if (form) {
        form.addEventListener('submit', function(event) {
            
            // Hentikan pengiriman form secara default
            let isValid = true;
            
            // 1. Ambil nilai-nilai field
            const nama = form.elements['nama'].value.trim();
            const email = form.elements['email'].value.trim();
            const level = form.elements['level'].value;
            const setuju = form.elements['setuju'].checked;
            const motivasi = form.elements['motivasi'].value.trim();
            
            // Reset pesan error
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            // --- Validasi Field Wajib Isi (Text Field, Select, Textarea) ---

            // Validasi Nama
            if (nama === "") {
                document.getElementById('namaError').textContent = "Nama wajib diisi.";
                isValid = false;
            }

            // Validasi Email (Wajib diisi & format sederhana)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "") {
                 document.getElementById('emailError').textContent = "Email wajib diisi.";
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('emailError').textContent = "Format email tidak valid.";
                isValid = false;
            }

            // Validasi Level (Select)
            if (level === "") {
                document.getElementById('levelError').textContent = "Pilih level pelatihan wajib diisi.";
                isValid = false;
            }

            // Validasi Motivasi (Textarea, panjang minimal 20 karakter)
            if (motivasi === "") {
                document.getElementById('motivasiError').textContent = "Motivasi wajib diisi.";
                isValid = false;
            } else if (motivasi.length < 20) {
                document.getElementById('motivasiError').textContent = "Motivasi minimal 20 karakter.";
                isValid = false;
            }
            
            // --- Validasi Checkbox ---

            // Validasi Checkbox
            if (!setuju) {
                document.getElementById('setujuError').textContent = "Anda harus menyetujui syarat & ketentuan.";
                isValid = false;
            }

            // Jika ada validasi yang gagal, hentikan pengiriman form
            if (!isValid) {
                event.preventDefault();
                alert("Mohon periksa kembali isian form Anda!"); // Pesan konfirmasi/peringatan sederhana
            } else {
                // Interaksi sederhana: Konfirmasi sebelum kirim (lapisan tambahan)
                if (!confirm("Apakah Anda yakin data pendaftaran sudah benar?")) {
                    event.preventDefault();
                }
            }
        });
    }
});