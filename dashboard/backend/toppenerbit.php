<?php
// Sisipkan file konfigurasi
include('config.php');

// Eksekusi query
$sql = "SELECT mp.publisher_name AS Name, COUNT(*) AS Jumlah
        FROM biblio b
        INNER JOIN mst_publisher mp ON b.publisher_id = mp.publisher_id
        GROUP BY mp.publisher_name
        ORDER BY Jumlah DESC
        LIMIT 10";

$result = $conn->query($sql);

// Buat array untuk menyimpan hasil
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array("Name" => $row["Name"], "Jumlah" => $row["Jumlah"]);
    }
}

// Tutup koneksi ke basis data
$conn->close();

// Mengirimkan data sebagai respons JSON
header("Content-Type: application/json");
echo json_encode($data);
?>
