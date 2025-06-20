<?php
session_start();
require_once __DIR__ . '/../base_dir.php';
require_once BASE_DIR . "/utils/response_format.php";
$cookie = trim($_COOKIE['PHPSESSID'] ?? '');
require_once BASE_DIR . "/utils/permission.php";

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $queryString = $_SERVER['QUERY_STRING'] ?? '';

    $path = trim($requestUri, '/');
    $parts = explode('/', $path);

    if ($parts[1] === 'play') {
      if (count($parts) === 1 && isset($_GET['owner'])) {
        require_once 'components/emp_get.php';
        exit;
      }

      if (count($parts) === 3 && is_numeric($parts[2])) {
        $id = (int) $parts[2];
        require_once 'components/get_by_id.php';
      }

      require_once 'components/get_default.php';
    }
    break;

  default:
    if (isset($_SESSION['user_type'])) {
      check_permission([2, 3], $cookie);
      require_once "./components/user_empresa.php";
    }
    break;
}
