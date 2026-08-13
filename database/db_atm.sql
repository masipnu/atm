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
-- INSERT INTO accounts (nomor_rekening, nama, pin, saldo) VALUES
-- ('100001', 'Ahmad', '1234', 1000000),
-- ('100002', 'Budi', '1234', 750000),
-- ('100003', 'Citra', '1234', 500000),
-- ('100004', 'Dewi', '1234', 1500000);

-- input data akun siswa
INSERT INTO accounts (nomor_rekening, nama, pin, saldo) VALUES
("ID20260001","Ahdiyana Fatwani Maulafia","123456",1000000),
("ID20260002","Ahmad Akbar Taufiqurrahman","123456",1000000),
("ID20260003","Ahmad Hadi Mahmud","123456",1000000),
("ID20260004","Ahmad Syarifuddin","123456",1000000),
("ID20260005","Aira Surya Pratama","123456",1000000),
("ID20260006","Ambar Rohmah","123456",1000000),
("ID20260007","Arifah Nuril Mursyidah","123456",1000000),
("ID20260008","Azza Asyura Alhafizh Pramawa","123456",1000000),
("ID20260009","Azzahratun Nur'Aini","123456",1000000),
("ID20260010","Azzura Zahra","123456",1000000),
("ID20260011","Enggar Kirana Ramadhani","123456",1000000),
("ID20260012","Fadhil Nur Faiz","123456",1000000),
("ID20260013","Faizatul Alya","123456",1000000),
("ID20260014","Izna Ayu Destika Munawaroh","123456",1000000),
("ID20260015","Luthfia Zalfa Ardisyaputri","123456",1000000),
("ID20260016","Mega Alya Putri","123456",1000000),
("ID20260017","Megananda Crystal Maliha Syisyoria Suhandono","123456",1000000),
("ID20260018","Meytta Putri Nabila Gusti","123456",1000000),
("ID20260019","Muflihatuddaroini","123456",1000000),
("ID20260020","Muhammad Ilham Musyaffa'","123456",1000000),
("ID20260021","Muhammad Raihan Fuad Fakhrurrozi","123456",1000000),
("ID20260022","Muhammad Shalman Al Farizzi","123456",1000000),
("ID20260023","Nazhifah","123456",1000000),
("ID20260024","Nur Fauziah Eli Melsy","123456",1000000),
("ID20260025","Putri Agusti Nailaturrohmah","123456",1000000),
("ID20260026","Reyfaldo Maulana Rasyid","123456",1000000),
("ID20260027","Shobibar Ridlwan","123456",1000000),
("ID20260028","Sukma Maulida Hidayati","123456",1000000),
("ID20260029","Ulya Zumrotul Muwahidah","123456",1000000),
("ID20260030","Yanuharti Widhi Astuti","123456",1000000),
("ID20260031","Yoshi Arwan Zullathiif","123456",1000000);


-- setting database akun atm
CREATE USER 'atm'@'%' IDENTIFIED BY 'atm123';

GRANT SELECT, INSERT, UPDATE
ON atm.*
TO 'atm'@'%';

FLUSH PRIVILEGES;