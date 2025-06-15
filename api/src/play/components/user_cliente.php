<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if (!isset($_GET['latitude']) || !isset($_GET['longitude'])) {
        response_format(400, "Por favor, informe um endereço.");
      }

      $lat = floatval($_GET['latitude']);
      $lng = floatval($_GET['longitude']);
      
      $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
      $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

      $allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits', 'distance'];
      $orderBy = $_GET['order_by'] ?? 'distance';

      $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';
      if ($orderBy === 'distance') {
        $orderDir = 'ASC';
      }

      if (!in_array("brin_$orderBy", $allowedOrderColumns) && $orderBy !== 'distance') {
        $orderBy = 'distance';
      }

      $orderBy = ($orderBy === 'distance') ? 'distance' : 'brin_' . $orderBy;

      $whereClauses = [];
      $sqlParams = [];
      
      $joinClause = 'JOIN Endereco e ON b.brin_id = e.Brinquedo_brin_id';
      
      $distanceCalculation = 
        "(6371 * ACOS(
          COS(RADIANS(:user_lat)) * COS(RADIANS(e.add_latitude)) * 
          COS(RADIANS(e.add_longitude) - RADIANS(:user_lng)) + 
          SIN(RADIANS(:user_lat)) * SIN(RADIANS(e.add_latitude))
        ))";
      
      $radius = isset($_GET['radius']) ? floatval($_GET['radius']) : 10;
      $whereClauses[] = "e.add_latitude IS NOT NULL AND e.add_longitude IS NOT NULL";
      
      $havingClause = "HAVING distance <= :radius";
      
      $sqlParams[':user_lat'] = $lat;
      $sqlParams[':user_lng'] = $lng;
      $sqlParams[':radius'] = $radius;

      foreach (['commodities', 'discounts', 'ages'] as $jsonField) {
        if (isset($_GET[$jsonField])) {
          $column = "b.brin_$jsonField";
          $values = array_map('trim', explode(',', $_GET[$jsonField]));

          $fieldClauses = [];
          foreach ($values as $i => $value) {
            $paramName = ":{$jsonField}_$i";
            $fieldClauses[] = "$column LIKE $paramName";
            $sqlParams[$paramName] = '%"' . $value . '"%';
          }

          if (!empty($fieldClauses)) {
            $whereClauses[] = '(' . implode(' AND ', $fieldClauses) . ')';
          }
        }
      }

      $whereSql = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';
      
      $sqlBase = "SELECT b.*, $distanceCalculation AS distance FROM Brinquedo b $joinClause $whereSql $havingClause ORDER BY $orderBy $orderDir";

      $db = new Database();
      $results = $db->selectWithPagination($sqlBase, $sqlParams, $per_page, $page);

      response_format(200, "Informações extraídas com sucesso.", $results);
      break;

    default:
      response_format(405, "Apenas GET permitido.");
  }
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}