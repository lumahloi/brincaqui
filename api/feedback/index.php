<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";

switch ($_SESSION['user_type']) {
  case 1:
    // fazer, editar, deletar avaliações
    check_permission([1,3], $cookie);
    break;

  case 2:
    // ver avaliações
    check_permission([1,2,3], $cookie);
    break;

  default:
    response_format(400, "Sessão inválida, realize login e tente novamente.");
    break;
}