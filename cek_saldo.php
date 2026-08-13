<?php

session_start();
require 'config.php';

if (!isset($_SESSION['rekening'])) {
    header("Location: login.php");
    exit;
}

$rekening = $_SESSION['rekening'];

$sql = "
    SELECT saldo
    FROM accounts
    WHERE nomor_rekening = '$rekening'
";

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cek Saldo</title>
</head>
<body>

<h1>Cek Saldo</h1>

<p>
    Rekening:
    <?= $rekening ?>
</p>

<h2>
    Rp <?= number_format($data['saldo'], 0, ',', '.') ?>
</h2>

<a href="index.php">
    Kembali
</a>

</body>
</html>