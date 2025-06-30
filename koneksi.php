

<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "fahmi_food"; // Ganti dengan nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
