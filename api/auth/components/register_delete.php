<?php
session_start();
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([1,2,3], $cookie);

try {
  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y/m/d');
  
  $db = new Database();
  $update = $db->update('usuario', ['user_active', 'user_lastedit'], [0, $date], ['user_id'], $_SESSION['user_id']);
  
  not_null_or_false($update);
  
  response_format(200, "Conta deletada com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
