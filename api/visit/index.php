<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";
check_permission(1, $cookie);

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/post.php";
    break;

  case 'GET':
    require_once "./components/get.php";
    break;

  default:
    response_format(405, "Apenas POST e GET permitidos.");
}
