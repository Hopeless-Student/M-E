<?php
$host = 'auth-db2046.hstgr.io';
$user = 'm_e_system';
$password = '2@ElJX1+Pti$';
$dbname = 'm_e';
$charset = 'utf8mb4';
date_default_timezone_set('Asia/Manila');
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {

     $pdo = new PDO($dsn, $user, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      die("Database connection error: ". $e->getMessage());
    }


 ?>
