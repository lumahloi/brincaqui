<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([2]);
require_once BASE_DIR . "/utils/validate_infos.php";

check_cookie($cookie);

if (!isset($_GET['params'])) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

$params = explode(',', $_GET['params']);

if (empty($params)) {
  response_format(400, "Inclua pelo menos um atributo a ser alterado.");
}

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

foreach ($params as $param) {
  switch ($param) {
    case 'pictures':
      break;

    case 'socials':
      break;

    case 'description':
      break;

    case 'times':
      break;

    case 'commodities':
      break;

    case 'prices':
      break;

    case 'discounts':
      break;

    case 'telephone':
      break;

    case 'email':
      break;

    case 'name':
      break;

    case 'ages':
      break;

    default:
      response_format(405, "Tipo de parâmetro inválido.");
  }
}

response_format(200, "Atualização(s) feita com sucesso.");
