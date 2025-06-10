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

  if ($stmt->execute()) {
    return $pdo->lastInsertId();
  }

  return false;
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

function db_select_plays_by_user(int $perPage, int $page, string $orderBy, string $orderDir, array $filters = [], int $input_user_id)
{
  $pdo = DbConnection::connect();
  $offset = $page * $perPage;

  $sql = "
    SELECT brinquedo.*,
      endereco.add_cep,
      endereco.add_streetnum,
      endereco.add_city,
      endereco.add_neighborhood,
      endereco.add_plus,
      endereco.add_state,
      endereco.add_country 
    FROM brincaqui.brinquedo 
    JOIN brincaqui.endereco ON brinquedo.brin_id = endereco.Brinquedo_brin_id 
    WHERE brinquedo.Usuario_user_id = :user_id
  ";

  $params = [':user_id' => $input_user_id];
  $jsonArrayColumns = ['brin_ages', 'brin_discounts', 'brin_commodities'];

  foreach ($filters as $column => $value) {
    if (in_array($column, $jsonArrayColumns)) {
      if (!is_array($value)) {
        $value = explode(',', $value);
      }
      foreach ($value as $index => $val) {
        $param = ":{$column}_$index";
        $sql .= " AND JSON_CONTAINS(brinquedo.$column, $param)";
        $params[$param] = json_encode((int) $val);
      }
    } elseif (in_array($column, ['add_cep', 'add_city', 'add_neighborhood'])) {
      $param = ":$column";
      $sql .= " AND endereco.$column = $param";
      $params[$param] = $value;
    } elseif (is_array($value)) {
      $placeholders = [];
      foreach ($value as $index => $val) {
        $key = ":{$column}_$index";
        $placeholders[] = $key;
        $params[$key] = $val;
      }
      $sql .= " AND brinquedo.$column IN (" . implode(", ", $placeholders) . ")";
    } else {
      $key = ":$column";
      $sql .= " AND brinquedo.$column = $key";
      $params[$key] = $value;
    }
  }

  $sql .= " ORDER BY brinquedo.$orderBy $orderDir";
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

function db_select_all_active_plays(int $perPage, int $page, string $orderBy, string $orderDir, array $filters = [])
{
  $pdo = DbConnection::connect();
  $offset = $page * $perPage;

  $sql = "SELECT brinquedo.* 
          FROM brincaqui.brinquedo 
          JOIN brincaqui.endereco ON brinquedo.brin_id = endereco.Brinquedo_brin_id 
          WHERE brin_active = 1";

  $params = [];
  $jsonArrayColumns = ['brin_ages', 'brin_discounts', 'brin_commodities'];

  foreach ($filters as $column => $value) {
    if (in_array($column, $jsonArrayColumns)) {
      if (!is_array($value)) {
        $value = explode(',', $value);
      }
      foreach ($value as $index => $val) {
        $param = ":{$column}_$index";
        $sql .= " AND JSON_CONTAINS(brinquedo.$column, $param)";
        $params[$param] = json_encode((int) $val);
      }
    } elseif (in_array($column, ['add_cep', 'add_city', 'add_neighborhood'])) {
      $param = ":$column";
      $sql .= " AND endereco.$column = $param";
      $params[$param] = $value;
    } elseif (is_array($value)) {
      $placeholders = [];
      foreach ($value as $index => $val) {
        $key = ":{$column}_$index";
        $placeholders[] = $key;
        $params[$key] = $val;
      }
      $sql .= " AND brinquedo.$column IN (" . implode(", ", $placeholders) . ")";
    } else {
      $key = ":$column";
      $sql .= " AND brinquedo.$column = $key";
      $params[$key] = $value;
    }
  }

  $sql .= " ORDER BY brinquedo.$orderBy $orderDir";
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

function db_get_active_fav_user_plays(int $perPage, int $page, string $orderBy, string $orderDir, array $filters = [])
{
  $userId = $_SESSION['user_id'];
  $pdo = DbConnection::connect();
  $offset = $page * $perPage;
  $params = [];

  $sql = "
    SELECT b.* 
    FROM brincaqui.brinquedo b
    INNER JOIN brincaqui.favorito ub ON ub.Brinquedo_brin_id = b.brin_id
    WHERE b.brin_active = 1
      AND ub.Usuario_user_id = :userId
  ";
  $params[':userId'] = $userId;

  $jsonArrayColumns = ['brin_ages', 'brin_discounts', 'brin_commodities'];

  foreach ($filters as $column => $value) {
    if (in_array($column, $jsonArrayColumns)) {
      if (!is_array($value)) {
        $value = explode(',', $value);
      }
      foreach ($value as $index => $val) {
        $param = ":{$column}_$index";
        $sql .= " AND JSON_CONTAINS(b.$column, $param)";
        $params[$param] = json_encode((int) $val);
      }
    } elseif (is_array($value)) {
      $placeholders = [];
      foreach ($value as $index => $val) {
        $key = ":{$column}_$index";
        $placeholders[] = $key;
        $params[$key] = $val;
      }
      $sql .= " AND b.$column IN (" . implode(", ", $placeholders) . ")";
    } else {
      $key = ":$column";
      $sql .= " AND b.$column = $key";
      $params[$key] = $value;
    }
  }

  $sql .= " ORDER BY b.$orderBy $orderDir";
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

function db_get_all_user_visited_plays(int $perPage, int $page, string $orderBy, string $orderDir, array $filters = [])
{
  $userId = $_SESSION['user_id'];
  $pdo = DbConnection::connect();
  $offset = $page * $perPage;
  $params = [':userId' => $userId];

  $sql = "
    SELECT b.* 
    FROM brincaqui.brinquedo b
    INNER JOIN brincaqui.visita v ON v.Brinquedo_brin_id = b.brin_id
    WHERE v.Usuario_user_id = :userId
  ";

  $jsonArrayColumns = ['brin_ages', 'brin_discounts', 'brin_commodities'];

  foreach ($filters as $column => $value) {
    if (in_array($column, $jsonArrayColumns)) {
      if (!is_array($value)) {
        $value = explode(',', $value);
      }
      foreach ($value as $index => $val) {
        $param = ":{$column}_$index";
        $sql .= " AND JSON_CONTAINS(b.$column, $param)";
        $params[$param] = json_encode((int) $val);
      }
    } elseif (is_array($value)) {
      $placeholders = [];
      foreach ($value as $index => $val) {
        $key = ":{$column}_$index";
        $placeholders[] = $key;
        $params[$key] = $val;
      }
      $sql .= " AND b.$column IN (" . implode(", ", $placeholders) . ")";
    } else {
      $key = ":$column";
      $sql .= " AND b.$column = $key";
      $params[$key] = $value;
    }
  }

  $sql .= " ORDER BY b.$orderBy $orderDir";
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

function db_get_avg_from_play($play)
{
  $pdo = DbConnection::connect();

  $stmt = $pdo->prepare("
    SELECT AVG(aval_grade_1) as avg_grade
    FROM brincaqui.avaliacao
    WHERE Brinquedo_brin_id = :id
  ");

  $stmt->execute([':id' => $play]);

  return $stmt->fetchColumn();
}

function db_get_total_visits_from_play($play)
{
  $pdo = DbConnection::connect();

  $stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM brincaqui.visita
    WHERE Brinquedo_brin_id = :id
  ");

  $stmt->execute([':id' => $play]);

  return $stmt->fetchColumn();
}

function db_get_total_faves_from_play($play)
{
  $pdo = DbConnection::connect();

  $stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM brincaqui.favorito
    WHERE Brinquedo_brin_id = :id
  ");

  $stmt->execute([':id' => $play]);

  return $stmt->fetchColumn();
}

function db_select_fb_from_play(int $perPage, int $page, int $input_id)
{
  $pdo = DbConnection::connect();
  $offset = $page * $perPage;

  $sql = "
    SELECT a.*, u.user_name
    FROM brincaqui.avaliacao a
    INNER JOIN brincaqui.usuario u ON a.Usuario_user_id = u.user_id
    WHERE a.Brinquedo_brin_id = :brin_id
    ORDER BY a.aval_date DESC
    LIMIT :limit OFFSET :offset
  ";

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':brin_id', $input_id, PDO::PARAM_INT);
  $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
