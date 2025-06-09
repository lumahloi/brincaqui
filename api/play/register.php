<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
check_permission(2, $cookie);

$data = json_decode(file_get_contents('php://input'), true);

$input_description = isset($data['description']) ? filter_var($data['description'], FILTER_SANITIZE_STRING) : '';
$input_name = isset($data['name']) ? filter_var($data['name'], FILTER_SANITIZE_STRING) : '';
$input_cnpj = isset($data['cnpj']) ? filter_var($data['cnpj'], FILTER_SANITIZE_STRING) : '';
$input_telephone = isset($data['telephone']) ? filter_var($data['telephone'], FILTER_SANITIZE_STRING) : '';
$input_email = isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_EMAIL) : '';
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
    response_format(405, "Apenas POST e PUT permitido.");
}
