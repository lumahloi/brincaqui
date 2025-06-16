<?php
// require_once "test_auth_header.php";

$ch = curl_init('http://localhost:8000/api/play/3');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
    // "Cookie: $cookie"
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;