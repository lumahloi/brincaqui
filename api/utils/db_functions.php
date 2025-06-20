<?php
require_once "db_connection.php";

class Database
{
  private PDO $pdo;

  public function __construct()
  {
    try {
      $this->pdo = DbConnection::connect();
    } catch (PDOException $e) {
      throw new PDOException("Falha ao conectar ao banco de dados: " . $e->getMessage());
    }
  }

  public function selectWhere(array $selectedColumns, string $table, array $columns, array $values): array|false
  {
    if (count($columns) !== count($values)) {
      throw new Exception("Número de colunas e valores não corresponde.");
    }

    $conditions = array_map(fn($col) => "$col = :$col", $columns);
    $sql = "SELECT " . implode(", ", $selectedColumns) . " FROM brincaqui.$table WHERE " . implode(" AND ", $conditions);
    $stmt = $this->pdo->prepare($sql);

    foreach ($columns as $i => $col) {
      $stmt->bindValue(":$col", $values[$i], PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insertInto(string $table, array $columns, array $values): int|false
  {
    if (count($columns) !== count($values)) {
      throw new Exception("Número de colunas e valores não corresponde.");
    }

    $placeholders = array_map(fn($col) => ":$col", $columns);
    $sql = "INSERT INTO brincaqui.$table (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $this->pdo->prepare($sql);

    foreach ($columns as $i => $col) {
      $stmt->bindValue(":$col", $values[$i], PDO::PARAM_STR);
    }

    return $stmt->execute() ? $this->pdo->lastInsertId() : false;
  }

  public function update(string $table, array $columnsSet, array $valuesSet, array $whereColumns, array|string $whereValues): bool
  {
    if (count($columnsSet) !== count($valuesSet)) {
      throw new Exception("Número de colunas e valores do SET não corresponde.");
    }

    $whereValues = is_array($whereValues) ? $whereValues : [$whereValues];

    if (count($whereColumns) !== count($whereValues)) {
      throw new Exception("Número de colunas e valores do WHERE não corresponde.");
    }

    $setClause = implode(", ", array_map(fn($col) => "$col = :set_$col", $columnsSet));
    $whereClause = implode(" AND ", array_map(fn($col) => "$col = :where_$col", $whereColumns));

    $sql = "UPDATE brincaqui.$table SET $setClause WHERE $whereClause";
    $stmt = $this->pdo->prepare($sql);

    foreach ($columnsSet as $i => $col) {
      $stmt->bindValue(":set_$col", $valuesSet[$i], PDO::PARAM_STR);
    }

    foreach ($whereColumns as $i => $col) {
      $stmt->bindValue(":where_$col", $whereValues[$i], PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  public function delete(string $table, array $whereColumns, array $whereValues): bool
  {

    if (count($whereColumns) !== count($whereValues)) {
      throw new Exception("Número de colunas e valores do WHERE não corresponde.");
    }

    $whereClause = implode(" AND ", array_map(fn($col) => "$col = :where_$col", $whereColumns));
    $sql = "DELETE FROM brincaqui.$table WHERE $whereClause";
    $stmt = $this->pdo->prepare($sql);

    foreach ($whereColumns as $i => $col) {
      $stmt->bindValue(":where_$col", $whereValues[$i], PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  public function toggleActive(string $table, string $columnToToggle, array $whereColumns, array|string $whereValues): bool
  {
    $whereValues = is_array($whereValues) ? $whereValues : [$whereValues];

    if (count($whereColumns) !== count($whereValues)) {
      throw new Exception("Número de colunas e valores do WHERE não corresponde.");
    }

    $whereClause = implode(" AND ", array_map(fn($col) => "$col = :where_$col", $whereColumns));
    $sql = "UPDATE brincaqui.$table SET $columnToToggle = CASE $columnToToggle WHEN '1' THEN '0' ELSE '1' END WHERE $whereClause";
    $stmt = $this->pdo->prepare($sql);

    foreach ($whereColumns as $i => $col) {
      $stmt->bindValue(":where_$col", $whereValues[$i], PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  public function selectWithPagination(string $sqlBase, array $params, int $perPage, int $page): array
  {
    $offset = $page * $perPage;
    $sql = "$sqlBase LIMIT :limit OFFSET :offset";
    $stmt = $this->pdo->prepare($sql);

    foreach ($params as $key => $value) {
      if (strpos($key, ':') !== 0) {
        $key = ':' . $key;
      }

      if (is_int($value)) {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
      } elseif (is_bool($value)) {
        $stmt->bindValue($key, $value, PDO::PARAM_BOOL);
      } elseif (is_null($value)) {
        $stmt->bindValue($key, $value, PDO::PARAM_NULL);
      } else {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
      }
    }

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getColumnAverage(string $table, string $column, string $whereColumn, $value): float
  {
    $sql = "SELECT AVG($column) FROM brincaqui.$table WHERE $whereColumn = :val";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':val' => $value]);
    return (float) $stmt->fetchColumn();
  }

  public function getCount(string $table, string $whereColumn, $value): int
  {
    $sql = "SELECT COUNT(*) FROM `$table` WHERE `$whereColumn` = :val";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':val' => $value]);
    return (int) $stmt->fetchColumn();
  }
}