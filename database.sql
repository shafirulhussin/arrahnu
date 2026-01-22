CREATE DATABASE IF NOT EXISTS arrahnu_db;
USE arrahnu_db;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    ic VARCHAR(20) NOT NULL UNIQUE,
    no_telefon VARCHAR(20) NOT NULL,
    kata_laluan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: emas_settings
CREATE TABLE IF NOT EXISTS emas_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis_emas VARCHAR(50) NOT NULL, -- Contoh: '999', '916'
    harga_semasa DECIMAL(10, 2) NOT NULL,
    tarikh_kemaskini DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: transaksi_gadaian
CREATE TABLE IF NOT EXISTS transaksi_gadaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    berat_emas DECIMAL(10, 2) NOT NULL, -- dalam gram
    nilai_marhun DECIMAL(10, 2) NOT NULL,
    jumlah_pinjaman DECIMAL(10, 2) NOT NULL,
    kadar_ujrah DECIMAL(10, 2) NOT NULL,
    tarikh_mula DATE NOT NULL,
    tarikh_matang DATE NOT NULL,
    status ENUM('aktif', 'ditebus', 'dilelong', 'tamat_tempoh') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
