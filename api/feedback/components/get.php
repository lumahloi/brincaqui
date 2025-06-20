<?php
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/db_connection.php";

try {
  $uri = $_SERVER['REQUEST_URI'];
  $uri_parts = explode('/', trim($uri, '/'));

  $avaliacao_id = isset($_GET['avaliacao']) ? intval($_GET['avaliacao']) : null;

  if ($avaliacao_id) {
    $selectedColumns = [
      "a.aval_id",
      "a.aval_description",
      "a.aval_date",
      "a.aval_grade_1",
      "a.aval_grade_2",
      "a.aval_grade_3",
      "a.aval_grade_4",
      "a.aval_grade_5",
      "a.aval_grade_6",
      "a.aval_grade_7",
      "u.user_id",
      "u.user_name",
      "b.brin_id"
    ];

    $sql = "
      SELECT " . implode(", ", $selectedColumns) . "
      FROM brincaqui.avaliacao a
      JOIN brincaqui.usuario u ON a.Usuario_user_id = u.user_id
      JOIN brincaqui.brinquedo b ON a.Brinquedo_brin_id = b.brin_id
      WHERE a.aval_id = :aval_id
      LIMIT 1
    ";

    $pdo = DbConnection::connect();
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':aval_id', $avaliacao_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      response_format(200, "Avaliação encontrada.", $result);
    } else {
      response_format(404, "Avaliação não encontrada.");
    }

    exit;
  }

  $input_id = $uri_parts[2] ?? null;
  if (!$input_id) {
    response_format(400, "ID do brinquedo não especificado.");
  }

  $db = new Database();
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
      u.user_name,
      b.brin_name
    FROM brincaqui.avaliacao a
    JOIN brincaqui.usuario u ON a.Usuario_user_id = u.user_id
    JOIN brincaqui.brinquedo b ON a.Brinquedo_brin_id = b.brin_id
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

  $results = $db->selectWithPagination($sql, $filters, $per_page, $page);

  $pdo = DbConnection::connect();
  $countStmt = $pdo->prepare("
    SELECT COUNT(*) as total
    FROM brincaqui.avaliacao
    WHERE Brinquedo_brin_id = :brin_id
  ");
  $countStmt->bindValue(':brin_id', $input_id, PDO::PARAM_INT);
  $countStmt->execute();
  $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

  response_format(200, "Informações extraídas com sucesso.", [
    "total_avaliacoes" => intval($totalCount),
    "avaliacoes" => $results
  ]);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
