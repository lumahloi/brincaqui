<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
check_permission([1, 2]);
require_once BASE_DIR . "/utils/validate_infos.php";

if (!isset($_GET['params'])) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

$params = explode(',', $_GET['params']);

if (empty($params)) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

foreach ($params as $param) {
  switch ($param) {
    case 'telephone':
      $input_telephone = valid_telephone($input_telephone);
      if (!db_update('usuario', ['user_telephone', 'user_lastedit'], [$input_telephone, $date], ['user_id'], $_SESSION_['user_id'])) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    case 'email':
      valid_email($input_email);
      if (!db_update('usuario', ['user_email', 'user_lastedit'], [$input_email, $date], ['user_id'], $_SESSION_['user_id'])) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    case 'password':
      valid_password($input_password);
      if ($input_password !== $input_confirm_password) {
        response_format(400, "As senhas não coincidem.");
      }
      $hash = password_hash($input_password, PASSWORD_DEFAULT);
      if (!db_update('usuario', ['user_password', 'user_lastedit'], [$hash, $date], ['user_id'], $_SESSION_['user_id'])) {
        response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
      }
      break;

    default:
      response_format(405, "Tipo de parâmetro inválido.");
  }
}

response_format(200, "Atualização(s) feita com sucesso.");
