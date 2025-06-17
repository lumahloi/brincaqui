<?php

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = $_SERVER['QUERY_STRING'] ?? '';

$path = trim($requestUri, '/');
$parts = explode('/', $path);

if ($parts[1] === 'favorite') {
  if (count($parts) === 3 && is_numeric($parts[2])) {
    $id = (int) $parts[2];
    require_once 'components/get_by_id.php';
  }

  require_once 'components/get_default.php';
}