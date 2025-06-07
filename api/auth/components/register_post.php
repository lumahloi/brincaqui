<?php
require_once "../base_dir.php";
require_once "./components/register_post_validation.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";

$hash = password_hash($input_password, PASSWORD_DEFAULT);

$insert_user = db_insert_into('usuario', ['user_name', 'user_telephone', 'user_email', 'user_password', 'user_active', 'user_creation', 'user_lastedit', 'user_type'], [$input_fullname, $input_telephone, $input_email, $hash, $date, $date, $input_user_type]);

if (!$insert_user) {
  response_format(400, "Não foi possível realizar seu cadastro, revise seus dados e tente novamente.");
}

response_format(201, "Conta criada com sucesso.");
