-- Database untuk Aplikasi Hotel

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'resepsionis', 'tamu') DEFAULT 'tamu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Kamar
CREATE TABLE kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_kamar VARCHAR(10) UNIQUE NOT NULL,
    tipe_kamar VARCHAR(50) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    status ENUM('tersedia', 'dipesan', 'ditempati') DEFAULT 'tersedia'
);


CREATE TABLE reservasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    kamar_id INT,
    tanggal_check_in DATE NOT NULL,
    tanggal_check_out DATE NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan') DEFAULT 'menunggu',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (kamar_id) REFERENCES kamar(id)
      FOREIGN KEY (username) REFERENCES users(username),
);
