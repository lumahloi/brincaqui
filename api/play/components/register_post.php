<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";

date_default_timezone_set('America/Sao_Paulo');

$data = json_decode(file_get_contents('php://input'), true);

$input_description = filter_var($data['description']) ?? '';
$input_name = filter_var($data['name']) ?? '';
$input_cnpj = filter_var($data['cnpj']) ?? '';
$input_telephone = filter_var($data['telephone']) ?? '';
$input_email = filter_var($data['email']) ?? '';
$input_pictures = $data['pictures'] ?? null;
$input_socials = $data['socials'] ?? null;
$input_prices = $data['prices'] ?? null;
$input_times = $data['times'] ?? null;
$input_commodities = $data['commodities'] ?? [];
$input_discounts = $data['discounts'] ?? [];
$input_ages = $data['ages'] ?? [];

require_once "./components/register_post_validation.php";

$input_cnpj = preg_replace('/\D/', '', $input_cnpj);
$input_pictures = json_encode($input_pictures);
$input_socials = json_encode($input_socials);
$input_times = json_encode($input_times);
$input_commodities = json_encode($input_commodities);
$input_prices = json_encode($input_prices);
$input_discounts = json_encode($input_discounts);
$input_ages = json_encode($input_ages);

$insert_play = db_insert_into(
  'brinquedo',
  ['brin_pictures', 'brin_socials', 'brin_description', 'brin_times', 'brin_commodities', 'brin_prices', 'brin_discounts', 'brin_telephone', 'brin_email', 'brin_name', 'brin_cnpj', 'brin_ages', 'Usuario_user_id'],
  [$input_pictures, $input_socials, $input_description, $input_times, $input_commodities, $input_prices, $input_discounts, $input_telephone, $input_email, $input_name, $input_cnpj, $input_ages, $_SESSION['user_id']]
);

if (!$insert_play) {
  response_format(400, "Não foi possível cadastrar seu brinquedo, revise seus dados e tente novamente.");
}

response_format(201, "Brinquedo criado com sucesso.");