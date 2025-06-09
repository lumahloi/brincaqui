<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once "register_validation.php";

if (!isset($_GET['params'])) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

$params = explode(',', $_GET['params']);

if (empty($params)) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

function update(string $table, array $columns_to_change, array $values_to_set, array $where_columns, string $where_value)
{
  if (!db_update($table, $columns_to_change, $values_to_set, $where_columns, $where_value)) {
    response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
  }
}


foreach ($params as $param) {
  switch ($param) {
    case 'pictures':
      update('brinquedo', ['brin_pictures'], [$input_pictures], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'socials':
      update('brinquedo', ['brin_socials'], [$input_socials], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'description':
      update('brinquedo', ['brin_description'], [$input_description], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'times':
      update('brinquedo', ['brin_times'], [$input_times], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'commodities':
      update('brinquedo', ['brin_commodities'], [$input_commodities], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'prices':
      update('brinquedo', ['brin_prices'], [$input_prices], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'discounts':
      update('brinquedo', ['brin_discounts'], [$input_discounts], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'telephone':
      update('brinquedo', ['brin_telephone'], [$input_telephone], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'email':
      update('brinquedo', ['brin_email'], [$input_email], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'name':
      update('brinquedo', ['brin_name'], [$input_name], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    case 'ages':
      update('brinquedo', ['brin_ages'], [$input_ages], ['Usuario_user_id'], $_SESSION['user_id']);
      break;

    default:
      response_format(405, "Tipo de parâmetro inválido.");
  }
}

response_format(200, "Atualização(s) feita com sucesso.");
