<?php
// Menggunakan informasi koneksi dari config.php
include('config.php');

// Fungsi untuk mengimpor file SQL ke database
function importSQL($sqlFile) {
    global $conn; // Menggunakan variabel koneksi dari config.php

    // Membaca isi file SQL
    $sql = file_get_contents($sqlFile);

    // Memecah perintah SQL menjadi pernyataan terpisah
    $sqlStatements = explode(';', $sql);

    // Menjalankan pernyataan SQL satu per satu
    foreach ($sqlStatements as $sqlStatement) {
        if (!empty(trim($sqlStatement))) {
            $result = $conn->query($sqlStatement);
            if (!$result) {
                echo "Gagal menjalankan pernyataan SQL: " . $conn->error;
                return false;
            }
        }
    }

    return true;
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["file"])) {
        $sqlFileTmp = $_FILES["file"]["tmp_name"];

        if (importSQL($sqlFileTmp)) {
            // Mengarahkan kembali ke halaman awal
            header("Location: http://localhost:8080/test/perpustakaan/dashboard");
            exit(); // Pastikan kode berhenti di sini untuk menghindari output yang tidak diinginkan
        } else {
            $response["success"] = false;
            $response["message"] = "Gagal mengimpor file SQL.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "File SQL tidak ditemukan dalam permintaan.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Permintaan tidak valid.";
}

// Mengirim respons dalam format JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
