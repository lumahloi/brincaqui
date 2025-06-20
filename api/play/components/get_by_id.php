<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $db = new Database();

  $query = "
    SELECT 
      b.*, 
      e.*
    FROM brincaqui.brinquedo b
    LEFT JOIN brincaqui.endereco e ON b.brin_id = e.Brinquedo_brin_id
    WHERE b.brin_id = :brin_id
  ";

  $results = $db->selectWithPagination($query, ['brin_id' => $id], PHP_INT_MAX, 0);

  $pdo = DbConnection::connect();
  $countStmt = $pdo->prepare("
    SELECT COUNT(*) as total
    FROM brincaqui.avaliacao
    WHERE Brinquedo_brin_id = :brin_id
  ");
  $countStmt->bindValue(':brin_id', $id, PDO::PARAM_INT);
  $countStmt->execute();
  $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

  response_format(200, "Informações extraídas com sucesso.", [
    "total_avaliacoes" => intval($totalCount),
    "brinquedo" => $results
  ]);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
