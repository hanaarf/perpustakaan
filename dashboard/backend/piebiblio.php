<?php
// Include file config.php yang berisi koneksi database
include('config.php');

// Query untuk mengambil data dari tabel "biblio"
$sql = "SELECT title, publish_year, publisher_id, COUNT(*) AS count FROM biblio GROUP BY title, publish_year, publisher_id";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Tutup koneksi database
$conn->close();

// Format data sebagai JSON dan mengirimkan data JSON ke frontend
header('Content-Type: application/json');
echo json_encode($data);

// // Include file config.php yang berisi koneksi database
// include('config.php');

// // Query untuk mengambil data dari tabel "biblio"
// $sql = "SELECT publisher_id, COUNT(*) AS count FROM biblio GROUP BY publisher_id";
// $result = $conn->query($sql);

// $data = [];
// $total = 0;

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//         $total += $row["count"];
//     }
// }

// // Format data sebagai JSON
// $data_json = json_encode($data);

// // Tutup koneksi database
// $conn->close();

// // Mengirimkan data JSON ke frontend
// echo $data_json;
?>
