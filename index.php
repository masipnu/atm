<?php

session_start();

if (!isset($_SESSION['rekening'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>ATM</title>
</head>
<body>

<h1>ATM</h1>

<p>
    Selamat datang,
    <strong><?= $_SESSION['nama'] ?></strong>
</p>

<p>
    Rekening:
    <?= $_SESSION['rekening'] ?>
</p>

<hr>

<h2>Menu</h2>

<ul>
    <li>
        <a href="cek_saldo.php">
            Cek Saldo
        </a>
    </li>

    <li>
        <a href="tarik.php">
            Tarik Tunai
        </a>
    </li>

    <li>
        <a href="transaksi.php">
            Riwayat Transaksi
        </a>
    </li>

    <li>
        <a href="logout.php">
            Logout
        </a>
    </li>
</ul>

</body>
</html>