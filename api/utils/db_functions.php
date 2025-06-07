<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";

function db_select_where(array $selectedColumns, string $table, array $columns, array $values)
{
  $pdo = DbConnection::connect();

  if (count($columns) !== count($values)) {
    throw new Exception("Número de colunas e valores não corresponde.");
  }

  $conditions = [];
  foreach ($columns as $col) {
    $conditions[] = "$col = :$col";
  }
  $whereClause = implode(" AND ", $conditions);

  $selectClause = implode(", ", $selectedColumns);
  $sql = "SELECT $selectClause FROM brincaqui.$table WHERE $whereClause;";
  $stmt = $pdo->prepare($sql);

  foreach ($columns as $index => $col) {
    $stmt->bindValue(":$col", $values[$index], PDO::PARAM_STR);
  }

  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function db_insert_into(string $table, array $columns, array $values)
{
  $pdo = DbConnection::connect();

  if (count($columns) !== count($values)) {
    throw new Exception("Número de colunas e valores não corresponde.");
  }

  $columnsClause = implode(",", $columns);
  $placeholders = array_map(fn($col) => ":$col", $columns);
  $valuesClause = implode(",", $placeholders);

  $sql = "INSERT INTO brincaqui.$table ($columnsClause) VALUES ($valuesClause);";
  $stmt = $pdo->prepare($sql);

  foreach ($columns as $index => $col) {
    $stmt->bindValue(":$col", $values[$index], PDO::PARAM_STR);
  }

  return $stmt->execute();
}

function db_update(string $table, array $columnsSet, array $valuesSet, array $whereColumns, $whereValues)
{
  $pdo = DbConnection::connect();

  if (count($columnsSet) !== count($valuesSet)) {
    throw new Exception("Número de colunas e valores do SET não corresponde.");
  }
  if (!is_array($whereValues)) {
    $whereValues = [$whereValues]; // Permitir valor único
  }
  if (count($whereColumns) !== count($whereValues)) {
    throw new Exception("Número de colunas e valores do WHERE não corresponde.");
  }

  $setParts = [];
  foreach ($columnsSet as $col) {
    $setParts[] = "$col = :set_$col";
  }
  $setClause = implode(", ", $setParts);

  $whereParts = [];
  foreach ($whereColumns as $col) {
    $whereParts[] = "$col = :where_$col";
  }
  $whereClause = implode(" AND ", $whereParts);

  $sql = "UPDATE brincaqui.$table SET $setClause WHERE $whereClause;";
  $stmt = $pdo->prepare($sql);

  foreach ($columnsSet as $index => $col) {
    $stmt->bindValue(":set_$col", $valuesSet[$index], PDO::PARAM_STR);
  }
  foreach ($whereColumns as $index => $col) {
    $stmt->bindValue(":where_$col", $whereValues[$index], PDO::PARAM_STR);
  }

  return $stmt->execute();
}
