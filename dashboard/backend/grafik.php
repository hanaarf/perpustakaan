<?php
// Sertakan file konfigurasi koneksi ke database
include('config.php');


// Query SQL untuk mengambil data tahun penerbitan
$query_publish_year = "SELECT publish_year, COUNT(*) AS total FROM biblio GROUP BY publish_year ORDER BY publish_year";
$result_publish_year = $conn->query($query_publish_year);

if (!$result_publish_year) {
    die("Error dalam eksekusi query tahun penerbitan: " . $conn->error);
}

// Menginisialisasi array untuk data JSON tahun penerbitan
$data_publish_year = array();

// Loop melalui hasil query tahun penerbitan dan menyimpan data dalam array
while ($row_publish_year = $result_publish_year->fetch_assoc()) {
    $data_publish_year[] = $row_publish_year;
}

// Query SQL untuk mengambil data kolom "biblio_id," "title," dan "collation"
$query_details = "SELECT biblio_id, title, collation, language_id, publish_year FROM biblio ORDER BY publish_year DESC";
$result_details = $conn->query($query_details);

if (!$result_details) {
    die("Error dalam eksekusi query detail: " . $conn->error);
}

// Menginisialisasi array untuk data JSON detail
$data_details = array();

// Loop melalui hasil query detail dan menyimpan data dalam array
while ($row_details = $result_details->fetch_assoc()) {
    $data_details[] = $row_details;
}

// Buat objek JSON dengan dua properti: "publish_year" dan "details"
$json_data = array(
    "publish_year" => $data_publish_year,
    "details" => $data_details
);

// Mengubah array ke format JSON
$json_output = json_encode($json_data);

// Mengirimkan JSON sebagai respons
header('Content-Type: application/json');
echo $json_output;
?>
