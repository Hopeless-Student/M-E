<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
echo '<pre>';
var_dump(class_exists('Dotenv\Dotenv'));  // Should print true if Dotenv is loaded
echo '</pre>';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo getenv('APP_NAME');  // Or any environment variable defined in your .env file

 ?>
