<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

$data = json_decode(file_get_contents('php://input'), true);

$input_description = null;
$input_name = null;
$input_cnpj = null;
$input_telephone = null;
$input_email = null;
$input_pictures = null;
$input_socials = null;
$input_prices = null;
$input_times = null;
$input_commodities = null;
$input_discounts = null;
$input_ages = null;

$input_cep = null;
$input_streetnum = null;
$input_city = null;
$input_neighborhood = null;
$input_plus = null;
$input_state = null;
$input_country = null;

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[2] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "validation.php";
    require_once "emp_post.php";
    break;

  case 'PUT':
    require_once "validation.php";
    require_once "emp_put.php";
    break;

  case 'DELETE':
    require_once "emp_delete.php";
    break;

  default:
    response_format(405, "POST, PUT, DELETE e GET permitidos.");
}
