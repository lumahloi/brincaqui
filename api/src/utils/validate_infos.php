<?php
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/db_functions.php";

function valid_characters($min, $max, $value, $field_name)
{
  if (strlen($value) > $max) {
    response_format(400, "O campo '$field_name' ultrapassa $max caracteres.");
  }
  if (strlen($value) < $min) {
    response_format(400, "O campo '$field_name' precisa ter no mínimo $min caracteres.");
  }
}

function valid_fullname($fullname)
{
  $sanitized = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $fullname);
  valid_characters(5, 45, $sanitized, 'Nome completo');
  return $sanitized;
}

function valid_telephone($telephone, $isUser = null)
{
  $sanitized = preg_replace('/\D/', '', $telephone);
  valid_characters(11, 11, $sanitized, 'Telefone');
  if ($isUser) {
    $db = new Database();
    $result = $db->selectWhere(
      ['user_id'], 
      'usuario', 
      ['user_telephone'], 
      [$sanitized]
    );
    if ($result) {
      response_format(400, "Já existe um usuário cadastrado com este telefone.");
    }
  }
  return $sanitized;
}

function valid_email($email, $isUser = null)
{
  valid_characters(7, 40, $email, 'E-mail');
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response_format(400, "Insira um e-mail de formato válido.");
  }
  if ($isUser) {
    $db = new Database();
    $result = $db->selectWhere(
      ['user_id'], 
      'usuario', 
      ['user_email'], 
      [$email]
    );
    if ($result) {
      response_format(400, "Já existe um usuário cadastrado com este e-mail.");
    }
  }
}

function valid_password($password)
{
  valid_characters(8, 25, $password, 'Senha');
}

function valid_user_type($userType)
{
  $db = new Database();
  $result = $db->selectWhere(
    ['id'], 
    'tipousuario', 
    ['id'], 
    [$userType]
  );
  if (!$result || $userType == 3) {
    response_format(400, "Insira um tipo de usuário válido.");
  }
}

function valid_description($description)
{
  valid_characters(200, 2000, $description, 'Descrição');
}

function valid_cnpj($cnpj)
{
  $sanitized = preg_replace('/\D/', '', $cnpj);
  valid_characters(14, 14, $sanitized, 'CNPJ');
  return $sanitized;
}

function valid_array($array, $field_name = '')
{
  if (!is_array($array)) {
    response_format(400, "Formato inválido para o campo " . ($field_name ?: 'desconhecido'));
  }
}

function valid_times($times)
{
  foreach ($times as $dia => $faixas) {
    if (!is_array($faixas)) {
      response_format(400, "Formato de horários inválido para $dia");
    }
    foreach ($faixas as $faixa) {
      if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $faixa)) {
        response_format(400, "Formato de faixa horária inválido: $faixa");
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
    }
  }
}

function valid_number($number)
{
  if (!is_numeric($number)) {
    response_format(400, "$number deve ser um número.");
  }
}

function array_contains_numbers($array)
{
  if (!array_filter($array, 'is_int')) {
    response_format(400, "$array deve conter apenas números.");
  }
}

function valid_play_name($name)
{
  valid_characters(5, 45, $name, 'Nome');
}

function valid_url_params()
{
  if (!isset($_GET['params'])) {
    response_format(400, "Inclua pelo menos um atributo a ser alterado.");
  }
  $params = explode(',', $_GET['params']);
  if (empty($params)) {
    response_format(400, "Inclua pelo menos um atributo a ser alterado.");
  }
  return $params;
}

function check_ownership($user_id, $brin_id)
{
  $db = new Database();
  $user_id_from_db = $db->selectWhere(['Usuario_user_id'], 'brinquedo', ['brin_id'], [$brin_id]);
  if ($user_id != $user_id_from_db['Usuario_user_id']) {
    response_format(400, "Você não é o dono deste brinquedo.");
  }
}

function valid_cep($cep)
{
  $sanitized = preg_replace('/\D/', '', $cep);
  valid_characters(8, 8, $sanitized, 'CEP');
  return $sanitized;
}

function not_null_or_false($var)
{
  if ($var === null || $var === false) {
    return response_format(400, "Ocorreu um erro, por favor tente novamente mais tarde.");
  }
}
