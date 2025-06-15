<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
      $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

      $allowedOrderColumns = ['brin_name', 'brin_grade', 'brin_faves', 'brin_visits'];
      $orderBy = $_GET['order_by'] ?? 'name';

      if (!in_array("brin_$orderBy", $allowedOrderColumns)) {
        $orderBy = 'name';
      }

      $orderBy = 'brin_' . $orderBy;
      $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

      $whereClauses = [];
      $sqlParams = [];

      foreach (['commodities', 'discounts', 'ages'] as $jsonField) {
        if (isset($_GET[$jsonField])) {
          $column = "brin_$jsonField";
          $values = array_map('trim', explode(',', $_GET[$jsonField]));

          $fieldClauses = [];
          foreach ($values as $i => $value) {
            $paramName = ":{$column}_$i";
            $fieldClauses[] = "$column LIKE $paramName";
            $sqlParams[$paramName] = '%"' . $value . '"%';
          }

          if (!empty($fieldClauses)) {
            $whereClauses[] = '(' . implode(' AND ', $fieldClauses) . ')';
          }
        }
      }

      $simpleFilters = [
        'cep' => 'add_cep',
        'city' => 'add_city',
        'neighborhood' => 'add_neighborhood',
        'state' => 'add_state',
        'country' => 'add_country'
      ];

      foreach ($simpleFilters as $param => $column) {
        if (isset($_GET[$param])) {
          $paramName = ":$column";
          $whereClauses[] = "$column = $paramName";
          $sqlParams[$paramName] = $_GET[$param];
        }
      }

      $whereSql = '';
      if (!empty($whereClauses)) {
        $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
      }

      $sql = "SELECT * FROM brincaqui.brinquedo $whereSql ORDER BY $orderBy $orderDir";

      $db = new Database();
      $results = $db->selectWithPagination($sql, $sqlParams, $per_page, $page);

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
