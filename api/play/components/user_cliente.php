<?php
require_once BASE_DIR . "/utils/db_functions.php";

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

    $allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits'];

    $orderBy = $_GET['order_by'] ?? 'brin_name';
    if (!in_array($orderBy, $allowedOrderColumns)) {
      $orderBy = 'brin_name';
    }

    $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

    $filters = [];

    if (isset($_GET['commodities'])) {
      $filters['brin_commodities'] = $_GET['commodities'];
    }

    if (isset($_GET['discounts'])) {
      $filters['brin_discounts'] = $_GET['discounts'];
    }

    if (isset($_GET['ages'])) {
      $filters['brin_ages'] = $_GET['ages'];
    }

    if (isset($_GET['cep'])) {
      $filters['add_cep'] = $_GET['cep'];
    }

    if (isset($_GET['city'])) {
      $filters['add_city'] = $_GET['city'];
    }

    if (isset($_GET['neighborhood'])) {
      $filters['add_neighborhood'] = $_GET['neighborhood'];
    }

    $results = db_select_all_active_plays($per_page, $page, $orderBy, $orderDir, $filters);

    response_format(200, "Informações extraídas com sucesso.", $results);
    break;

  default:
    response_format(405, "Apenas GET permitido.");
}