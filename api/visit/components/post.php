<?php
require_once BASE_DIR . "/utils/db_functions.php";

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

$insert_visit = db_insert_into(
  'visita',
  ['Usuario_user_id', 'Brinquedo_brin_id', 'visit_date'],
  [$_SESSION['user_id'], $input_id, $date]
);

if (!$insert_visit) {
  response_format(400, "Não foi possível visitar este brinquedo, tente novamente.");
}

response_format(201, "Visita marcada com sucesso.");
