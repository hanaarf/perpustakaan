<?php
$servername = "localhost";
$username = "perpustakaan";
$password = "b6562exj";
$database = "perpustakaan";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>