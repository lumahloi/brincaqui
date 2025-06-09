<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission(2);

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

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/register_post.php";
    break;

  case 'PUT':
    require_once "./components/register_put.php";
    break;

  default:
    response_format(405, "Apenas POST permitido.");
}
