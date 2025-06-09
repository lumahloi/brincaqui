<?php
require_once BASE_DIR . "/utils/db_functions.php";

$insert_play = db_insert_into(
  'brinquedo',
  ['brin_pictures', 'brin_socials', 'brin_description', 'brin_times', 'brin_commodities', 'brin_prices', 'brin_discounts', 'brin_telephone', 'brin_email', 'brin_name', 'brin_cnpj', 'brin_ages', 'Usuario_user_id', 'brin_active'],
  [$input_pictures, $input_socials, $input_description, $input_times, $input_commodities, $input_prices, $input_discounts, $input_telephone, $input_email, $input_name, $input_cnpj, $input_ages, $_SESSION['user_id'], 1]
);

if (!$insert_play) {
  response_format(400, "Não foi possível cadastrar seu brinquedo, revise seus dados e tente novamente.");
}

response_format(201, "Brinquedo criado com sucesso.");
