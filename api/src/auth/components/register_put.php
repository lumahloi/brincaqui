<?php
session_start();
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([1, 2, 3], $cookie);
require_once BASE_DIR . "/utils/validate_infos.php";

try {

  $params = valid_url_params();

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y/m/d');

  $db = new Database();

  foreach ($params as $param) {
    switch ($param) {
      case 'telephone':
        $update = $db->update(
          'usuario',
          ['user_telephone', 'user_lastedit'],
          [$input_telephone, $date],
          ['user_id'],
          $_SESSION['user_id']
        );
        not_null_or_false($update);
        break;

      case 'email':
        $update = $db->update(
          'usuario',
          ['user_email', 'user_lastedit'],
          [$input_email, $date],
          ['user_id'],
          $_SESSION['user_id']
        );
        not_null_or_false($update);
        break;

      case 'password':
        $hash = password_hash($input_password, PASSWORD_DEFAULT);
        $update = $db->update(
          'usuario',
          ['user_password', 'user_lastedit'],
          [$hash, $date],
          ['user_id'],
          $_SESSION['user_id']
        );
        not_null_or_false($update);
        break;

      default:
        response_format(405, "Tipo de parâmetro inválido.");
    }
  }

  response_format(200, "Atualização(s) feita com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
