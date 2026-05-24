<?php

$connectionString = "mysql:host=localhost;port=3307;dbname=baron;charset=utf8mb4;";

$user = "root";
$pass = "";

try {

    $pdo = new PDO($connectionString, $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());

}

?>