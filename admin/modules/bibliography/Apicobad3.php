<?php
// Hubungkan ke database
$mysqli = new mysqli("localhost", "perpustakaan", "b6562exj", "perpustakaan");

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

// Query untuk mengambil data dari database
$query = "SELECT * FROM biblio";
$result = $mysqli->query($query);

// Ubah hasil query ke dalam format yang sesuai (misalnya, JSON)
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'image' => $row['image'],
        'title' => $row['title']
    );
}

// Tutup koneksi ke database
$mysqli->close();

// Keluarkan data dalam format JSON
echo json_encode($data);
?>
