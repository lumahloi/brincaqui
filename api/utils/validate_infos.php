<?php
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/db_functions.php";

function valid_fullname($fullname)
{
  $sanitized = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $fullname);

  if (strlen($sanitized) > 45) {
    response_format(400, "Seu nome ultrapassa 45 caracteres.");

  }
  if (strlen($sanitized) < 5) {
    response_format(400, "Seu nome tem menos que 5 caracteres.");
  }

  return $sanitized;
}

function valid_telephone($telephone)
{
  $sanitized = preg_replace('/\D/', '', $telephone);

  if (strlen($sanitized) > 11) {
    response_format(400, "Seu telefone ultrapassa 11 caracteres.");
  }

  if (strlen($sanitized) < 11) {
    response_format(400, "Seu telefone tem menos que 11 caracteres.");
  }

  if (db_select_where(['user_id'], 'usuario', ['user_telephone'], [$sanitized])) {
    response_format(400, "Já existe um usuário cadastrado com este telefone.");
  }

  return $sanitized;
}

function valid_telephone_from_play($telephone)
{
  $sanitized = preg_replace('/\D/', '', $telephone);

  if (strlen($sanitized) > 11) {
    response_format(400, "Seu telefone ultrapassa 11 caracteres.");
  }

  if (strlen($sanitized) < 11) {
    response_format(400, "Seu telefone tem menos que 11 caracteres.");
  }

  return $sanitized;
}

function valid_email($email)
{
  if (strlen($email) > 40) {
    response_format(400, "Seu e-mail ultrapassa 40 caracteres.");
  }
  if (strlen($email) < 7) {
    response_format(400, "Seu e-mail tem menos que 7 caracteres.");
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response_format(400, "Insira um e-mail de formato válido.");
  }
  if (db_select_where(['user_id'], 'usuario', ['user_email'], [$email])) {
    response_format(400, "Já existe um usuário cadastrado com este e-mail.");
  }
}

function valid_email_from_play($email)
{
  if (strlen($email) > 40) {
    response_format(400, "Seu e-mail ultrapassa 40 caracteres.");
  }
  if (strlen($email) < 7) {
    response_format(400, "Seu e-mail tem menos que 7 caracteres.");
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response_format(400, "Insira um e-mail de formato válido.");
  }
}

function valid_email_characters($email)
{
  if (strlen($email) > 40) {
    response_format(400, "Seu e-mail ultrapassa 25 caracteres.");
  }
  if (strlen($email) < 7) {
    response_format(400, "Seu e-mail tem menos que 7 caracteres.");
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response_format(400, "Insira um e-mail de formato válido.");
  }
}

function valid_password($password)
{
  if (strlen($password) > 25) {
    response_format(400, "Sua senha ultrapassa 25 caracteres.");
  }
  if (strlen($password) < 8) {
    response_format(400, "Sua senha tem menos que 8 caracteres.");
  }
}

function valid_user_type($userType)
{
  if (!db_select_where(['id'], 'tipousuario', ['id'], [$userType]) || $userType == 3) {
    response_format(400, "Insira um tipo de usuário válido.");
  }
}

function valid_description($description)
{
  if (strlen($description) > 2000) {
    response_format(400, "Sua descrição ultrapassa 2000 caracteres.");
  }
  if (strlen($description) < 200) {
    response_format(400, "Sua descrição tem menos que 200 caracteres.");
  }
}

function valid_cnpj($cnpj)
{
  $sanitized = preg_replace('/\D/', '', $cnpj);

  if (strlen($sanitized) > 14) {
    response_format(400, "Seu CNPJ ultrapassa 14 caracteres.");
  }
  if (strlen($sanitized) < 14) {
    response_format(400, "Seu CNPJ tem menos que 14 caracteres.");
  }

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
  if (strlen($name) > 45) {
    response_format(400, "Seu nome ultrapassa 45 caracteres.");
  }
  if (strlen($name) < 5) {
    response_format(400, "Seu nome tem menos que 5 caracteres.");
  }
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
  $user_id_from_db = db_select_where(['Usuario_user_id'], 'brinquedo', ['brin_id'], [$brin_id]);
  if($user_id != $user_id_from_db['Usuario_user_id']){
    response_format(400, "Você não é o dono deste brinquedo.");
  }
}

function valid_cep($cep)
{
  $sanitized = preg_replace('/\D/', '', $cep);

  if (strlen($sanitized) > 8) {
    response_format(400, "Seu CEP ultrapassa 8 caracteres.");
  }

  if (strlen($sanitized) < 8) {
    response_format(400, "Seu CEP tem menos que 8 caracteres.");
  }
  
  return $sanitized;
}

function valid_characters($min, $max, $var){
  if (strlen($var) > $max) {
    response_format(400, "$var ultrapassa $max caracteres.");
  }
  if (strlen($var) < $min) {
    response_format(400, "$var tem menos que $min caracteres.");
  }
}

function not_null_or_false($var)
{
  if($var === null || $var === false){
    return response_format(400, "Ocorreu um erro, por favor tente novamente mais tarde.");
  }
}