<?php

session_start();
require 'config.php';

if (isset($_SESSION['rekening'])) {
    header("Location: index.php");
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {

    $rekening = mysqli_real_escape_string(
        $conn,
        $_POST['rekening']
    );

    $pin = mysqli_real_escape_string(
        $conn,
        $_POST['pin']
    );

    $sql = "
        SELECT nomor_rekening, nama
        FROM accounts
        WHERE nomor_rekening = '$rekening'
        AND pin = '$pin'
        AND status = 'AKTIF'
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $data = mysqli_fetch_assoc($result);

        $_SESSION['rekening'] = $data['nomor_rekening'];
        $_SESSION['nama'] = $data['nama'];

        header("Location: index.php");
        exit;

    } else {

        $pesan = "Nomor rekening atau PIN salah.";

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

    <title>ATM LAB RPL</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <!-- Custom CSS -->
    <link
        rel="stylesheet"
        href="assets/css/atm.css"
    >

</head>

<body>

<div class="atm-screen">

    <main class="atm-content">

        <div class="login-wrapper">

            <div class="login-brand">

                <i class="bi bi-bank"></i>

                <h1>ATM</h1>

                <p>
                    SISTEM SIMULASI TRANSAKSI
                </p>

            </div>


            <div class="login-card">

                <h2>
                    SILAKAN MASUKKAN
                    <br>
                    REKENING DAN PIN ANDA
                </h2>


                <?php if ($pesan != ""): ?>

                    <div class="alert alert-danger atm-alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= $pesan ?>
                    </div>

                <?php endif; ?>


                <form method="post">

                    <div class="text-start mb-4">

                        <label class="form-label">
                            Nomor Rekening
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-person-vcard"></i>
                            </span>

                            <input
                                type="text"
                                name="rekening"
                                class="form-control"
                                placeholder="Masukkan nomor rekening"
                                required
                                autofocus
                            >

                        </div>

                    </div>


                    <div class="text-start mb-4">

                        <label class="form-label">
                            PIN
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                type="password"
                                name="pin"
                                class="form-control"
                                placeholder="Masukkan PIN"
                                required
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        name="login"
                        class="btn btn-atm w-100"
                    >

                        <i class="bi bi-box-arrow-in-right me-2"></i>

                        LOGIN

                    </button>

                </form>

            </div>

        </div>

    </main>


    <footer class="atm-footer">

        <i class="bi bi-shield-lock me-1"></i>

        ATM LAB RPL · Sistem Simulasi Pembelajaran

    </footer>

</div>

</body>
</html>