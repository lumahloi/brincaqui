<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

valid_email($input_email);
valid_password($input_password);

$password_from_db = db_select_where(['user_password'], 'usuario', ['user_email'], $input_email);

if (!$password_from_db || !password_verify($input_password, $password_from_db['user_password'])) {
  response_format(400, "Senha inválida.");
}
