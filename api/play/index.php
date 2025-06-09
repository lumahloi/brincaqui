<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
check_permission(2, $cookie);

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

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/validation.php";
    require_once "./components/post.php";
    break;

  case 'PUT':
    require_once "./components/validation.php";
    require_once "./components/put.php";
    break;

  case 'DELETE':
    require_once "./components/delete.php";
    break;

  case 'GET':
    require_once "./components/get.php";
    break;

  default:
    response_format(405, "Apenas POST e PUT permitido.");
}
