<?php
require_once "test_auth_header.php";

$data = [
  'description' => 'Muito bom voltarei mais vezes',
  'grade_1' => 10,
  'grade_2' => 9.5,
  'grade_3' => 3.5,
  'grade_4' => 2.3,
  'grade_5' => 6.7,
  'grade_6' => 9.1,
  'grade_7' => 3.7,
];

$ch = curl_init('http://localhost/brincaqui/api/feedback/8');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
