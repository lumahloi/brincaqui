<?php
$data = [
    'fullname' => 'Lumah Pereira',
    'email' => 'lumahempresa@gmail.com',
    'telephone' => '21979489728',
    'password' => 'admin@123',
    'confirmPassword' => 'admin@123',
    'userType' => 1
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