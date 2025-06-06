<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

valid_description($input_description);

valid_fullname($input_name);

valid_cnpj($input_cnpj);
if (unique_cnpj($input_cnpj)) {
  response_format(400, "Já existe uma empresa cadastrada com este CNPJ.");
  exit;
}

valid_array($input_pictures);
valid_json_data($input_pictures, ['picture_name']);
json_field_non_empty($input_pictures, 'picture_name');

valid_array($input_socials);
valid_json_data($input_socials, ['socials_name', 'socials_url']);
json_field_non_empty($input_socials, 'socials_name');
json_field_non_empty($input_socials, 'socials_url');

valid_array($input_prices);
valid_json_data($input_prices, ['prices_title', 'prices_price']);
json_field_non_empty($input_prices, 'prices_title');
json_field_non_empty($input_prices, 'prices_price');
valid_number($input_prices['prices_price']);

valid_array($input_times);
valid_times($times);
valid_json_data($input_times, ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'feriado']);

valid_array($input_commodities);
array_contains_numbers($input_commodities);

valid_array($input_discounts);
array_contains_numbers($input_discounts);

valid_telephone($input_telephone);

valid_email($input_email);

valid_array($input_ages);
array_contains_numbers($input_ages);