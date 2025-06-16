<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

require_once __DIR__ . '/base_dir.php';

$path = $uri;

if (preg_match('#^/lugar/[\w\-]+$#', $path)) {
    require BASE_DIR . '/pages/brinquedo.php';
    exit;
}

if ($path === '/' || $path === '') {
    $path = '/index';
}

$file = BASE_DIR . '/pages' . $path . '.php';

if (file_exists($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "Página não encontrada.";
}
