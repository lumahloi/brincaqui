<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";
check_permission([1, 2, 3], $cookie);
require_once BASE_DIR . "/utils/db_functions.php";

try {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      $db = new Database();
      $info = $db->selectWhere(
        ['disc_title'],
        'desconto',
        ['disc_active'],
        [1]
      );

      not_null_or_false($info);

      $return = $info;

      response_format(200, "Informações extraídas com sucesso.", $return);
      
      break;

    default:
      response_format(405, "Apenas GET permitido.");
  }
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
