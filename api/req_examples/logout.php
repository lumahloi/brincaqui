<?php
require_once "test_auth_header.php";

$ch = curl_init('http://localhost/brincaqui/api/auth/logout.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
