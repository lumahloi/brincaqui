<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {

  $data = json_decode(file_get_contents('php://input'), true);

  $input_description = null;
  $input_g2 = null;
  $input_g3 = null;
  $input_g4 = null;
  $input_g5 = null;
  $input_g6 = null;
  $input_g7 = null;

  $uri = $_SERVER['REQUEST_URI'];
  $uri_parts = explode('/', trim($uri, '/'));
  $input_id = $uri_parts[2] ?? null;

  if (!$input_id) {
    response_format(400, "ID do brinquedo não especificado.");
  }

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y/m/d');

  require_once "validation.php";

  $db = new Database();

  $grades = [$input_g2, $input_g3, $input_g4, $input_g5, $input_g6, $input_g7];
  $grades_numeric = array_filter($grades, fn($v) => is_numeric($v));
  $calculated_g1 = count($grades_numeric) ? round(array_sum($grades_numeric) / count($grades_numeric), 1) : null;

  $insert_fb = $db->update(
    'avaliacao',
    ['aval_description', 'aval_date', 'aval_grade_1', 'aval_grade_2', 'aval_grade_3', 'aval_grade_4', 'aval_grade_5', 'aval_grade_6', 'aval_grade_7'],
    [$input_description, $date, $calculated_g1, $input_g2, $input_g3, $input_g4, $input_g5, $input_g6, $input_g7],
    ['Usuario_user_id', 'Brinquedo_brin_id'],
    [$_SESSION['user_id'], $input_id]
  );

  not_null_or_false($insert_fb);

  $average_g1 = $db->getColumnAverage('avaliacao', 'aval_grade_1', 'Brinquedo_brin_id', $input_id);
  $average_g2 = $db->getColumnAverage('avaliacao', 'aval_grade_2', 'Brinquedo_brin_id', $input_id);
  $average_g3 = $db->getColumnAverage('avaliacao', 'aval_grade_3', 'Brinquedo_brin_id', $input_id);
  $average_g4 = $db->getColumnAverage('avaliacao', 'aval_grade_4', 'Brinquedo_brin_id', $input_id);
  $average_g5 = $db->getColumnAverage('avaliacao', 'aval_grade_5', 'Brinquedo_brin_id', $input_id);
  $average_g6 = $db->getColumnAverage('avaliacao', 'aval_grade_6', 'Brinquedo_brin_id', $input_id);
  $average_g7 = $db->getColumnAverage('avaliacao', 'aval_grade_7', 'Brinquedo_brin_id', $input_id);

  $update_success = $db->update(
    'brinquedo',
    [
      'brin_grade',
      'brin_grade_2',
      'brin_grade_3',
      'brin_grade_4',
      'brin_grade_5',
      'brin_grade_6',
      'brin_grade_7',
    ],
    [
      $average_g1,
      $average_g2,
      $average_g3,
      $average_g4,
      $average_g5,
      $average_g6,
      $average_g7,
    ],
    ['brin_id'],
    [$input_id]
  );

  not_null_or_false($update_success);

  not_null_or_false($insert_grade);

  response_format(201, "Avaliação atualizada com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
