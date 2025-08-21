<?php
  function connect(){
    $db_server = "localhost";
    $db_name = "practicedb";
    $db_user = "root";
    $db_pass = "";

      try {
        $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // execption handler
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // pang assoc return format key => value typeshi
          PDO::ATTR_EMULATE_PREPARES => false,
        ];
          $pdo = new PDO($dsn, $db_user, $db_pass, $options);
          return $pdo;
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
      }

  }
 ?>
