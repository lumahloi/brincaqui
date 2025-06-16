<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
$cookie = filter_var($_COOKIE['PHPSESSID'] ?? '', FILTER_SANITIZE_STRING);
require_once BASE_DIR . "/utils/permission.php";

if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 2){
  check_permission([2,3], $cookie);
  require_once "./components/user_empresa.php";
}

require_once "./components/user_cliente.php";