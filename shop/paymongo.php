<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
function createPaymentLink($amount, $description, $remarks, $orderId = null, $orderNumber = null, $redirectUrl = null) {
  $secretKey = $_ENV['PAYMONGO_SECRET_KEY'];

  $data = [
    "data" => [
      "attributes" => [
        "amount" => $amount * 100, // PayMongo uses centavos
        "description" => $description,
        "remarks" => $remarks
          // "metadata" => [
          //   "order_id" => $orderId,
          //   "order_number" => $orderNumber
          // ]
      ]
    ]
  ];

  if ($orderId || $orderNumber) {
    $data['data']['attributes']['metadata'] = [
        "order_id" => $orderId,
        "order_number" => $orderNumber
    ];
}
if ($redirectUrl) {
  $data['data']['attributes']['redirect'] = [
      'success' => $redirectUrl,
      'failed' => $_ENV['APP_URL'] . "/pages/checkout.php"
  ];
}


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
  if (curl_errno($ch)) {
      throw new Exception('Curl error: ' . curl_error($ch));
  }
  curl_close($ch);

  return json_decode($response, true);
}

 ?>
