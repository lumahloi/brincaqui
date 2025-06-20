<?php
$data = [
    'grade_2' => 1,
    'grade_3' => 2,
    'grade_4' => 3,
    'grade_5' => 4,
    'grade_6' => 5,
    'grade_7' => 1
];

$ch = curl_init('http://localhost:8000/api/feedback/31');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: PHPSESSID=169ec4f5aa71a4694c48019f81b0f7a7"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
