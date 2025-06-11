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

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

require_once "validation.php";

$db = new Database();

$insert_fb = $db->insertInto(
  'avaliacao',
  ['Usuario_user_id', 'Brinquedo_brin_id', 'aval_description', 'aval_date', 'aval_grade_1', 'aval_grade_2', 'aval_grade_3', 'aval_grade_4', 'aval_grade_5', 'aval_grade_6'],
  [$_SESSION['user_id'], $input_id, $input_description, $date, $input_g1, $input_g2, $input_g3, $input_g4, $input_g5, $input_g6]
);

not_null_or_false($insert_fb);

$insert_grade = $db->update(
  'brinquedo',
  ['brin_grade'],
  [$db->getColumnAverage(
    'avaliacao',
    'aval_grade_1',
    'Brinquedo_brin_id',
    $input_id
    )],
  ['brin_id'],
  [$input_id]
);

not_null_or_false($insert_grade);

response_format(201, "Brinquedo avaliado com sucesso.");

