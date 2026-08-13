<?php

session_start();

if (!isset($_SESSION['rekening'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>ATM - Menu Utama</title>

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


    <!-- HEADER -->

    <header class="atm-header">

        <div class="atm-brand">

            <i class="bi bi-bank"></i>

            <span>ATM</span>

        </div>


        <div class="d-flex align-items-center gap-3">

            <div class="atm-account">

                Rekening:
                <strong>
                    <?= $_SESSION['rekening'] ?>
                </strong>

            </div>

            <a
                href="logout.php"
                class="btn btn-outline-light btn-sm"
            >
                <i class="bi bi-power me-1"></i>
                Logout
            </a>

        </div>

    </header>


    <!-- CONTENT -->

    <main class="atm-content">

        <div class="atm-container">


            <div class="welcome-text">

                <div class="small-title">
                    SELAMAT DATANG
                </div>

                <h1>
                    <?= $_SESSION['nama'] ?>
                </h1>

                <p>
                    Silakan pilih transaksi yang ingin Anda lakukan.
                </p>

            </div>


            <div class="row g-4 justify-content-center">


                <!-- CEK SALDO -->

                <div class="col-12 col-sm-6 col-lg-4">

                    <a
                        href="cek_saldo.php"
                        class="atm-menu-card"
                    >

                        <i class="bi bi-wallet2"></i>

                        <span>
                            CEK SALDO
                        </span>

                    </a>

                </div>


                <!-- TARIK TUNAI -->

                <div class="col-12 col-sm-6 col-lg-4">

                    <a
                        href="tarik.php"
                        class="atm-menu-card"
                    >

                        <i class="bi bi-cash-stack"></i>

                        <span>
                            TARIK TUNAI
                        </span>

                    </a>

                </div>


                <!-- RIWAYAT -->

                <div class="col-12 col-sm-6 col-lg-4">

                    <a
                        href="transaksi.php"
                        class="atm-menu-card"
                    >

                        <i class="bi bi-receipt"></i>

                        <span>
                            RIWAYAT TRANSAKSI
                        </span>

                    </a>

                </div>


            </div>

        </div>

    </main>


    <footer class="atm-footer">

        <i class="bi bi-shield-check me-1"></i>

        ATM LAB RPL · Sistem Simulasi Pembelajaran

    </footer>


</div>

</body>

</html>