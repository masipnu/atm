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
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>ATM - Riwayat Transaksi</title>

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

                    <i class="bi bi-receipt me-2"></i>

                    RIWAYAT TRANSAKSI

                </h1>

                <p>
                    Daftar transaksi rekening Anda
                </p>

            </div>


            <div class="transaction-card">


                <div class="table-responsive">

                    <table
                        class="table
                               transaction-table
                               text-nowrap"
                    >

                        <thead>

                            <tr>

                                <th>Waktu</th>

                                <th>Jenis</th>

                                <th>Jumlah</th>

                                <th>Saldo Sebelum</th>

                                <th>Saldo Sesudah</th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php while (
                            $data =
                            mysqli_fetch_assoc($result)
                        ): ?>

                            <tr>

                                <td>
                                    <?= $data['waktu'] ?>
                                </td>


                                <td>

                                    <span class="badge-tarik">

                                        <?= $data['jenis'] ?>

                                    </span>

                                </td>


                                <td>

                                    Rp
                                    <?= number_format(
                                        $data['jumlah'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <td>

                                    Rp
                                    <?= number_format(
                                        $data['saldo_sebelum'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <td>

                                    Rp
                                    <?= number_format(
                                        $data['saldo_sesudah'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

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