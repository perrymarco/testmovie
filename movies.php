<?php
    require __DIR__ . '/vendor/autoload.php';
    require 'connection.php';
    require 'MovieController.php';    
    $MovieController = new MovieController($pdo);
    $movies = $MovieController->getAllMovies();
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista dei Film</title>
</head>
<body>
    <h1>Lista dei Film</h1>    
    <?php 
    if (count($movies) > 0) {
        echo "<ul>";
        foreach ($movies as $movie) {
            echo "<li><a href='movie.php?id={$movie['id']}'>" . $movie['title'] . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Nessun film presente nel database.";
    }
    ?>
</body>
</html>