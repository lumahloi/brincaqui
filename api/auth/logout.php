<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = trim($_COOKIE['PHPSESSID'] ?? '');
require_once BASE_DIR . "/utils/permission.php";
check_permission([1, 2, 3], $cookie);

try {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
      session_destroy();
      response_format(200, "Até mais!!");
      break;

    default:
      response_format(405, "Apenas POST permitido.");
  }
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
