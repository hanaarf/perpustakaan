<?php
// slims_api/admin/modules/bibliography/importt.php

// Include library jika Anda menggunakan PhpSpreadsheet
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Fungsi untuk mengimpor data dari file Excel dan menyimpannya ke dalam database
function importAndSaveToDatabase($file_path)
{
    require_once 'config.php'; // Sambungkan ke database (gantilah dengan informasi koneksi yang sesuai)

    try {
        // Load file Excel
        $spreadsheet = IOFactory::load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();

        $conn->begin_transaction(); // Mulai transaksi

        // Loop melalui baris-baris file Excel (mulai dari baris kedua untuk menghindari header)
        for ($row = 2; $row <= $worksheet->getHighestRow(); $row++) {
            // Ambil nilai dari setiap kolom sesuai urutan kolom dalam file Excel
            $gmd_id = $worksheet->getCell('B' . $row)->getValue();
            $title = $worksheet->getCell('C' . $row)->getValue();
            $sor = $worksheet->getCell('D' . $row)->getValue();
            $edition = $worksheet->getCell('E' . $row)->getValue();
            $isbn_issn = $worksheet->getCell('F' . $row)->getValue();
            $publisher_id = $worksheet->getCell('G' . $row)->getValue();
            $publish_year = $worksheet->getCell('H' . $row)->getValue();
            $collation = $worksheet->getCell('I' . $row)->getValue();
            $series_title = $worksheet->getCell('J' . $row)->getValue();
            $call_number = $worksheet->getCell('K' . $row)->getValue();
            $language_id = $worksheet->getCell('L' . $row)->getValue();
            $source = $worksheet->getCell('M' . $row)->getValue();
            $publish_place_id = $worksheet->getCell('N' . $row)->getValue();
            $classification = $worksheet->getCell('O' . $row)->getValue();
            $notes = $worksheet->getCell('P' . $row)->getValue();
            $image = $worksheet->getCell('Q' . $row)->getValue();
            $file_att = $worksheet->getCell('R' . $row)->getValue();
            $opac_hide = $worksheet->getCell('S' . $row)->getValue();
            $promoted = $worksheet->getCell('T' . $row)->getValue();
            $labels = $worksheet->getCell('U' . $row)->getValue();
            $frequency_id = $worksheet->getCell('V' . $row)->getValue();
            $spec_detail_info = $worksheet->getCell('W' . $row)->getValue();
            $content_type_id = $worksheet->getCell('X' . $row)->getValue();
            $media_type_id = $worksheet->getCell('Y' . $row)->getValue();
            $carrier_type_id = $worksheet->getCell('Z' . $row)->getValue();
            $input_date = $worksheet->getCell('AA' . $row)->getValue();
            $last_update = $worksheet->getCell('AB' . $row)->getValue();
            $uid = $worksheet->getCell('AC' . $row)->getValue();

            // Insert data ke tabel biblio
            $sql = "INSERT INTO biblio (gmd_id, title, sor, edition, isbn_issn, publisher_id, publish_year, collation, series_title, call_number, language_id, source, publish_place_id, classification, notes, image, file_att, opac_hide, promoted, labels, frequency_id, spec_detail_info, content_type_id, media_type_id, carrier_type_id, input_date, last_update, uid)
                     VALUES ('$gmd_id', '$title', '$sor', '$edition', '$isbn_issn', '$publisher_id', '$publish_year', '$collation', '$series_title', '$call_number', '$language_id', '$source', '$publish_place_id', '$classification', '$notes', '$image', '$file_att', '$opac_hide', '$promoted', '$labels', '$frequency_id', '$spec_detail_info', '$content_type_id', '$media_type_id', '$carrier_type_id', '$input_date', '$last_update', '$uid')";

            $conn->query($sql);
        }

        $conn->commit(); // Commit transaksi
        $conn->close();

        return array('message' => 'Import berhasil.');
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaksi jika terjadi kesalahan
        $conn->close();
        return array('error' => $e->getMessage());
    }
}

// Endpoint untuk mengunggah file Excel dan mengimpor datanya ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excel_file']['tmp_name'])) {
        $file_path = $_FILES['excel_file']['tmp_name'];
        $import_result = importAndSaveToDatabase($file_path);
        echo json_encode($import_result);
    } else {
        echo json_encode(array('error' => 'File Excel tidak ditemukan.'));
    }
} else {
    echo json_encode(array('error' => 'Metode request tidak valid.'));
}