<?php
require_once BASE_DIR . "/utils/db_functions.php";

$hash = password_hash($input_password, PASSWORD_DEFAULT);

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

$db = new Database();

$insert_user = $db->insertInto(
  'usuario', 
  ['user_name', 'user_telephone', 'user_email', 'user_password', 'user_active', 'user_creation', 'user_lastedit', 'user_type'], 
  [$input_fullname, $input_telephone, $input_email, $hash, 1, $date, $date, $input_user_type]
);

not_null_or_false($insert_user);

response_format(201, "Conta criada com sucesso.");
