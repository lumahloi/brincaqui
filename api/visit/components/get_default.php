<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
  
  // $allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits'];
  
  // $orderBy = $_GET['order_by'] ?? 'name';
  // if (!in_array("brin_$orderBy", $allowedOrderColumns)) {
  //   $orderBy = 'name';
  // }
  // $orderBy = 'brin_'.$orderBy;

  $orderBy = "v.Brinquedo_brin_id";
  $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';
  
  $filters = [];
  $whereClauses = ["v.Usuario_user_id = :user_id"];
  $filters[':user_id'] = $_SESSION['user_id'];
  
  // if (isset($_GET['commodities'])) {
  //   $filters['brin_commodities'] = $_GET['commodities'];
  // }
  
  // if (isset($_GET['discounts'])) {
  //   $filters['brin_discounts'] = $_GET['discounts'];
  // }
  
  // if (isset($_GET['ages'])) {
  //   $filters['brin_ages'] = $_GET['ages'];
  // }
  
  $whereSql = implode(" AND ", $whereClauses);
  $sql = "
    SELECT 
      v.*, 
      b.*, 
      e.*
    FROM 
      brincaqui.visita v
      INNER JOIN brincaqui.brinquedo b ON v.Brinquedo_brin_id = b.brin_id
      INNER JOIN brincaqui.endereco e ON b.brin_id = e.Brinquedo_brin_id
    WHERE 
      $whereSql
    ORDER BY 
      $orderBy $orderDir
  ";
  
  $db = new Database();
  $results = $db->selectWithPagination($sql, $filters, $per_page, $page);
  
  response_format(200, "Informações extraídas com sucesso.", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
