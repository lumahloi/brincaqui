<?php
require_once BASE_DIR . "/utils/db_functions.php";

$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;

$allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits'];

$orderBy = $_GET['order_by'] ?? 'brin_name';
if (!in_array($orderBy, $allowedOrderColumns)) {
    $orderBy = 'brin_name';
}

$orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

$filters = [];

if (isset($_GET['times'])) {
    $filters['brin_times'] = $_GET['times'];
}

if (isset($_GET['commodities'])) {
    $filters['brin_commodities'] = $_GET['commodities'];
}

if (isset($_GET['discounts'])) {
    $filters['brin_discounts'] = $_GET['discounts'];
}

if (isset($_GET['ages'])) {
    $filters['brin_ages'] = $_GET['ages'];
}

if (isset($_GET['active'])) {
    $filters['brin_active'] = $_GET['active'];
}

$results = db_select_plays($per_page, $page, $orderBy, $orderDir, $filters, $_SESSION['user_id']);

response_format(200, "Informações extraídas com sucesso.", $results);
