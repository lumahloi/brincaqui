<?php
require_once "db_connection.php";

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
    $whereValues = [$whereValues];
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

function db_delete(string $table, array $whereColumns, array $whereValues)
{
    $pdo = DbConnection::connect();

    if (count($whereColumns) !== count($whereValues)) {
        throw new Exception("Número de colunas e valores do WHERE não corresponde.");
    }

    $whereParts = [];
    foreach ($whereColumns as $col) {
        $whereParts[] = "$col = :where_$col";
    }
    $whereClause = implode(" AND ", $whereParts);

    $sql = "DELETE FROM brincaqui.$table WHERE $whereClause;";
    $stmt = $pdo->prepare($sql);

    foreach ($whereColumns as $index => $col) {
        $stmt->bindValue(":where_$col", $whereValues[$index], PDO::PARAM_STR);
    }

    return $stmt->execute();
}

function db_toggle_active(string $table, string $column_to_toggle, array $where_columns, $where_values)
{
  $pdo = DbConnection::connect();

  if (!is_array($where_values)) {
    $where_values = [$where_values];
  }

  if (count($where_columns) !== count($where_values)) {
    throw new Exception("Número de colunas e valores do WHERE não corresponde.");
  }

  $whereParts = [];
  foreach ($where_columns as $col) {
    $whereParts[] = "$col = :where_$col";
  }
  $whereClause = implode(" AND ", $whereParts);

  $sql = "UPDATE brincaqui.$table
          SET $column_to_toggle = CASE $column_to_toggle WHEN '1' THEN '0' ELSE '1' END
          WHERE $whereClause;";

  $stmt = $pdo->prepare($sql);

  foreach ($where_columns as $index => $col) {
    $stmt->bindValue(":where_$col", $where_values[$index], PDO::PARAM_STR);
  }

  return $stmt->execute();
}

function db_select_plays(int $perPage, int $page, string $orderBy, string $orderDir, array $filters = [], int $input_user_id)
{
    $pdo = DbConnection::connect();
    $offset = $page * $perPage;

    $sql = "SELECT * FROM brincaqui.brinquedo WHERE Usuario_user_id = :user_id";
    $params = [':user_id' => $input_user_id];

    $jsonArrayColumns = ['brin_ages', 'brin_discounts', 'brin_commodities'];

    foreach ($filters as $column => $value) {
        if (in_array($column, $jsonArrayColumns)) {
            if (!is_array($value)) {
                $value = explode(',', $value);
            }
            foreach ($value as $index => $val) {
                $param = ":{$column}_$index";
                $sql .= " AND JSON_CONTAINS($column, $param)";
                $params[$param] = json_encode((int) $val);
            }
        } elseif (is_array($value)) {
            $placeholders = [];
            foreach ($value as $index => $val) {
                $key = ":{$column}_$index";
                $placeholders[] = $key;
                $params[$key] = $val;
            }
            $sql .= " AND $column IN (" . implode(", ", $placeholders) . ")";
        } else {
            $key = ":$column";
            $sql .= " AND $column = $key";
            $params[$key] = $value;
        }
    }

    $sql .= " ORDER BY $orderBy $orderDir";
    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, is_numeric(json_decode($value)) ? PDO::PARAM_STR : PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
