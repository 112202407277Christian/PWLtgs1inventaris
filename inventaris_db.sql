CREATE DATABASE inventaris_db;
USE inventaris_db;

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    tanggal_masuk DATE NOT NULL
);