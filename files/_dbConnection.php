<?php

$mySqlhost = "localhost:3309"; //127.0.0.1
$username = "root";
$password = "";
$myDB = "phpmyadmin";
$charset = "utf8mb4";
$dsn = "mysql:host=$mySqlhost;dbname=$myDB;charset=$charset"; //data source name
try {
    $connect = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<h1 class=\"text-danger\">Connection failed: </h1>" . "<p>" . $e->getMessage() . "</p>";
    //throw new PDOException($e->getMessage());
}