CREATE DATABASE IF NOT EXISTS perusahaan_internet;

USE perusahaan_internet;

-- Membuat tabel pelanggan internet perusahaan
CREATE TABLE pelanggan_internet_perusahaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_perusahaan VARCHAR(255) NOT NULL,
    nama_pemesan VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    nomor_telepon_pemesan VARCHAR(20) NOT NULL,
    nomor_telepon_perusahaan VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL
);

-- Contoh data awal
INSERT INTO pelanggan_internet_perusahaan (nama_perusahaan, nama_pemesan, email, nomor_telepon_pemesan, nomor_telepon_perusahaan, alamat)
VALUES
('PT Teknologi Digital', 'Andi Wijaya', 'andi@teknologi.com', '081234567890', '02187654321', 'Jl. Merdeka No. 10, Jakarta'),
('CV Solusi Bisnis', 'Budi Santoso', 'budi@solusibisnis.com', '081345678901', '02176543210', 'Jl. Pahlawan No. 5, Bandung'),
('PT Jaya Makmur', 'Citra Lestari', 'citra@jayamakmur.com', '081456789012', '02165432109', 'Jl. Kemerdekaan No. 20, Surabaya');
