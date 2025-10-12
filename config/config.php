<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'm&e';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {

     $pdo = new PDO($dsn, $user, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      die("Database connection error: ". $e->getMessage());
    }


 ?>
