-- Membuat database
CREATE DATABASE internet_rumahan;

-- Menggunakan database
USE internet_rumahan;

-- Membuat tabel pelanggan
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nomor_telepon VARCHAR(15) NOT NULL,
    nomor_telepon_alternatif VARCHAR(15),
    paket_dipilih VARCHAR(50) NOT NULL,
    kecamatan VARCHAR(50) NOT NULL,
    alamat_lengkap TEXT NOT NULL
);

-- Contoh data untuk tabel pelanggan
INSERT INTO pelanggan (nama_lengkap, email, nomor_telepon, nomor_telepon_alternatif, paket_dipilih, kecamatan, alamat_lengkap)
VALUES
    ('Rani Sari', 'rani@example.com', '08123456789', '08198765432', 'Paket Premium', 'Pekanbaru', 'Jl. Sudirman No. 10'),
    ('Budi Santoso', 'budi@example.com', '08234567890', NULL, 'Paket Standar', 'Siak', 'Jl. Merdeka No. 5'),
    ('Tari Wijaya', 'tari@example.com', '08345678901', '08567890123', 'Paket Basic', 'Dumai', 'Jl. Bahagia No. 15');
