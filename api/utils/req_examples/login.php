<?php
$data = [
  'email' => 'maria@email.com',
  'password' => '12345678'
];

$options = [
  'http' => [
    'header' => "Content-type: application/json",
    'method' => 'POST',
    'content' => json_encode($data),
    'ignore_errors' => true
  ]
];

$context = stream_context_create($options);
$result = file_get_contents('http://localhost/brincaqui/api/auth/login.php', false, $context);
echo $result;