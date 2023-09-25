<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        import sql
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label for="file">import sql</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="Aimportsql.php" method="post" enctype="multipart/form-data">
                        <label for="file">Pilih File SQL:</label>
                        <input type="file" name="file" id="file" accept=".sql"><br>
                        <input type="submit" name="submit" value="Import" class="btn btn-primary">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>


    <input type="file" id="excel_file_input" accept=".xls, .xlsx">
    <button id="import_button">Import</button>
    <div id="message"></div>

    <script>
        document.getElementById('import_button').addEventListener('click', function () {
            var fileInput = document.getElementById('excel_file_input');
            var excelFile = fileInput.files[0];

            if (!excelFile) {
                document.getElementById('message').innerHTML = 'Pilih file Excel terlebih dahulu.';
                return;
            }

            var formData = new FormData();
            formData.append('excel_file', excelFile);

            fetch('http://localhost:8080/test/perpustakaan/admin/modules/bibliography/Aimportexcel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('message').innerHTML = 'Error: ' + data.error;
                    } else {
                        document.getElementById('message').innerHTML = 'Sukses: ' + data.message;
                        fileInput.value = ''; // Bersihkan input file setelah berhasil import
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>