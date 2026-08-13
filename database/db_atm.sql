-- membuat databse atm
CREATE DATABASE atm;

-- aktifkan database atm
USE atm;

-- membuat tabel rekening
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_rekening VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    pin VARCHAR(10) NOT NULL,
    saldo DECIMAL(15,2) NOT NULL DEFAULT 0,
    status ENUM('AKTIF','BLOKIR') NOT NULL DEFAULT 'AKTIF'
) ENGINE=InnoDB;

-- membuat tabel transaksi
CREATE TABLE transactions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nomor_rekening VARCHAR(20) NOT NULL,
    jenis ENUM('TARIK') NOT NULL,
    jumlah DECIMAL(15,2) NOT NULL,
    saldo_sebelum DECIMAL(15,2) NOT NULL,
    saldo_sesudah DECIMAL(15,2) NOT NULL,
    waktu TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- input data akun
INSERT INTO accounts
(nomor_rekening, nama, pin, saldo)
VALUES
('100001', 'Ahmad', '1234', 1000000),
('100002', 'Budi', '1234', 750000),
('100003', 'Citra', '1234', 500000),
('100004', 'Dewi', '1234', 1500000);



-- setting database akun atm
CREATE USER 'atm'@'%' IDENTIFIED BY 'atm123';

GRANT SELECT, INSERT, UPDATE
ON atm.*
TO 'atm'@'%';

FLUSH PRIVILEGES;
