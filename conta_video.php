<?php
require __DIR__ . '/vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>HTML 5 Boilerplate</title>
        <link rel="stylesheet" href="assets/css/app.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    </head>
    <body>
    
            <h2>1) Conta Video</h2>
            <?php
            $servername = "localhost";//db on docker
            $servername = "db";
            $username = "movies";
            $password = "movies";
            $db = "movies";
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $movieCountQuery = $conn->prepare("SELECT COUNT(*) FROM movies");
            $movieCountQuery->execute();
            $movieCount = $movieCountQuery->fetchColumn();
            echo 'Il numero dei film è <b>' .  $movieCount . '</b><br>';

        
        
        ?>

        <script src="assets/js/app.js"></script>
    </body>
</html>