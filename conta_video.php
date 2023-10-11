<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/connection.php';
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
            $conn=$pdo;             
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $movieCountQuery = $conn->prepare("SELECT COUNT(*) FROM movies");
            $movieCountQuery->execute();
            $movieCount = $movieCountQuery->fetchColumn();
            echo 'Il numero dei film è <b>' .  $movieCount . '</b><br>';


            echo '<h2>2) Nella pagina appena creata mostrare in modo random il dettaglio di 2 movie</h2>';

            $randomMoviesQuery = $conn->prepare("SELECT * FROM movies ORDER BY RAND() LIMIT 2");
            $randomMoviesQuery->execute();
            $randomMovies = $randomMoviesQuery->fetchAll(\PDO::FETCH_ASSOC);
            echo '<ul>';
            foreach ($randomMovies as $movie) {
                echo "<li>" . $movie['title'] . "</li>";              
            }
            echo '</ul>';


            echo '<h2>3) Scrivere un algoritmo che stampi i 3 attori con la carriera più lunga. La carriera si misura calcolando gli anni trascorsi tra il primo e l\'ultimo film di un attore.</h2>';


            $query = "SELECT actors.id, actors.lastname, actors.firstname,
            (SELECT MIN(year) FROM movies WHERE id IN (SELECT movie_id FROM movie_actor WHERE actor_id = actors.id)) AS moviefirstyear, 
            (SELECT MAX(year) FROM movies WHERE id IN (SELECT movie_id FROM movie_actor WHERE actor_id = actors.id)) AS movielastyear
            FROM actors
            ORDER BY (movielastyear - moviefirstyear) DESC
            LIMIT 3";

            $result = $conn->query($query);
            $actors = $result->fetchAll(\PDO::FETCH_ASSOC);

            echo '<ul>';
            foreach ($actors as $actor) {
                $actorname = $actor['lastname'].' '. $actor['firstname'];
                $countyears = $actor['movielastyear'] - $actor['moviefirstyear'];
                echo "<li>Attore: ".$actorname.", Carriera: ".$countyears." anni</li>";                         
            }
            echo '</ul>';


            
            echo '<h2>7) Implementare uno script che cancella i film più vecchi di 5 anni.</h2>';
            $year = date("Y");
            $query = "DELETE FROM movies WHERE year < :oldyear";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":oldyear", $year - 5, PDO::PARAM_INT);           
            $stmt->execute();
            echo "Film più vecchi di 5 anni eliminati con successo.<br>";

        
        
        ?>

        <script src="assets/js/app.js"></script>
    </body>
</html>