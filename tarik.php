<?php

session_start();
require 'config.php';

if (!isset($_SESSION['rekening'])) {
    header("Location: login.php");
    exit;
}

$rekening = $_SESSION['rekening'];

$pesan = "";

if (isset($_POST['tarik'])) {

    $jumlah = (int) $_POST['jumlah'];

    if ($jumlah <= 0) {

        $pesan = "Jumlah penarikan tidak valid.";

    } else {

        mysqli_begin_transaction($conn);

        try {

            /*
             * Ambil saldo
             */
            $sql = "
                SELECT saldo
                FROM accounts
                WHERE nomor_rekening = '$rekening'
                FOR UPDATE
            ";

            $result = mysqli_query($conn, $sql);

            if (!$result || mysqli_num_rows($result) != 1) {
                throw new Exception(
                    "Rekening tidak ditemukan."
                );
            }

            $data = mysqli_fetch_assoc($result);

            $saldo_sebelum = $data['saldo'];

            /*
             * Cek saldo
             */
            if ($saldo_sebelum < $jumlah) {

                throw new Exception(
                    "Saldo tidak mencukupi."
                );

            }

            /*
             * Hitung saldo baru
             */
            $saldo_sesudah =
                $saldo_sebelum - $jumlah;

            /*
             * Update saldo
             */
            $sql = "
                UPDATE accounts
                SET saldo = $saldo_sesudah
                WHERE nomor_rekening = '$rekening'
            ";

            if (!mysqli_query($conn, $sql)) {
                throw new Exception(
                    "Gagal memperbarui saldo."
                );
            }

            /*
             * Simpan transaksi
             */
            $sql = "
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
                    '$rekening',
                    'TARIK',
                    $jumlah,
                    $saldo_sebelum,
                    $saldo_sesudah
                )
            ";

            if (!mysqli_query($conn, $sql)) {
                throw new Exception(
                    "Gagal mencatat transaksi."
                );
            }

            /*
             * Semua berhasil
             */
            mysqli_commit($conn);

            $pesan =
                "Penarikan berhasil. " .
                "Saldo sekarang Rp " .
                number_format(
                    $saldo_sesudah,
                    0,
                    ',',
                    '.'
                );

        } catch (Exception $e) {

            mysqli_rollback($conn);

            $pesan = $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tarik Tunai</title>
</head>
<body>

<h1>Tarik Tunai</h1>

<?php if ($pesan != ""): ?>

    <p>
        <?= $pesan ?>
    </p>

<?php endif; ?>

<form method="post">

    <label>
        Jumlah Penarikan
    </label>

    <br>

    <input
        type="number"
        name="jumlah"
        min="10000"
        step="10000"
        required
    >

    <br><br>

    <button type="submit" name="tarik">
        TARIK TUNAI
    </button>

</form>

<br>

<a href="index.php">
    Kembali
</a>

</body>
</html>