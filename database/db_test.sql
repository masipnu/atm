-- cek data akun
SELECT * FROM accounts;


-- test tarik tunai
UPDATE accounts
SET saldo = saldo - 100000
WHERE nomor_rekening = '100001';


-- tambahkan di tabel transaksi
INSERT INTO transactions
(
    nomor_rekening,
    jenis,
    jumlah,
    saldo_sebelum,
    saldo_sesudah
)
VALUES
(
    '100001',
    'TARIK',
    100000,
    1000000,
    900000
);


-- cek saldo akun
SELECT *
FROM accounts
WHERE nomor_rekening = '100001';


-- cek transaksi
SELECT *
FROM transactions
WHERE nomor_rekening = '100001';