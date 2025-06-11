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

$insert_visit = insertInto(
  'visita',
  ['Usuario_user_id', 'Brinquedo_brin_id', 'visit_date'],
  [$_SESSION['user_id'], $input_id, $date]
);

not_null_or_false($insert_visit);

$update_visits = update(
  'brinquedo',
  ['brin_visits'],
  [db_get_total_visits_from_play($input_id)],
  ['brin_id'],
  [$input_id],
);

not_null_or_false($update_visits);

response_format(201, "Visita marcada com sucesso.");
