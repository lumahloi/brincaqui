<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

$data = json_decode(file_get_contents("php://input"), true);
$input_fullname = filter_var($data['fullname']) ?? '';
$input_email = filter_var($data['email']) ?? '';
$input_telephone = filter_var($data['telephone']) ?? '';
$input_password = filter_var($data['password']) ?? '';
$input_confirm_password = filter_var($data['confirmPassword']) ?? '';
$input_user_type = filter_var($data['userType']) ?? '';

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
