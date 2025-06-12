<?php
require_once BASE_DIR . "/utils/validate_infos.php";

if (isset($data['description'])) {
  $input_description = filter_var($data['description'], FILTER_SANITIZE_STRING);
  valid_characters(10, 200, $input_description, 'Descrição');
}

if (isset($data['grade_1'])) {
  $input_g1 = filter_var($data['grade_1'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_2'])) {
  $input_g2 = filter_var($data['grade_2'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_3'])) {
  $input_g3 = filter_var($data['grade_3'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_4'])) {
  $input_g4 = filter_var($data['grade_4'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_5'])) {
  $input_g5 = filter_var($data['grade_5'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_6'])) {
  $input_g6 = filter_var($data['grade_6'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

if (isset($data['grade_7'])) {
  $input_g7 = filter_var($data['grade_7'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}
