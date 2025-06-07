<?php
$data = [
    'fullname' => 'Maria Silva',
    'email' => 'maria@email.com',
    'telephone' => '11999990000',
    'password' => '12345678',
    'confirmPassword' => '12345678',
    'userType' => 2
];

$ch = curl_init('http://localhost/brincaqui/api/auth/register.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;