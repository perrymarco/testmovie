<?php
    require __DIR__ . '/vendor/autoload.php';
    require 'connection.php';
    require 'MovieController.php';    
    $MovieController = new MovieController($pdo);
    $idmovie=$_GET['id']??0;
    $movie = $MovieController->getMovieById($idmovie);
    if(!isset($movie['id'])){die('Film non esistente');}
    $actors=$MovieController->getActorsForMovie($idmovie);
 ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $movie['title'];?></title>
</head>
<body>
    <h1><?php echo $movie['title'];?></h1>    
    <?php     
    echo "<p>";
    echo 'Anno: '.$movie['year'].'<br>';
    echo "</p>";    
    echo "<p>";
    echo nl2br($movie['story']);
    echo "</p>"; 
    
    if (count($actors) > 0) {
        echo "<h3>Attori:</h3>";
        echo "<ul>";
        foreach ($actors as $actor) {
            echo "<li>{$actor['firstname']} {$actor['lastname']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nessun attore associato a questo film.</p>";
    }

    echo "<p><a href=\"movies.php\">Torna ad elenco film</a></p>";
    ?>
</body>
</html>