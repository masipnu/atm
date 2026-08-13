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

            if ($saldo_sebelum < $jumlah) {

                throw new Exception(
                    "Saldo tidak mencukupi."
                );

            }

            $saldo_sesudah =
                $saldo_sebelum - $jumlah;

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
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>ATM - Tarik Tunai</title>

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

                    <i class="bi bi-cash-stack me-2"></i>

                    TARIK TUNAI

                </h1>

                <p>
                    Masukkan jumlah penarikan
                </p>

            </div>


            <?php if ($pesan != ""): ?>

                <div
                    class="alert
                           <?= str_contains(
                               $pesan,
                               'berhasil'
                           )
                               ? 'alert-success'
                               : 'alert-danger'
                           ?>
                           atm-alert
                           mx-auto
                           mb-4"
                    style="max-width:700px;"
                >

                    <i class="bi
                        <?= str_contains(
                            $pesan,
                            'berhasil'
                        )
                            ? 'bi-check-circle'
                            : 'bi-exclamation-circle'
                        ?>
                        me-2">
                    </i>

                    <?= $pesan ?>

                </div>

            <?php endif; ?>


            <div class="withdraw-card">


                <form method="post">


                    <div class="input-group mb-4">

                        <span
                            class="input-group-text
                                   fs-4
                                   fw-bold"
                        >
                            Rp
                        </span>

                        <input
                            type="number"
                            name="jumlah"
                            id="jumlah"
                            class="form-control withdraw-input"
                            placeholder="0"
                            min="10000"
                            step="10000"
                            required
                        >

                    </div>


                    <div class="row g-3 mb-4">


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(50000)"
                            >
                                Rp 50.000
                            </button>

                        </div>


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(100000)"
                            >
                                Rp 100.000
                            </button>

                        </div>


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(200000)"
                            >
                                Rp 200.000
                            </button>

                        </div>


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(300000)"
                            >
                                Rp 300.000
                            </button>

                        </div>


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(500000)"
                            >
                                Rp 500.000
                            </button>

                        </div>


                        <div class="col-6 col-md-4">

                            <button
                                type="button"
                                class="btn amount-btn w-100"
                                onclick="setAmount(1000000)"
                            >
                                Rp 1.000.000
                            </button>

                        </div>


                    </div>


                    <button
                        type="submit"
                        name="tarik"
                        class="btn btn-atm w-100"
                    >

                        <i class="bi bi-cash-coin me-2"></i>

                        PROSES TARIK TUNAI

                    </button>


                </form>


                <div class="mt-3">

                    <a
                        href="index.php"
                        class="btn btn-back w-100"
                    >

                        <i class="bi bi-arrow-left"></i>

                        KEMBALI KE MENU

                    </a>

                </div>


            </div>


        </div>

    </main>


    <footer class="atm-footer">

        ATM LAB RPL

    </footer>


</div>


<script>

function setAmount(amount) {

    document.getElementById('jumlah').value = amount;

}

</script>

</body>

</html>