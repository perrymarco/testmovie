<?php
include 'MovieController.php';

$servername = "localhost";//db on docker
$servername = "db";
$username = "movies";
$password = "movies";
$db = "movies";

$pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$movieController = new MovieController($pdo);
$movieController->createMovie("Titolo del Film ".rand(10,100), rand(1990,2023), "Storia del film");
$allmovies = $movieController->getAllMovies();

echo '<pre>';
print_r($allmovies);
echo '</pre>';

$idtest=array_reverse($allmovies)[0]['id'];
$movieController->updateMovie($idtest,"Titolo del Film Aggiornato ".rand(10,100), rand(1990,2023), "Storia aggiornata");
$movie = $movieController->getMovieById($idtest);

echo '<pre>';
print_r($movie);
echo '</pre>';

$movieController->deleteMovie($idtest);
$allmovies = $movieController->getAllMovies();

echo '<pre>';
print_r($allmovies);
echo '</pre>';


