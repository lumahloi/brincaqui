<?php
require_once BASE_DIR . "/utils/validate_infos.php";

$allowed_grade_values = ['péssimo','ruim','bom','muito bom','excelente'];

if (isset($data['description'])) {
  $input_description = filter_var($data['description'], FILTER_SANITIZE_STRING);
  valid_description($input_description);
}

if (isset($input_g1) && in_array(mb_strtolower($input_g1), array_map('mb_strtolower', $allowedValues))) {
  $input_g1 = filter_var($data['grade_1'], FILTER_SANITIZE_STRING);
}

if (isset($input_g2) && in_array(mb_strtolower($input_g2), array_map('mb_strtolower', $allowedValues))) {
  $input_g2 = filter_var($data['grade_2'], FILTER_SANITIZE_STRING);
}

if (isset($input_g3) && in_array(mb_strtolower($input_g3), array_map('mb_strtolower', $allowedValues))) {
  $input_g3 = filter_var($data['grade_3'], FILTER_SANITIZE_STRING);
}

if (isset($input_g4) && in_array(mb_strtolower($input_g4), array_map('mb_strtolower', $allowedValues))) {
  $input_g4 = filter_var($data['grade_4'], FILTER_SANITIZE_STRING);
}

if (isset($input_g5) && in_array(mb_strtolower($input_g5), array_map('mb_strtolower', $allowedValues))) {
  $input_g5 = filter_var($data['grade_5'], FILTER_SANITIZE_STRING);
}

if (isset($input_g6) && in_array(mb_strtolower($input_g6), array_map('mb_strtolower', $allowedValues))) {
  $input_g6 = filter_var($data['grade_6'], FILTER_SANITIZE_STRING);
}