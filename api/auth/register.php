<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

$data = json_decode(file_get_contents("php://input"), true);

$input_fullname = null;
$input_user_type = null;
$input_email = null;
$input_telephone = null;
$input_password = null;
$input_confirm_password = null;
$cookie = trim($_COOKIE['PHPSESSID'] ?? '');
$input_old_password = null;

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/validation.php";
    if (isset($data['email'])) {
      $input_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
      valid_email($input_email, 1);
    }
    require_once "./components/register_post.php";
    break;

  case 'PUT':
    require_once "./components/validation.php";
    if (isset($data['email'])) {
      $input_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
      valid_email($input_email);
    }
    require_once "./components/register_put.php";
    break;

  case 'DELETE':
    require_once "./components/validation.php";
    require_once "./components/register_delete.php";
    break;

  default:
    response_format(405, "Apenas POST, PUT e DELETE permitidos.");
}
