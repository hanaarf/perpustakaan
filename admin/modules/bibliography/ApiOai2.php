
<?php
include('/home/hana/lampstack-8.1.11-0/apache2/htdocs/test/perpustakaan/simple_html_dom.php'); // Pastikan file simple_html_dom.php sudah ada dalam direktori yang sama atau sesuaikan path-nya.
$url = 'https://library.brin.go.id/oai2.php?verb=ListRecords&metadataPrefix=oai_dc';
$html = file_get_html($url);

$dataToExport = array();

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

    $dataToExport[] = "INSERT INTO `biblio`(`biblio_id`) VALUES ('$title','" . implode(', ', $creator_values) . "', '" . implode(', ', $identifier_values) . "', '$publisher', '$date', '$type', '$coverage','$language','" . implode(', ', $subject_values) . "','$format');";
}

// ... Tambahkan pernyataan SQL lainnya ke $dataToExport sesuai kebutuhan

echo "<pre>";

print_r($dataToExport);



// include('/home/hana/lampstack-8.1.11-0/apache2/htdocs/test/perpustakaan/simple_html_dom.php');

// $html = file_get_html('https://library.brin.go.id/oai2.php?verb=ListRecords&metadataPrefix=oai_dc');

// $data = array();

// $table = $html->find('.dcdata', 0);

// if ($table) {
//     foreach ($table->find('tr') as $row) {
//         $key = $row->find('.key', 0)->plaintext;
//         $value = $row->find('.value', 0)->plaintext;

//         $data[$key] = $value;
//     }

//     echo "<pre>";
//     print_r($data);
// } else {
//     echo "Tabel tidak ditemukan.";
// }
?>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="import" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
</head>
<body>
    <table class="table-primary table">
        <tr class="table-primary">
            <td class="table-primary">title</td>
            <td class="table-primary">author</td>
        </tr>
        <tr class="table-primary">
            <td class="table-primary">
               
            </td>
            <td class="table-primary text-primary">
               
            </td>
        </tr>
    </table>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</html> -->

