<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission(2);

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "./components/register_post.php";
    break;

  default:
    response_format(405, "Apenas POST permitido.");
}
