<?php
$data = [
    'fullname' => 'Maria Silva',
    'email' => 'maria@email.com',
    'telephone' => '11999990000',
    'password' => '12345678',
    'confirmPassword' => '12345678',
    'userType' => 1
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded",
        'method' => 'POST',
        'content' => http_build_query($data),
        'ignore_errors' => true
    ]
];

$context = stream_context_create($options);
$result = file_get_contents('http://localhost/brincaqui/backend/auth/register.php', false, $context);
echo $result;
