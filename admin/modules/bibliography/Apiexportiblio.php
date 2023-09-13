<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excelperpus.xls"); 

?>

<?php
// Konfigurasi koneksi database
$host = "localhost";
$username = "perpustakaan";
$password = "b6562exj";
$database = "perpustakaan";

// Membuat koneksi ke database menggunakan MySQLi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query SQL untuk mengambil data
$sql = "SELECT * FROM biblio";
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
// if ($result->num_rows > 0) {
//     echo "<table border='1'>";
//     echo "<tr><th>biblio_id</th><th>gmd_id</th><th>tittle</th><th>sor</th><th>edition</th><th>isbn_issn</th><th>publisher_id</th><th>publish_year</th><th>collation</th><th>series_tittle</th><th>call_number</th><th>language_id</th><th>source</th><th>publish_place_id</th><th>clasification</th><th>notes</th><th>image</th><th>file_att</th><th>opac_hide</th><th>promoted</th><th>labels</th><th>frequency_id</th><th>spec_detail_info</th><th>content_id</th><th>media_id</th><th>carrier_id</th><th>input_date</th><th>last_update</th><th>uid</th></tr>";
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>";
//         echo "<td>" . $row["biblio_id"] . "</td>";
//         echo "<td>" . $row["gmd_id"] . "</td>";
//         echo "<td>" . $row["title"] . "</td>";
//         echo "<td>" . $row["sor"] . "</td>";
//         echo "<td>" . $row["edition"] . "</td>";
//         echo "<td>" . $row["isbn_issn"] . "</td>";
//         echo "<td>" . $row["publisher_id"] . "</td>";
//         echo "<td>" . $row["publish_year"] . "</td>";
//         echo "<td>" . $row["collation"] . "</td>";
//         echo "<td>" . $row["series_title"] . "</td>";
//         echo "<td>" . $row["call_number"] . "</td>";
//         echo "<td>" . $row["language_id"] . "</td>";
//         echo "<td>" . $row["source"] . "</td>";
//         echo "<td>" . $row["publish_place_id"] . "</td>";
//         echo "<td>" . $row["classification"] . "</td>";
//         echo "<td>" . $row["notes"] . "</td>";
//         echo "<td>" . $row["image"] . "</td>";
//         echo "<td>" . $row["file_att"] . "</td>";
//         echo "<td>" . $row["opac_hide"] . "</td>";
//         echo "<td>" . $row["promoted"] . "</td>";
//         echo "<td>" . $row["labels"] . "</td>";
//         echo "<td>" . $row["frequency_id"] . "</td>";
//         echo "<td>" . $row["spec_detail_info"] . "</td>";
//         echo "<td>" . $row["content_type_id"] . "</td>";
//         echo "<td>" . $row["media_type_id"] . "</td>";
//         echo "<td>" . $row["carrier_type_id"] . "</td>";
//         echo "<td>" . $row["input_date"] . "</td>";
//         echo "<td>" . $row["last_update"] . "</td>";
//         echo "<td>" . $row["uid"] . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";
// } else {
//     echo "Tidak ada data yang ditemukan.";
// }


if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Mengirimkan data dalam format JSON sebagai respons API
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "Tidak ada data yang ditemukan.";
}

// Menutup koneksi database
$conn->close();
?>

