<?php
// Mengimpor library Simple HTML DOM
include('/home/hana/lampstack-8.1.11-0/apache2/htdocs/test/perpustakaan/simple_html_dom.php');

// Ambil data dari sumber data
$data = file_get_contents('https://library.brin.go.id/oai2.php?verb=ListRecords&metadataPrefix=oai_dc');

// Buat objek HTML dari data yang diambil
$html = str_get_html($data);

// Menyiapkan data yang akan di-export ke SQL
$dataToExport = array();

// Menambahkan data ke dalam array
foreach ($html->find('oai_dc:dc') as $t) {
    $title = addslashes($t->find('dc:title', 0)->innertext);
    $creators = $t->find('dc:creator');
    $subjects = $t->find('dc:subject');
    $publisher = addslashes($t->find('dc:publisher', 0)->innertext);
    $date = addslashes($t->find('dc:date', 0)->innertext);
    $language = addslashes($t->find('dc:language', 0)->innertext);
    $type = addslashes($t->find('dc:type', 0)->innertext);
    $identifiers = $t->find('dc:identifier');
    $description = '';
    if ($t->find('dc:description', 0)) {
        $description = addslashes($t->find('dc:description', 0)->innertext);
    }
    $coverage = '';
    if ($t->find('dc:coverage', 0)) {
        $coverage = addslashes($t->find('dc:coverage', 0)->innertext);
    }
    $format = '';
    if ($t->find('dc:format', 0)) {
        $format = addslashes($t->find('dc:format', 0)->innertext);
    }
    $image = '';
    if ($t->find('image', 0)) {
        $image = addslashes($t->find('image', 0)->innertext);
    }


    
    $creator_values = array();
    foreach ($creators as $creator) {
        $creator_values[] = addslashes($creator->innertext);
    }

    $subject_values = array();
    foreach ($subjects as $subject) {
        $subject_values[] = addslashes($subject->innertext);
    }

    $identifier_values = array();
    foreach ($identifiers as $identifier) {
        $identifier_values[] = addslashes($identifier->innertext);
    }

    $dataToExport[] = "INSERT INTO `biblio`(`title`,`creator`,`identifier`,`publisher`,`date`,`type`,`coverage`,`language`,`subject`,`format`) VALUES ('$title','" . implode(', ', $creator_values) . "', '" . implode(', ', $identifier_values) . "', '$publisher', '$date', '$type', '$coverage','$language','" . implode(', ', $subject_values) . "','$format');";
}

// ... Tambahkan pernyataan SQL lainnya ke $dataToExport sesuai kebutuhan

// Menggabungkan semua pernyataan SQL menjadi satu string
$sqlContent = implode("\n", $dataToExport);

// Menentukan header HTTP untuk menghasilkan file unduhan
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"exported_data.sql\"");

// Keluarkan isi SQL ke respons HTTP
echo $sqlContent;
exit;



// $data = file_get_contents('https://library.brin.go.id/oai2.php?verb=ListRecords&metadataPrefix=oai_dc');

// $html = str_get_html($data);


// $dataToExport = array();

// foreach ($html->find('oai_dc:dc') as $t) {
//     $title = addslashes($t->innertext); 
//     $dataToExport[] = "INSERT INTO `biblio`(`biblio_id`, `gmd_id`, `title`, `sor`, `edition`, `isbn_issn`, `publisher_id`, `publish_year`, `collation`, `series_title`, `call_number`, `language_id`, `source`, `publish_place_id`, `classification`, `notes`, `image`, `file_att`, `opac_hide`, `promoted`, `labels`, `frequency_id`, `spec_detail_info`, `content_type_id`, `media_type_id`, `carrier_type_id`, `input_date`, `last_update`, `uid`) VALUES ('$title');";
// }

// $sqlContent = implode("\n", $dataToExport);

// header('Content-Type: application/octet-stream');
// header("Content-Transfer-Encoding: Binary");
// header("Content-disposition: attachment; filename=\"exported_data.sql\"");

// echo $sqlContent;
// exit;
?>
