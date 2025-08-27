<?php
// Correct the path to the cacert.pem file
$cacert_path = "C:/xampp/php/cacert.pem";  // Update this path accordingly

// Check OpenSSL version
echo "OpenSSL version: " . OPENSSL_VERSION_TEXT . "\n";

// Check if the cacert.pem file can be loaded
if (file_get_contents($cacert_path)) {
    echo "cacert.pem is being loaded correctly.\n";
} else {
    echo "Error loading cacert.pem.\n";
}
?>
