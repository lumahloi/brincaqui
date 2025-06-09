<?php
require_once "../../base_dir.php";
require_once BASE_DIR . "/utils/load_env.php";
load_env(BASE_DIR . '/.env');
session_id(getenv('SESSION_ID'));
session_start();

$cookie = "PHPSESSID=" . session_id();

$ch = curl_init('http://localhost/brincaqui/api/play/2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
