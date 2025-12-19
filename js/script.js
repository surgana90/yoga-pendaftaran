/**
 * File: js/script.js
 * Tujuan: Validasi form di sisi klien sebelum dikirim.
 */

/* Toast utility: showToast(type, message, durationMs) */
function showToast(type, message, duration = 4500) {
    if (!document) return;
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast ' + (type === 'success' ? 'toast--success' : 'toast--error');

    const icon = document.createElement('div');
    icon.className = 'toast-icon';
    icon.innerHTML = type === 'success' ? '<i class="fa-solid fa-circle-check" style="color:#28a745"></i>' : '<i class="fa-solid fa-circle-exclamation" style="color:#dc3545"></i>';

    const msg = document.createElement('div');
    msg.className = 'toast-message';
    msg.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(msg);
    container.appendChild(toast);

    // Auto remove
    setTimeout(() => {
        toast.classList.add('toast-hide');
        setTimeout(() => toast.remove(), 320);
    }, duration);
}

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

            // Jika ada validasi yang gagal, hentikan pengiriman form dan fokus ke error pertama
            if (!isValid) {
                event.preventDefault();
                const firstError = Array.from(document.querySelectorAll('.error-message')).find(el => el.textContent.trim() !== '');
                if (firstError) {
                    const inputId = firstError.id.replace('Error', '');
                    const field = document.getElementById(inputId);
                    if (field) {
                        field.focus();
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            } else {
                // Konfirmasi sebelum kirim (lapisan tambahan)
                if (!confirm("Apakah Anda yakin data pendaftaran sudah benar?")) {
                    event.preventDefault();
                }
            }
        });
    }
});

// Expose to global so other pages can call showToast
window.showToast = showToast;

// Navbar toggle behavior (for small screens)
document.addEventListener('DOMContentLoaded', function(){
    var navToggle = document.getElementById('navToggle');
    var navbar = document.getElementById('navbar');
    var navMenu = document.getElementById('navMenu');
    if (navToggle && navbar && navMenu) {
        navToggle.addEventListener('click', function(){
            var isOpen = navbar.classList.toggle('open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            // swap icon between bars and x
            try {
                var ic = navToggle.querySelector('i');
                if (ic) {
                    if (isOpen) {
                        ic.classList.remove('fa-bars');
                        ic.classList.add('fa-xmark');
                    } else {
                        ic.classList.remove('fa-xmark');
                        ic.classList.add('fa-bars');
                    }
                }
            } catch (e) { /* ignore */ }
        });

        // Close menu when clicking a nav link (mobile)
        navMenu.addEventListener('click', function(e){
            if (e.target.tagName === 'A' && window.innerWidth <= 700) {
                navbar.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on outside click
        document.addEventListener('click', function(e){
            if (!navbar.contains(e.target) && navbar.classList.contains('open')){
                navbar.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});