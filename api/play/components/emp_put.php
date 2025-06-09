<?php
require_once BASE_DIR . "/utils/validate_infos.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/validate_infos.php";

check_ownership($_SESSION['user_id'], $input_id);

$params = valid_url_params();

function update(string $table, array $columns_to_change, array $values_to_set, array $where_columns, string $where_value)
{
  if (!db_update($table, $columns_to_change, $values_to_set, $where_columns, $where_value)) {
    response_format(400, "Não foi possível realizar sua atualização, revise seus dados e tente novamente.");
  }
}

foreach ($params as $param) {
  switch ($param) {
    case 'pictures':
      update('brinquedo', ['brin_pictures'], [$input_pictures], ['brin_id'], $input_id);
      break;

    case 'socials':
      update('brinquedo', ['brin_socials'], [$input_socials], ['brin_id'], $input_id);
      break;

    case 'description':
      update('brinquedo', ['brin_description'], [$input_description], ['brin_id'], $input_id);
      break;

    case 'times':
      update('brinquedo', ['brin_times'], [$input_times], ['brin_id'], $input_id);
      break;

    case 'commodities':
      update('brinquedo', ['brin_commodities'], [$input_commodities], ['brin_id'], $input_id);
      break;

    case 'prices':
      update('brinquedo', ['brin_prices'], [$input_prices], ['brin_id'], $input_id);
      break;

    case 'discounts':
      update('brinquedo', ['brin_discounts'], [$input_discounts], ['brin_id'], $input_id);
      break;

    case 'telephone':
      update('brinquedo', ['brin_telephone'], [$input_telephone], ['brin_id'], $input_id);
      break;

    case 'email':
      update('brinquedo', ['brin_email'], [$input_email], ['brin_id'], $input_id);
      break;

    case 'name':
      update('brinquedo', ['brin_name'], [$input_name], ['brin_id'], $input_id);
      break;

    case 'ages':
      update('brinquedo', ['brin_ages'], [$input_ages], ['brin_id'], $input_id);
      break;

    case 'active':
      db_toggle_active('brinquedo', 'brin_active', ['brin_id'], $input_id);
      break;

    default:
      response_format(405, "Tipo de parâmetro inválido.");
  }
}

response_format(200, "Atualização(s) feita com sucesso.");
