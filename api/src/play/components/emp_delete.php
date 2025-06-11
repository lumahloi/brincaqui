<?php
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/validate_infos.php";

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

check_ownership($_SESSION['user_id'], $input_id);

$delete = delete('endereco', ['Brinquedo_brin_id'], [$input_id]);
not_null_or_false($delete);

$delete = delete('brinquedo', ['brin_id'], [$input_id]);
not_null_or_false($delete);


response_format(200, "Brinquedo deletado com sucesso.");
