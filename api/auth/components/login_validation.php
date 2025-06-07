<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

valid_email($input_email);
valid_password($input_password);

$pdo = DbConnection::connect();
$p_check_password = $pdo->prepare("SELECT user_password FROM brincaqui.usuario WHERE user_email = :user_email;");
$p_check_password->bindParam(":user_email", $input_email, PDO::PARAM_STR);
$p_check_password->execute();
$password_from_db = $p_check_password->fetch(PDO::FETCH_ASSOC);

if (!$password_from_db || !password_verify($input_password, $password_from_db['user_password'])) {
  response_format(400, "Senha inválida.");
}