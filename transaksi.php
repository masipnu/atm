<?php

session_start();
require 'config.php';

if (!isset($_SESSION['rekening'])) {
    header("Location: login.php");
    exit;
}

$rekening = $_SESSION['rekening'];

$sql = "
    SELECT
        jenis,
        jumlah,
        saldo_sebelum,
        saldo_sesudah,
        waktu
    FROM transactions
    WHERE nomor_rekening = '$rekening'
    ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
</head>
<body>

<h1>Riwayat Transaksi</h1>

<table border="1" cellpadding="8">

<tr>
    <th>Waktu</th>
    <th>Jenis</th>
    <th>Jumlah</th>
    <th>Saldo Sebelum</th>
    <th>Saldo Sesudah</th>
</tr>

<?php while ($data = mysqli_fetch_assoc($result)): ?>

<tr>

    <td>
        <?= $data['waktu'] ?>
    </td>

    <td>
        <?= $data['jenis'] ?>
    </td>

    <td>
        Rp <?= number_format(
            $data['jumlah'],
            0,
            ',',
            '.'
        ) ?>
    </td>

    <td>
        Rp <?= number_format(
            $data['saldo_sebelum'],
            0,
            ',',
            '.'
        ) ?>
    </td>

    <td>
        Rp <?= number_format(
            $data['saldo_sesudah'],
            0,
            ',',
            '.'
        ) ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

<br>

<a href="index.php">
    Kembali
</a>

</body>
</html>