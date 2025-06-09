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
$cookie = null;

require_once "./components/validation.php";

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/register_post.php";
    break;

  case 'PUT':
    require_once "./components/register_put.php";
    break;

  case 'DELETE':
    require_once "./components/register_delete.php";
    break;

  default:
    response_format(405, "Apenas POST, PUT e DELETE permitido.");
}
