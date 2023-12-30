<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-file-input.selected:lang(en)::after {
            content: "" !important;
        }

        .custom-file {
            overflow: hidden;
        }

        .custom-file-input {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileInput" name="file" required>
                    <label class="custom-file-label" for="customFileInput">Select File:</label>
                </div>
                <div class="input-group-append">
                    <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
include "config.php";

if (isset($_POST['submit'])) {
  
    echo "File Name: " . $_FILES['file']['name'] . "<br>";
    echo "File Type: " . $_FILES['file']['type'] . "<br>";
    echo "File Size: " . $_FILES['file']['size'] . "<br>";
    echo "File Error: " . $_FILES['file']['error'] . "<br>";

    $fileMimes = array(
        'text/csv',
        'application/csv',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain'
    );

  
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {
      
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        fgetcsv($csvFile, 0, ",");

       
       while (($getData = fgetcsv($csvFile, 488881, ",")) !== FALSE) {

    $ClientProductCode = $getData[0];
    $ManufacturerCode = $getData[1];
    $making = $getData[2];
    $Description = $getData[3];
    $BuyPrice = $getData[4];
    $SellPrice = $getData[5];
    $FET = $getData[6];
    $Stock = $getData[7];

    mysqli_query($conn, "INSERT INTO `products`(`ClientProductCode`, `ManufacturerCode`, `Make`, `Description`, `BuyPrice`, `SellPrice`, `FET`, `Stock`) VALUES ('$ClientProductCode','$ManufacturerCode','$making','$Description','$BuyPrice','$SellPrice','$FET','$Stock')");
}

        fclose($csvFile);

      
        $insertedRows = mysqli_affected_rows($con);

        if ($insertedRows > 0) {
            echo "Data successfully inserted into the database!";
        } else {
            echo "No data inserted or an error occurred.";
        }

        exit(); 
    } else {
        echo "Please select a valid file";
    }
}
?>

