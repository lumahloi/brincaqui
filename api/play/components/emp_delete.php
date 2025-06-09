<?php
require_once BASE_DIR . "/utils/db_functions.php";
require_once "./utils/validate_infos.php";

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

check_ownership($_SESSION['user_id'], $input_id);

if (!db_delete('brinquedo', ['brin_id'], [$input_id])) {
  response_format(400, "Não foi possível deletar o brinquedo, revise seus dados e tente novamente.");
}

if (!db_delete('endereco', ['Brinquedo_brin_id'], [$input_id])) {
  response_format(400, "Não foi possível deletar o brinquedo, revise seus dados e tente novamente.");
}

response_format(200, "Brinquedo deletado com sucesso.");
