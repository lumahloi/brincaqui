<?php
require_once BASE_DIR . "/utils/db_functions.php";

$data = json_decode(file_get_contents('php://input'), true);

$input_description = null;
$input_g1 = null;
$input_g2 = null;
$input_g3 = null;
$input_g4 = null;
$input_g5 = null;
$input_g6 = null;
$input_g7 = null;

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');


require_once "validation.php";
$insert_fb = db_insert_into(
  'avaliacao',
  ['Usuario_user_id', 'Brinquedo_brin_id', 'aval_description', 'aval_date', 'aval_grade_1', 'aval_grade_2', 'aval_grade_3', 'aval_grade_4', 'aval_grade_5', 'aval_grade_6'],
  [$_SESSION['user_id'], $input_id, $input_description, $date, $input_g1, $input_g2, $input_g3, $input_g4, $input_g5, $input_g6]
);

if ($insert_fb === false || $insert_fb === null) {
  response_format(400, "Não foi possível avaliar este brinquedo, revise seus dados e tente novamente.");
}

$insert_grade = db_update(
  'brinquedo',
  ['brin_grade'],
  [db_get_avg_from_play($input_id)],
  ['brin_id'],
  [$input_id]
);

if ($insert_grade === false || $insert_fb === null) {
  response_format(400, "Não foi possível avaliar este brinquedo, revise seus dados e tente novamente.");
}

response_format(201, "Brinquedo avaliado com sucesso.");

