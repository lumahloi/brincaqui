<?php
require_once BASE_DIR . "/utils/db_functions.php";


$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;

$allowedOrderColumns = ['grade_1', 'date'];

$orderBy = $_GET['order_by'] ?? 'date';
if (!in_array("$orderBy", $allowedOrderColumns)) {
  $orderBy = 'date';
}
$orderBy = 'aval_' . $orderBy;

$orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

$whereClauses = ["Brinquedo_brin_id = :brin_id"];
$filters[':brin_id'] = $input_id;

$whereSql = implode(" AND ", $whereClauses);

$sql = "SELECT * FROM brincaqui.feedback WHERE $whereSql ORDER BY $orderBy $orderDir";

$db = new Database();
$results = $db->selectWithPagination($sql, $filters, $per_page, $page);

response_format(200, "Informações extraídas com sucesso.", $results);

