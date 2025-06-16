<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/validate_infos.php";

$db = new Database();
$info = $db->selectWhere(
  ['com_title'],
  'comodidade',
  ['com_id'],
  [$com_id]
);

not_null_or_false($info);

$return = $info;

response_format(200, "Informações extraídas com sucesso.", $return);
