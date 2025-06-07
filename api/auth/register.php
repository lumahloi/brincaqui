<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

$data = json_decode(file_get_contents("php://input"), true);

$input_email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
$input_telephone = filter_var($data['telephone'] ?? '', FILTER_SANITIZE_STRING);
$input_password = filter_var($data['password'] ?? '', FILTER_SANITIZE_STRING);
$input_confirm_password = filter_var($data['confirmPassword'] ?? '', FILTER_SANITIZE_STRING);

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    $input_fullname = filter_var($data['fullname'] ?? '', FILTER_SANITIZE_STRING);
    $input_user_type = filter_var($data['userType'] ?? '', FILTER_SANITIZE_STRING);
    require_once "./components/register_post.php";
    break;

  case 'PUT':
    require_once "./components/register_put.php";
    break;

  default:
    response_format(405, "Apenas POST e PUT permitido.");
}
