<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $db = new Database();

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y/m/d');

  $query = "SELECT visit_date FROM brincaqui.visita WHERE Usuario_user_id = :user_id AND Brinquedo_brin_id = :brin_id AND visit_date = :visit_date";

  $results = $db->selectWithPagination(
    $query,
    [
      ':user_id' => $_SESSION['user_id'],
      ':brin_id' => $id,
      ':visit_date' => $date
    ],
    PHP_INT_MAX,
    0
  );

  response_format(200, "Informações extraídas com sucesso.", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}