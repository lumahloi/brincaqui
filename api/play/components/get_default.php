<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 0;

  $orderBy = $_GET['order_by'] ?? 'grade';
  $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'desc') ? 'DESC' : 'ASC';

  $orderMapping = [
    'grade' => 'brin_grade',
    'distance' => 'distance',
    'faves' => 'brin_faves',
    'visits' => 'brin_visits'
  ];

  $orderField = $orderMapping[$orderBy] ?? 'brin_grade';
  if ($orderBy === 'distance')
    $orderDir = 'ASC';

  $sql = "
    SELECT 
      b.brin_pictures, b.brin_name, b.brin_grade, e.add_city, e.add_neighborhood, b.brin_times, b.brin_commodities, b.brin_prices, b.brin_ages, b.brin_faves, b.brin_visits
    FROM Brinquedo b 
    JOIN Endereco e ON b.brin_id = e.Brinquedo_brin_id
    WHERE b.brin_active = '1'
    ORDER BY $orderField $orderDir;";

  $db = new Database();
  $results = $db->selectWithPagination($sql, [], $per_page, $page);

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

  response_format(200, "Sucesso", $results ?: []);

} catch (PDOException $e) {
  error_log("Erro no banco de dados: " . $e->getMessage());
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  error_log("Erro interno: " . $e->getMessage());
  response_format(500, "Erro interno: " . $e->getMessage());
}