<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {
  $db = new Database();
  
  $query = "
    SELECT 
      b.*, 
      e.add_cep,
      e.add_streetnum,
      e.add_city,
      e.add_neighborhood,
      e.add_plus,
      e.add_state,
      e.add_country
    FROM brincaqui.brinquedo b
    LEFT JOIN brincaqui.endereco e ON b.brin_id = e.Brinquedo_brin_id
    WHERE b.brin_id = :brin_id
  ";

  $results = $db->selectWithPagination($query, ['brin_id' => $id], PHP_INT_MAX, 0);

  response_format(200, "Informações extraídas com sucesso.", $results);
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
