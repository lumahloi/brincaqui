<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {

  $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
  
  $allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits'];
  
  $orderBy = $_GET['order_by'] ?? 'name';
  if (!in_array("brin_$orderBy", $allowedOrderColumns)) {
    $orderBy = 'name';
  }
  $orderBy = 'brin_' . $orderBy;
  
  $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';
  
  $filters = [];
  $whereClauses = ["Usuario_user_id = :user_id"];
  $filters[':user_id'] = $_SESSION['user_id'];
  
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
  
  if (isset($_GET['cep'])) {
    $filters['add_cep'] = $_GET['cep'];
  }
  
  if (isset($_GET['city'])) {
    $filters['add_city'] = $_GET['city'];
  }
  
  if (isset($_GET['neighborhood'])) {
    $filters['add_neighborhood'] = $_GET['neighborhood'];
  }
  
  if (isset($_GET['state'])) {
    $filters['add_state'] = $_GET['state'];
  }
  
  if (isset($_GET['country'])) {
    $filters['add_country'] = $_GET['country'];
  }
  
  $whereSql = implode(" AND ", $whereClauses);
  $sql = "SELECT * FROM brincaqui.brinquedo WHERE $whereSql ORDER BY $orderBy $orderDir";
  
  $db = new Database();
  $results = $db->selectWithPagination($sql, $filters, $per_page, $page);
  
  response_format(200, "Informações extraídas com sucesso.", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
