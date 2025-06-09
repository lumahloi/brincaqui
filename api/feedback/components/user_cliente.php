<?php
require_once BASE_DIR . "/utils/db_functions.php";

$data = json_decode(file_get_contents('php://input'), true);

$input_description=null;
$input_g1=null;
$input_g2=null;
$input_g3=null;
$input_g4=null;
$input_g5=null;
$input_g6=null;

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    require_once "validation.php";
    $insert_fb = db_insert_into(
      'avaliacao',
    ['Usuario_user_id', 'Brinquedo_brin_id', 'aval_description', 'aval_date', 'aval_grade_1', 'aval_grade_2', 'aval_grade_3', 'aval_grade_4', 'aval_grade_5', 'aval_grade_6'],
    [$_SESSION['user_id'], $input_id, $input_description, $date, $input_g1, $input_g2, $input_g3, $input_g4, $input_g5, $input_g6]
    );
    break;

  default:
    response_format(405, "Apenas POST permitido.");
}