<?php
require_once "test_auth_header.php";

$ch = curl_init('http://localhost/brincaqui/api/feedback/8');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;