<?php
session_id('8724dqb3h4fe33q04c89it907o');
session_start();

$cookie = "PHPSESSID=" . session_id();

$ch = curl_init('http://localhost/brincaqui/api/auth/register.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
