<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/services/response_format.php";

function valid_fullname($fullname)
{
  if (strlen($fullname) > 45) {
    response_format(400, "Seu nome ultrapassa 45 caracteres.");
    exit;
  }
  if (strlen($fullname) < 5) {
    response_format(400, "Seu nome tem menos que 5 caracteres.");
    exit;
  }
}

function valid_telephone($telephone)
{
  if (strlen($telephone) > 11) {
    response_format(400, "Seu telefone ultrapassa 11 caracteres.");
    exit;
  }
  if (strlen($telephone) < 11) {
    response_format(400, "Seu telefone tem menos que 11 caracteres.");
    exit;
  }
}

function valid_email($email)
{
  if (strlen($email) > 25) {
    response_format(400, "Seu e-mail ultrapassa 25 caracteres.");
    exit;
  }
  if (strlen($email) < 7) {
    response_format(400, "Seu e-mail tem menos que 7 caracteres.");
    exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response_format(400, "Insira um e-mail de formato válido.");
    exit;
  }
}

function valid_password($password)
{
  if (strlen($password) > 25) {
    response_format(400, "Sua senha ultrapassa 32 caracteres.");
    exit;
  }
  if (strlen($password) < 8) {
    response_format(400, "Sua senha tem menos que 8 caracteres.");
    exit;
  }
}

function valid_user_type($userType)
{
  $pdo = DbConnection::connect();
  $p_check_user_type = $pdo->prepare("SELECT id FROM brincaqui.tipousuario WHERE id = :id;");
  $p_check_user_type->bindParam(":id", $userType, PDO::PARAM_STR);
  $p_check_user_type->execute();
  $user_type_exists = $p_check_user_type->fetch(PDO::FETCH_ASSOC);
  if (!$user_type_exists || $userType == 3) {
    response_format(400, "Insira um tipo de usuário válido.");
    exit;
  }
}

function unique_telephone($telephone)
{
  $pdo = DbConnection::connect();
  $p_check_telephone = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_telephone = :user_telephone;");
  $p_check_telephone->bindParam(":user_telephone", $telephone, PDO::PARAM_STR);
  $p_check_telephone->execute();
  $telephone_exists = $p_check_telephone->fetch(PDO::FETCH_ASSOC);
  return $telephone_exists;
}

function unique_email($email)
{
  $pdo = DbConnection::connect();
  $p_check_email = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_email = :user_email;");
  $p_check_email->bindParam(":user_email", $email, PDO::PARAM_STR);
  $p_check_email->execute();
  $email_exists = $p_check_email->fetch(PDO::FETCH_ASSOC);
  return $email_exists;
}