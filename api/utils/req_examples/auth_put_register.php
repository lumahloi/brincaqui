<?php
session_id('d10v7tc8gd2qfndvjea710ci71');
session_start();

$cookie = "PHPSESSID=" . session_id();

$data = [
    'email' => 'email2@email.com',
    'telephone' => '12345678901',
    'password' => '999999999',
    'confirmPassword' => '999999999',
];

$ch = curl_init('http://localhost/brincaqui/api/auth/register.php?params=email,telephone,password');
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
