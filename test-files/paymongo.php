<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
function createPaymentLink($amount, $description, $remarks) {
  $secretKey = $_ENV['PAYMONGO_SECRET_KEY'];

  $data = [
    "data" => [
      "attributes" => [
        "amount" => $amount * 100, // PayMongo uses centavos
        "description" => $description,
        "remarks" => $remarks
      ]
    ]
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($secretKey . ":"),
    "Content-Type: application/json"
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  $response = curl_exec($ch);
  curl_close($ch);

  return json_decode($response, true);
}

 ?>
