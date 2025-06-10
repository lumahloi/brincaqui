<?php
require_once BASE_DIR . "/utils/db_functions.php";


$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;

$results = db_select_fb_from_play($per_page, $page, $input_id);

response_format(200, "Informações extraídas com sucesso.", $results);

