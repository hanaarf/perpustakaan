<?php
// Sertakan file konfigurasi koneksi ke database
include('config.php');

// Query SQL untuk mengambil data tahun penerbitan
$query = "SELECT publish_year, COUNT(*) AS total FROM biblio GROUP BY publish_year ORDER BY publish_year";
$result = $conn->query($query);

if (!$result) {
    die("Error dalam eksekusi query: " . $conn->error);
}

// Menginisialisasi array untuk data JSON
$data = array();

// Loop melalui hasil query dan menyimpan data dalam array
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Mengubah array ke format JSON
$json_data = json_encode($data);

// Mengirimkan JSON sebagai respons
header('Content-Type: application/json');
echo $json_data;
?>
