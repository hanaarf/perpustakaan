<?php

// Fungsi untuk mengimpor file SQL ke database
function importSQL($sqlFile) {
    // Gantilah informasi koneksi sesuai dengan database Anda
    $servername = "localhost";
    $username = "perpustakaan";
    $password = "b6562exj";
    $dbname = "perpustakaan";

    // Membaca isi file SQL
    $sql = file_get_contents($sqlFile);

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Mengecek koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

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

    // Menutup koneksi
    $conn->close();

    return true;
}

// Tanggapi permintaan JSON
// $response = array();

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     if (isset($_FILES["file"])) {
//         $sqlFileTmp = $_FILES["file"]["tmp_name"];

//         if (importSQL($sqlFileTmp)) {
//             $response["success"] = true;
//             $response["message"] = "Impor SQL berhasil.";
//         } else {
//             $response["success"] = false;
//             $response["message"] = "Gagal mengimpor file SQL.";
//         }
//     } else {
//         $response["success"] = false;
//         $response["message"] = "File SQL tidak ditemukan dalam permintaan.";
//     }
// } else {
//     $response["success"] = false;
//     $response["message"] = "Permintaan tidak valid.";
// }

// // Mengirim respons dalam format JSON
// header("Content-Type: application/json");
// echo json_encode($response);

// Tanggapi permintaan JSON
$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["file"])) {
        $sqlFileTmp = $_FILES["file"]["tmp_name"];

        if (importSQL($sqlFileTmp)) {
            // Mengarahkan kembali ke halaman awal
            header("Location: http://localhost:8080/test/perpustakaan/admin/index.php?mod=bibliography");
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
