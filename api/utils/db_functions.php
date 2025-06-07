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

  $sql = "SELECT ($selectClause) FROM brincaqui.$table WHERE $whereClause;";
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

function db_insert_into(string $table, array $columns, array $values)
{
  $pdo = DbConnection::connect();

  $temp = [];
  foreach ($columns as $col) {
    $temp[] = "$col";
  }
  $columnsClause = implode(",", $temp);

  $temp = [];
  foreach ($values as $col) {
    $temp[] = ":$col";
  }
  $valuesClause = implode(",", $temp);

  $sql = "INSERT INTO brincaqui.$table ($columnsClause) VALUES ($valuesClause)";
  $stmt = $pdo->prepare($sql);

  foreach ($columns as $col) {
    if (!array_key_exists($col, $values)) {
      throw new Exception("Faltando valor para a coluna '$col'");
    }
    $stmt->bindValue(":$col", $values[$col], PDO::PARAM_STR);
  }

  return $stmt->execute();
}

function db_update($table, array $columnsSet, array $valuesSet, $whereColumn, $whereValue)
{
  $pdo = DbConnection::connect();

  if (count($columnsSet) !== count($valuesSet)) {
    throw new Exception("Número de colunas e valores não corresponde.");
  }

  $setParts = [];
  foreach ($columnsSet as $col) {
    $setParts[] = "$col = :$col";
  }
  $setClause = implode(", ", $setParts);

  $sql = "UPDATE $table SET $setClause WHERE $whereColumn = :where_param;";
  $stmt = $pdo->prepare($sql);

  foreach ($columnsSet as $index => $col) {
    $stmt->bindValue(":$col", $valuesSet[$index], PDO::PARAM_STR);
  }

  $stmt->bindValue(":where_param", $whereValue, PDO::PARAM_STR);

  return $stmt->execute();
}
