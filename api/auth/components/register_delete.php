<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([1, 2]);
require_once BASE_DIR . "/utils/validate_infos.php";

check_cookie($cookie);

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

if (!db_update('usuario', ['user_active', 'user_lastedit'], [0, $date], ['user_id'], $_SESSION['user_id'])) {
  response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
}

response_format(200, "Conta deletada com sucesso.");
