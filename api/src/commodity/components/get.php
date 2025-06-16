<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/validate_infos.php";

$db = new Database();
$sqlParams = [];
$sqlParams[':com_active'] = 1;
$info = $db->selectWithPagination(
  "SELECT com_id, com_title from brincaqui.comodidade WHERE com_active = :com_active",
  $sqlParams,
  PHP_INT_MAX,
  0
);

not_null_or_false($info);

$return = $info;
response_format(200, "Informações extraídas com sucesso.", $return);
