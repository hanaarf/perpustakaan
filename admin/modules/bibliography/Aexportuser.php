<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_sql'])) {
    // Include file koneksi database
    include 'config.php';

    // Membuat query SQL untuk mengambil data dari tabel biblio
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    // Mengecek apakah query berhasil dijalankan
    if ($result->num_rows > 0) {
        $output = '';

        // Mendapatkan nama file untuk ekspor
        $filename = 'data_user.sql';

        // Menuliskan data ke dalam file SQL
        while ($row = $result->fetch_assoc()) {
            $output .= "INSERT INTO user (user_id, username, realname, passwd, 2fa, email, user_type, user_image, social_media, last_login, last_login_ip, groups, admin_template, forgot) VALUES ('" . $row['user_id'] . "', '" . $row['username'] . "', '" . $row['realname'] . "','" . $row['passwd'] . "','" . $row['2fa'] . "','" . $row['email'] . "','" . $row['user_type'] . "','" . $row['user_image'] . "','" . $row['social_media'] . "','" . $row['last_login'] . "','" . $row['last_login_ip'] . "','" . $row['groups'] . "','" . $row['admin_template'] . "','" . $row['forgot'] . "');\n";
        }

        // Mengatur header untuk mengunduh file SQL
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Menampilkan data ke browser
        echo $output;
    } else {
        $response = array('success' => false, 'message' => 'Tidak ada data yang ditemukan');
    }

    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'Metode yang digunakan tidak diizinkan');
}

// Mengirim respons JSON
header('Content-Type: application/json');
echo json_encode($response);
?>