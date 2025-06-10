<?php
session_start();
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([1,2,3], $cookie);
require_once BASE_DIR . "/utils/validate_infos.php";

$params = valid_url_params();

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

foreach ($params as $param) {
  switch ($param) {
    case 'telephone':
      $update = db_update('usuario', ['user_telephone', 'user_lastedit'], [$input_telephone, $date], ['user_id'], $_SESSION['user_id']);
      if ($update === false || $update === null) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    case 'email':
      $update = db_update('usuario', ['user_email', 'user_lastedit'], [$input_email, $date], ['user_id'], $_SESSION['user_id']);
      if ($update === false || $update === null) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    case 'password':
      $hash = password_hash($input_password, PASSWORD_DEFAULT);
      $update = db_update('usuario', ['user_password', 'user_lastedit'], [$hash, $date], ['user_id'], $_SESSION['user_id']);
      if ($update === false || $update === null) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    default:
      response_format(405, "Tipo de parâmetro inválido.");
  }
}

response_format(200, "Atualização(s) feita com sucesso.");
