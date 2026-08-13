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
<html>
<head>
    <title>ATM - Login</title>
</head>
<body>

<h1>ATM</h1>

<?php if ($pesan != ""): ?>
    <p><?= $pesan ?></p>
<?php endif; ?>

<form method="post">

    <label>Nomor Rekening</label><br>
    <input type="text" name="rekening" required>

    <br><br>

    <label>PIN</label><br>
    <input type="password" name="pin" required>

    <br><br>

    <button type="submit" name="login">
        LOGIN
    </button>

</form>

</body>
</html>