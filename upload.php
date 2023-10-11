<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excel_file"])) {
    require 'vendor/autoload.php'; 
    require 'connection.php';
    require 'MovieController.php';  
    $uploadedFile = $_FILES["excel_file"]["tmp_name"];
    $extension = pathinfo($_FILES["excel_file"]["name"], PATHINFO_EXTENSION);
    $currentTime = time();
    $xlsFilename = "xls/{$currentTime}.". $extension; 
    if (move_uploaded_file($uploadedFile, $xlsFilename)) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($xlsFilename);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            $title = $data[0];
            $year = $data[1];
            $story = $data[2];
        $movieController->createMovie($title, $year, $story);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload File Excel</title>
</head>
<body>
    <h1>Carica un file Excel</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Seleziona un file Excel:
        <input type="file" name="excel_file" accept=".xls,.xlsx">
        <input type="submit" value="Carica">
    </form>
</body>
</html>