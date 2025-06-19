<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  if (!isset($_GET['latitude']) || !isset($_GET['longitude'])) {
    response_format(400, "Por favor, informe um endereço.");
  }

  $lat = floatval($_GET['latitude']);
  $lng = floatval($_GET['longitude']);

  if (
    $_GET['latitude'] === '' || $_GET['longitude'] === '' ||
    !is_numeric($_GET['latitude']) || !is_numeric($_GET['longitude'])
  ) {
    response_format(400, "Por favor, informe um endereço.");
  }

  $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

  $orderBy = $_GET['order_by'] ?? 'distance';

  $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

  $orderMapping = [
    'grade' => 'brin_grade',
    'distance' => 'distance',
    'faves' => 'brin_faves',
    'visits' => 'brin_visits',
    'price' => 'min_price'
  ];

  $orderField = $orderMapping[$orderBy] ?? 'brin_distance';

  if (!isset($_GET['order_dir'])) {
    $orderDir = 'DESC';
  }

  $distanceCalculation =
    "(6371 * ACOS(
      COS(RADIANS(:user_lat)) * COS(RADIANS(e.add_latitude)) * 
      COS(RADIANS(e.add_longitude) - RADIANS(:user_lng)) + 
      SIN(RADIANS(:user_lat)) * SIN(RADIANS(e.add_latitude))
      )
    )";

  $radius = isset($_GET['radius']) ? floatval($_GET['radius']) : 10;

  $whereClauses = [];

  $whereClauses[] = "b.brin_active = '1'";

  $whereClauses = ["f.Usuario_user_id = :user_id"];

  foreach (['commodities', 'discounts', 'ages'] as $jsonField) {
    if (isset($_GET[$jsonField])) {
      $column = "b.brin_$jsonField";
      $paramValues = $_GET[$jsonField];

      if (!is_array($paramValues)) {
        $values = array_map('trim', explode(',', $paramValues));
      } else {
        $values = array_map('trim', $paramValues);
      }

      $fieldClauses = [];
      foreach ($values as $i => $value) {
        $paramName = ":{$jsonField}_$i";
        $value = trim(str_replace('anos', '', $value));
        $fieldClauses[] = "$column LIKE $paramName";
        $sqlParams[$paramName] = '%' . $value . '%';
      }

      if (!empty($fieldClauses)) {
        $whereClauses[] = '(' . implode(' AND ', $fieldClauses) . ')';
      }
    }
  }

  $whereSql = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

  $sql = "
    SELECT
      b.brin_pictures, b.brin_id, b.brin_name, b.brin_grade, b.brin_times, b.brin_commodities, b.brin_prices, b.brin_faves, b.brin_visits, $distanceCalculation AS distance,

      -- Menor preço extraído de brin_prices
      CAST(
        JSON_UNQUOTE(
          JSON_EXTRACT(
            b.brin_prices,
            CONCAT(
              '$[',
              (
                SELECT idx FROM (
                  SELECT 
                    n.n AS idx,
                    JSON_UNQUOTE(JSON_EXTRACT(b.brin_prices, CONCAT('$[', n.n, '].prices_price'))) AS price
                  FROM (
                    SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION 
                          SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                  ) n
                  WHERE JSON_EXTRACT(b.brin_prices, CONCAT('$[', n.n, '].prices_price')) IS NOT NULL
                ) prices
                ORDER BY price + 0 ASC
                LIMIT 1
              ),
              '].prices_price'
            )
          )
        ) AS DECIMAL(10,2)
      ) AS min_price,

      -- Título relacionado ao menor preço
      JSON_UNQUOTE(
        JSON_EXTRACT(
          b.brin_prices,
          CONCAT(
            '$[',
            (
              SELECT idx FROM (
                SELECT 
                  n.n AS idx,
                  JSON_UNQUOTE(JSON_EXTRACT(b.brin_prices, CONCAT('$[', n.n, '].prices_price'))) AS price
                FROM (
                  SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION 
                        SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                ) n
                WHERE JSON_EXTRACT(b.brin_prices, CONCAT('$[', n.n, '].prices_price')) IS NOT NULL
              ) prices
              ORDER BY price + 0 ASC
              LIMIT 1
            ),
            '].prices_title'
          )
        )
      ) AS min_price_title,

      -- Total de favoritos do usuário
      (
        SELECT COUNT(*) 
        FROM brincaqui.favorito f2 
        WHERE f2.Usuario_user_id = f.Usuario_user_id
      ) AS total

    FROM 
      brincaqui.favorito f
      INNER JOIN brincaqui.brinquedo b ON f.Brinquedo_brin_id = b.brin_id
      INNER JOIN brincaqui.endereco e ON b.brin_id = e.Brinquedo_brin_id
    $whereSql
    ORDER BY 
      f.fav_date, $orderField $orderDir
    ";
      
  // HAVING distance <= :radius

  $sqlParams[':user_id'] = $_SESSION['user_id'];
  $sqlParams[':user_lat'] = $lat;
  $sqlParams[':user_lng'] = $lng;
  $sqlParams[':radius'] = $radius;

  $db = new Database();
  $results = $db->selectWithPagination($sql, $sqlParams, $per_page, $page);

  error_log("Resultados da query: " . print_r($results, true));

  if (isset($_GET['date']) && isset($_GET['time'])) {
    $date = DateTime::createFromFormat('Y-m-d', $_GET['date']);
    $time = DateTime::createFromFormat('H:i', $_GET['time']);

    if ($date && $time) {
      $daysWeek = [
        'Sunday' => 'domingo',
        'Monday' => 'segunda',
        'Tuesday' => 'terca',
        'Wednesday' => 'quarta',
        'Thursday' => 'quinta',
        'Friday' => 'sexta',
        'Saturday' => 'sabado'
      ];
      $dayWeek = $daysWeek[$date->format('l')];
      $selectedHour = $time->format('H:i');

      $filteredResults = [];
      foreach ($results as $row) {
        $hours = json_decode($row['brin_times'], true);

        if (!$hours || json_last_error() !== JSON_ERROR_NONE) {
          $filteredResults[] = $row;
          continue;
        }

        $openPlay = false;

        foreach ($hours as $dayHour) {
          if (isset($dayHour[$dayWeek])) {
            $hour = $dayHour[$dayWeek];
            if (strpos($hour, '-') !== false) {
              list($open, $close) = explode('-', $hour);
              if ($selectedHour >= trim($open) && $selectedHour <= trim($close)) {
                $openPlay = true;
                break;
              }
            }
          }
        }

        if ($openPlay || empty($hours)) {
          $filteredResults[] = $row;
        }
      }
      $results = $filteredResults;
    }
  }

  error_log("Resultados após filtro: " . print_r($results, true));

  response_format(200, "Sucesso", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
