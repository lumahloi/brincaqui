<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $uri = $_SERVER['REQUEST_URI'];
  $uri_parts = explode('/', trim($uri, '/'));
  $input_id = $uri_parts[2] ?? null;
  
  if (!$input_id) {
    response_format(400, "ID do brinquedo não especificado.");
  }
  
  $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
  
  $whereClauses = ["Brinquedo_brin_id = :brin_id"];
  $filters[':brin_id'] = $input_id;
  
  $whereSql = implode(" AND ", $whereClauses);
  
  $sql = "
    SELECT
      a.aval_id,
      a.aval_description,
      a.aval_date,
      a.aval_grade_1,
      a.aval_grade_2,
      a.aval_grade_3,
      a.aval_grade_4,
      a.aval_grade_5,
      a.aval_grade_6,
      a.aval_grade_7,
      u.user_name
    FROM brincaqui.avaliacao a
    JOIN brincaqui.usuario u ON a.Usuario_user_id = u.user_id
    WHERE $whereSql
    ORDER BY 
      CASE 
        WHEN a.Usuario_user_id = :usuario_id THEN 0
        ELSE 1
      END,
      a.aval_grade_1,
      a.aval_date DESC
  ";

  $filters[':usuario_id'] = $_SESSION['user_id'];
  
  $db = new Database();
  $results = $db->selectWithPagination($sql, $filters, $per_page, $page);
  
  response_format(200, "Informações extraídas com sucesso.", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
