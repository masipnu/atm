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
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>ATM - Cek Saldo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/atm.css"
    >

</head>

<body>

<div class="atm-screen">


    <header class="atm-header">

        <div class="atm-brand">

            <i class="bi bi-bank"></i>

            <span>ATM</span>

        </div>


        <div class="atm-account">

            Rekening:
            <strong>
                <?= $_SESSION['rekening'] ?>
            </strong>

        </div>

    </header>


    <main class="atm-content">

        <div class="atm-container atm-page">


            <div class="atm-page-title">

                <h1>
                    <i class="bi bi-wallet2 me-2"></i>
                    CEK SALDO
                </h1>

                <p>
                    Informasi saldo rekening Anda
                </p>

            </div>


            <div class="balance-card">

                <div class="balance-label">
                    Saldo Anda
                </div>


                <div class="balance-value">

                    Rp
                    <?= number_format(
                        $data['saldo'],
                        0,
                        ',',
                        '.'
                    ) ?>

                </div>

            </div>


            <div class="mt-4">

                <a
                    href="index.php"
                    class="btn btn-atm-blue px-5"
                >

                    <i class="bi bi-arrow-left me-2"></i>

                    KEMBALI KE MENU

                </a>

            </div>


        </div>

    </main>


    <footer class="atm-footer">

        ATM LAB RPL

    </footer>


</div>

</body>

</html>