<?php
require_once "../base_dir.php";
// require_once BASE_DIR . "/utils/db_connection.php";

function db_select_where(array $selectedColumns, string $table, array $columns, array $values)
{
  $pdo = DbConnection::connect();

  $conditions = [];
  foreach ($columns as $col) {
    $conditions[] = "$col = :$col";
  }
  $whereClause = implode(" AND ", $conditions);

  $selectedTemp = [];
  foreach ($selectedColumns as $col) {
    $selectedTemp[] = "$col";
  }
  $selectClause = implode(",", $selectedTemp);

  $sql = "SELECT $selectClause FROM brincaqui.$table WHERE $whereClause;";
  $stmt = $pdo->prepare($sql);

  foreach ($columns as $col) {
    if (!array_key_exists($col, $values)) {
      throw new Exception("Faltando valor para a coluna '$col'");
    }
    $stmt->bindValue(":$col", $values[$col], PDO::PARAM_STR);
  }

  $stmt->execute();

  return $stmt->fetch(PDO::FETCH_ASSOC);
}