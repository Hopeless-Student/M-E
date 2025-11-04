<?php
  function connect(){
    $db_server = "auth-db2046.hstgr.io";
    $db_name = "m_e";
    $db_user = "m_e_system";
    $db_pass = "2@ElJX1+Pti$";
    date_default_timezone_set('Asia/Manila');
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
