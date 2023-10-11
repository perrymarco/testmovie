<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require __DIR__ . '/vendor/autoload.php';
require 'connection.php';
require 'MovieController.php';    
$MovieController = new MovieController($pdo);
$movies = $MovieController->getApiMovies();
$json_data = json_encode($movies);
echo $json_data;
?>