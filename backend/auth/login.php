<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/services/db_connection.php";
require_once BASE_DIR . "/services/response_format.php";
require_once BASE_DIR . "/services/validate_infos.php";

$email = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");

valid_email($email);
valid_password($password);

if (!unique_email($email)) {
  response_format(400, "Não existe usuário cadastrado com este e-mail.");
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$pdo = DbConnection::connect();
$p_check_password = $pdo->prepare("SELECT user_password FROM brincaqui.usuario WHERE user_email = :user_email;");
$p_check_password->bindParam(":user_email", $email, PDO::PARAM_STR);
$p_check_password->execute();
$password = $p_check_password->fetch(PDO::FETCH_ASSOC);
if ($password != $hash) {
  response_format(400, "Senha inválida.");
  exit;
}

$p_get_user_info = $pdo->prepare("SELECT user_id, user_name, user_type FROM brincaqui.usuario WHERE user_email = :user_email;");
$p_get_user_info->bindParam(":user_email", $email, PDO::PARAM_STR);
$p_get_user_info->execute();
$user_info = $p_get_user_info->fetch(PDO::FETCH_ASSOC);
session_start();
$_SESSION["user_id"] = $user_info['user_id'];
$_SESSION["user_name"] = $user_info['user_name'];
$_SESSION["user_type"] = $user_info['user_type'];

$return = [
  "logged_user_id" => $_SESSION["user_id"],
  "logged_user_name" => $_SESSION["user_name"],
  "logged_user_type" => $_SESSION["user_type"]
];

response_format(200, "Login realizado com sucesso.", $return);
