<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

date_default_timezone_set('America/Sao_Paulo');

$fullname = filter_input(INPUT_POST, "fullname");
$email = filter_input(INPUT_POST, "email");
$telephone = filter_input(INPUT_POST, "telephone");
$password = filter_input(INPUT_POST, "password");
$confirmPassword = filter_input(INPUT_POST, "confirmPassword");
$userType = filter_input(INPUT_POST, "userType");

valid_fullname($fullname);
valid_telephone($telephone);
valid_email($email);
valid_password($password);
valid_user_type($userType);

if ($password !== $confirmPassword) {
  response_format(400, "As senhas não coincidem.");
  exit;
}

if (unique_telephone($telephone)) {
  response_format(400, "Já existe um usuário cadastrado com este telefone.");
  exit;
}

if (unique_email($email)) {
  response_format(400, "Já existe um usuário cadastrado com este e-mail.");
  exit;
}

$fullname = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $fullname);
$telephone = preg_replace('/\D/', '', $telephone);
$hash = password_hash($password, PASSWORD_DEFAULT);
$date = date('Y/m/d');

$pdo = DbConnection::connect();
$p_insert = $pdo->prepare("INSERT INTO brincaqui.usuario (user_name, user_telephone, user_email, user_password, user_active, user_creation, user_lastedit, user_type) VALUES (:user_name, :user_telephone, :user_email, :user_password, 1, :user_creation, :user_lastedit, :user_type);");
$p_insert->bindParam(":user_name", $fullname, PDO::PARAM_STR);
$p_insert->bindParam(":user_telephone", $telephone, PDO::PARAM_STR);
$p_insert->bindParam(":user_email", $email, PDO::PARAM_STR);
$p_insert->bindParam(":user_password", $hash, PDO::PARAM_STR);
$p_insert->bindParam(":user_creation", $date, PDO::PARAM_STR);
$p_insert->bindParam(":user_lastedit", $date, PDO::PARAM_STR);
$p_insert->bindParam(":user_type", $userType, PDO::PARAM_STR);
$insert_user = $p_insert->execute();

if (!$insert_user) {
  response_format(400, "Não foi possível realizar seu cadastro, revise seus dados e tente novamente.");
  exit;
}

response_format(201, "Conta criada com sucesso.");
