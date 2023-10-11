<?php 
$servername = "localhost";//db on docker
$servername = "db";
$username = "movies";
$password = "movies";
$db = "movies";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}