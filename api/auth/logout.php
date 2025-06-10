<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
require_once "./components/validation.php";

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    session_destroy();
    response_format(200, "Até mais!!");
    break;

  default:
    response_format(405, "Apenas POST permitido.");
}
