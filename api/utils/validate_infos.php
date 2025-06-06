<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

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
  if (strlen($email) > 40) {
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

function valid_description($description)
{
  if (strlen($description) > 2000) {
    response_format(400, "Sua descrição ultrapassa 2000 caracteres.");
    exit;
  }
  if (strlen($description) < 200) {
    response_format(400, "Sua descrição tem menos que 200 caracteres.");
    exit;
  }
}

function valid_cnpj($cnpj)
{
  if (strlen($cnpj) > 14) {
    response_format(400, "Seu CNPJ ultrapassa 14 caracteres.");
    exit;
  }
  if (strlen($cnpj) < 14) {
    response_format(400, "Seu CNPJ tem menos que 14 caracteres.");
    exit;
  }
}

function valid_array($array, $field_name = '')
{
  if (!is_array($array)) {
    response_format(400, "Formato inválido para o campo " . ($field_name ?: 'desconhecido'));
    exit;
  }
}

function valid_times($times)
{
  foreach ($times as $dia => $faixas) {
    if (!is_array($faixas)) {
      response_format(400, "Formato de horários inválido para $dia");
      exit;
    }

    foreach ($faixas as $faixa) {
      if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $faixa)) {
        response_format(400, "Formato de faixa horária inválido: $faixa");
        exit;
      }
    }
  }
}

function valid_json_data(array $json_array, array $expected_fields)
{
  foreach ($json_array as $index => $item) {
    foreach ($expected_fields as $field) {
      if (!array_key_exists($field, $item)) {
        response_format(400, "Campo obrigatório '$field' ausente no item #$index.");
        exit;
      }
    }
  }
}

function json_field_non_empty(array $json_array, string $field)
{
  foreach ($json_array as $index => $item) {
    if (
      !isset($item[$field]) ||
      (empty($item[$field]) && $item[$field] !== 0 && $item[$field] !== '0')
    ) {
      response_format(400, "Campo '$field' no item #$index não pode ser vazio.");
      exit;
    }
  }
}

function valid_number($number)
{
  if (!is_numeric($number)) {
    response_format(400, "$number deve ser um número.");
    exit;
  }
}

function unique_telephone_from_user($telephone)
{
  $pdo = DbConnection::connect();
  $p_check_telephone = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_telephone = :user_telephone;");
  $p_check_telephone->bindParam(":user_telephone", $telephone, PDO::PARAM_STR);
  $p_check_telephone->execute();
  $telephone_exists = $p_check_telephone->fetch(PDO::FETCH_ASSOC);
  return $telephone_exists;
}

function unique_email_from_user($email)
{
  $pdo = DbConnection::connect();
  $p_check_email = $pdo->prepare("SELECT * FROM brincaqui.usuario WHERE user_email = :user_email;");
  $p_check_email->bindParam(":user_email", $email, PDO::PARAM_STR);
  $p_check_email->execute();
  $email_exists = $p_check_email->fetch(PDO::FETCH_ASSOC);
  return $email_exists;
}

function unique_cnpj($cnpj)
{
  $pdo = DbConnection::connect();
  $p_check_cnpj = $pdo->prepare("SELECT * FROM brincaqui.brinquedo WHERE brin_cnpj = :brin_cnpj;");
  $p_check_cnpj->bindParam(":brin_cnpj", $cnpj, PDO::PARAM_STR);
  $p_check_cnpj->execute();
  $cnpj_exists = $p_check_cnpj->fetch(PDO::FETCH_ASSOC);
  return $cnpj_exists;
}

function array_contains_numbers($array)
{
  if (!array_filter($array, 'is_int')) {
    response_format(400, "$array deve conter apenas números.");
    exit;
  }
}
