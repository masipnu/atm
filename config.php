<?php

$host       = "localhost";     // ganti dengan ip komputer server database
$user       = "atm";
$password   = "atm123";
$database   = "atm";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");