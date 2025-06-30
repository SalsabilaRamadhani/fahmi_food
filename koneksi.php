<?php
$host     = 'localhost';     // atau 127.0.0.1
$user     = 'root';          // sesuaikan dengan user database kamu
$password = '';              // default XAMPP biasanya kosong
$database = 'fahmi_food';    // nama database dari SQL yang sebelumnya

$koneksi = mysqli_connect($host, $user, $password, $database);

// cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
