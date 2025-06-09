<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";

switch ($_SESSION['user_type']) {
  case 1:
    check_permission([1,3], $cookie);
    require_once "./components/user_cli_only.php";
    break;

  case 2:
    check_permission([1,2,3], $cookie);
    require_once "./components/user_all.php";
    break;

  default:
    response_format(400, "Sessão inválida, realize login e tente novamente.");
    break;
}
