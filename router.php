<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (preg_match('#^/api(/|$)#', $uri)) {
    return false;
}

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

require_once __DIR__ . '/base_dir.php';

$path = $uri;

if (preg_match('#^/lugar/[\w\-]+$#', $path)) {
    require BASE_DIR . '/pages/brinquedo.php';
    exit;
}

if (preg_match('#^/avaliar/[\w\-]+$#', $path)) {
    require BASE_DIR . '/pages/avaliar.php';
    exit;
}

if (preg_match('#^/avaliacao/[\w\-]+$#', $path)) {
    require BASE_DIR . '/pages/avaliacao.php';
    exit;
}

if (preg_match('#^/avaliacoes/[\w\-]+$#', $path)) {
    require BASE_DIR . '/pages/avaliacoes.php';
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
