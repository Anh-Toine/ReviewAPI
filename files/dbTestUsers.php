<?php
include "_dbConnection.php" ;

$querytest = "SELECT * FROM phpmyadmin.users_tbl";
$stmttest = $connect->prepare($querytest);
$stmttest->execute();
$stmttest->setFetchMode(PDO::FETCH_ASSOC);
$content = $stmttest->fetchAll(PDO::FETCH_ASSOC);
print_r($content);