CREATE TABLE registrations (
    -- ID unik untuk setiap pendaftaran (Primary Key, Auto-increment)
    id INT(11) NOT NULL AUTO_INCREMENT,
    
    -- Data pendaftar
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    level ENUM('Pemula', 'Dasar', 'Menengah') NOT NULL,
    motivasi TEXT NOT NULL,
    setuju BOOLEAN NOT NULL DEFAULT 0, -- 1 = Ya, 0 = Tidak
    
    -- Metadata waktu pendaftaran
    waktu_daftar_client DATETIME NOT NULL,
    timestamp_server TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Waktu saat data dimasukkan ke database
    
    PRIMARY KEY (id),
    UNIQUE KEY email_unique (email) -- Memastikan satu email hanya bisa mendaftar sekali
);