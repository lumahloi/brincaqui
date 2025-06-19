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
  // $orderBy = 'brin_' . $orderBy;

  $orderBy = 'f.fav_date';
  $orderDir = (isset($_GET['order_dir']) && strtolower($_GET['order_dir']) === 'asc') ? 'ASC' : 'DESC';

  $filters = [];
  $whereClauses = ["f.Usuario_user_id = :user_id"];
  $filters[':user_id'] = $_SESSION['user_id'];

  // if (isset($_GET['commodities'])) {
  //   $whereClauses[] = "brin_commodities = :commodities";
  //   $filters[':commodities'] = $_GET['commodities'];
  // }

  // if (isset($_GET['discounts'])) {
  //   $whereClauses[] = "brin_discounts = :discounts";
  //   $filters[':discounts'] = $_GET['discounts'];
  // }

  // if (isset($_GET['ages'])) {
  //   $whereClauses[] = "brin_ages = :ages";
  //   $filters[':ages'] = $_GET['ages'];
  // }

  $whereSql = implode(" AND ", $whereClauses);
  $sql = "
    SELECT
      b.brin_id,
      b.brin_pictures,
      b.brin_grade,
      b.brin_commodities,
      b.brin_name,
      b.brin_faves,
      b.brin_visits,
      b.brin_prices,

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
