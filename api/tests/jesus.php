<?php
$data = [
    'email' => 'testecliente2@email.com'
];

$ch = curl_init('http://localhost:8000/api/auth/register.php?params=email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: PHPSESSID=169ec4f5aa71a4694c48019f81b0f7a7"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;