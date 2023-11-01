<?php

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function importAndSaveToDatabasee($file_path)
{
    require_once 'config.php';

    try {

        $spreadsheet = IOFactory::load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();

        $conn->begin_transaction();

        for ($row = 2; $row <= $worksheet->getHighestRow(); $row++) {
            // Ambil data dari setiap kolom sesuai dengan urutan kolom dalam file CSV
            $gmd_id = $worksheet->getCell('A' . $row)->getValue();
            $title = $worksheet->getCell('B' . $row)->getValue();
            $sor = $worksheet->getCell('C' . $row)->getValue();
            $edition = $worksheet->getCell('D' . $row)->getValue();
            $isbn_issn = $worksheet->getCell('E' . $row)->getValue();
            $publisher_id = $worksheet->getCell('F' . $row)->getValue();
            $publish_year = $worksheet->getCell('G' . $row)->getValue();
            $collation = $worksheet->getCell('H' . $row)->getValue();
            $series_title = $worksheet->getCell('I' . $row)->getValue();
            $call_number = $worksheet->getCell('J' . $row)->getValue();
            $language_id = $worksheet->getCell('K' . $row)->getValue();
            $source = $worksheet->getCell('L' . $row)->getValue();
            $publish_place_id = $worksheet->getCell('M' . $row)->getValue();
            $classification = $worksheet->getCell('N' . $row)->getValue();
            $notes = $worksheet->getCell('O' . $row)->getValue();
            $image = $worksheet->getCell('P' . $row)->getValue();
            $file_att = $worksheet->getCell('Q' . $row)->getValue();
            $opac_hide = $worksheet->getCell('R' . $row)->getValue();
            $promoted = $worksheet->getCell('S' . $row)->getValue();
            $labels = $worksheet->getCell('T' . $row)->getValue();
            $frequency_id = $worksheet->getCell('U' . $row)->getValue();
            $spec_detail_info = $worksheet->getCell('V' . $row)->getValue();
            $content_type_id = $worksheet->getCell('W' . $row)->getValue();
            $media_type_id = $worksheet->getCell('X' . $row)->getValue();
            $carrier_type_id = $worksheet->getCell('Y' . $row)->getValue();
            $input_date = $worksheet->getCell('Z' . $row)->getValue();
            $last_update = $worksheet->getCell('AA' . $row)->getValue();
            $uid = $worksheet->getCell('AB' . $row)->getValue();
            // $keterangan = $worksheet->getCell('AC' . $row)->getValue();

            // Masukkan data ke tabel "biblio"
            $sql = "INSERT INTO biblio (gmd_id, title, sor, edition, isbn_issn, publisher_id, publish_year, collation, series_title, call_number, language_id, source, publish_place_id, classification, notes, image, file_att, opac_hide, promoted, labels, frequency_id, spec_detail_info, content_type_id, media_type_id, carrier_type_id, input_date, last_update, uid) VALUES ( '$gmd_id', '$title', '$sor', '$edition', '$isbn_issn', '$publisher_id', '$publish_year', '$collation', '$series_title', '$call_number', '$language_id', '$source', '$publish_place_id', '$classification', '$notes', '$image', '$file_att', '$opac_hide', '$promoted', '$labels', '$frequency_id', '$spec_detail_info', '$content_type_id', '$media_type_id', '$carrier_type_id', '$input_date', '$last_update', '$uid')";

            $conn->query($sql);
            
    }

    $conn->commit();
    $conn->close();
    return array('message' => 'Import berhasil.');
}catch (Exception $e) {
    $conn->rollback(); // Rollback transaksi jika terjadi kesalahan
    $conn->close();
    return array('error' => $e->getMessage());
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csv_file']['tmp_name'])) {
        $file_path = $_FILES['csv_file']['tmp_name'];
        $import_result = importAndSaveToDatabasee($file_path);
        echo json_encode($import_result);
    } else {
        echo json_encode(array('error' => 'File Csv tidak ditemukan.'));
    }
} else {
    echo json_encode(array('error' => 'Metode request tidak valid.'));
}