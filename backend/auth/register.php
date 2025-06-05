<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/services/db_connection.php";
require_once BASE_DIR . "/services/response_format.php";

date_default_timezone_set('America/Sao_Paulo');

$fullname = filter_input(INPUT_POST, "fullname");
$email = filter_input(INPUT_POST, "email");
$telephone = filter_input(INPUT_POST, "telephone");
$password = filter_input(INPUT_POST, "password");
$confirmPassword = filter_input(INPUT_POST, "confirmPassword");

if (strlen($fullname) > 45) {
  response_format(400, "Seu nome ultrapassa 45 caracteres.");
  exit;
}

if (strlen($fullname) < 5) {
  response_format(400, "Seu nome tem menos que 5 caracteres.");
  exit;
}

if (strlen($telephone) > 11) {
  response_format(400, "Seu telefone ultrapassa 11 caracteres.");
  exit;
}

if (strlen($telephone) < 11) {
  response_format(400, "Seu telefone tem menos que 11 caracteres.");
  exit;
}

if (strlen($email) > 25) {
  response_format(400, "Seu e-mail ultrapassa 25 caracteres.");
  exit;
}

if (strlen($email) < 7) {
  response_format(400, "Seu e-mail tem menos que 7 caracteres.");
  exit;
}

if (strlen($password) > 25) {
  response_format(400, "Sua senha ultrapassa 32 caracteres.");
  exit;
}

if (strlen($password) < 8) {
  response_format(400, "Sua senha tem menos que 8 caracteres.");
  exit;
}

if ($password !== $confirmPassword) {
  response_format(400, "As senhas não coincidem.");
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  response_format(400, "Insira um e-mail de formato válido.");
  exit;
}

$pdo = DbConnection::connect();

$p_check_telephone = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_telephone = :user_telephone;");
$p_check_telephone->bindParam(":user_telephone", $telephone, PDO::PARAM_STR);
$p_check_telephone->execute();
$telephone_exists = $p_check_telephone->fetch(PDO::FETCH_ASSOC);
if ($telephone_exists) {
  response_format(400, "Já há um usuário cadastrado com este telefone.");
  exit;
}

$p_check_email = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_email = :user_email;");
$p_check_email->bindParam(":user_email", $email, PDO::PARAM_STR);
$p_check_email->execute();
$email_exists = $p_check_email->fetch(PDO::FETCH_ASSOC);
if ($email_exists) {
  response_format(400, "Já há um usuário cadastrado com este e-mail.");
  exit;
}

$fullname = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $fullname);
$telephone = preg_replace('/\D/', '', $telephone);
$hash = password_hash($password, PASSWORD_DEFAULT);
$date = date('Y/m/d');

$p_insert = $pdo->prepare("INSERT INTO brincaqui.usuario (user_name, user_telephone, user_email, user_password, user_active, user_creation, user_lastedit) VALUES (:user_name, :user_telephone, :user_email, :user_password, 1, :user_creation, :user_lastedit);");
$p_insert->bindParam(":user_name", $fullname, PDO::PARAM_STR);
$p_insert->bindParam(":user_telephone", $telephone, PDO::PARAM_STR);
$p_insert->bindParam(":user_email", $email, PDO::PARAM_STR);
$p_insert->bindParam(":user_password", $hash, PDO::PARAM_STR);
$p_insert->bindParam(":user_creation", $date, PDO::PARAM_STR);
$p_insert->bindParam(":user_lastedit", $date, PDO::PARAM_STR);
$insert_user = $p_insert->execute();

if (!$insert_user) {
  response_format(400, "Não foi possível realizar seu cadastro, revise seus dados e tente novamente.");
  exit;
}

response_format(201, "Conta criada com sucesso.");
