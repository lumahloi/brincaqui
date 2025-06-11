<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    check_permission([1,2,3], $cookie);
    require_once "./components/user_all.php"; 
    break;
  case 'POST':
    check_permission([1,3], $cookie);
    require_once "./components/user_cli_only.php";
    break;
  default:
    response_format(400, "Sessão inválida, realize login e tente novamente.");
    break;
}
