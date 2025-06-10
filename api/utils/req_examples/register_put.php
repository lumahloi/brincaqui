<?php
require_once "test_auth_header.php";

$data = [
    // 'email' => 'teste@gmail.com',
    'telephone' => '12345678902',
    // 'password' => '999999999',
    // 'confirmPassword' => '999999999',
];

// ?params=email,telephone,password

$ch = curl_init('http://localhost/brincaqui/api/auth/register.php?params=telephone');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
