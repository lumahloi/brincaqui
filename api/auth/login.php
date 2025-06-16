<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/db_functions.php";

try {

  switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
      $data = json_decode(file_get_contents("php://input"), true);

      $input_email = null;
      $input_password = null;

      require_once "./components/validation.php";

      if (isset($data['email'])) {
        $input_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        valid_email($input_email);
      }

      $db = new Database();
      $password_from_db = $db->selectWhere(
        ['user_password'],
        'usuario',
        ['user_email'],
        [$input_email]
      );

      if($password_from_db === null || $password_from_db === false){
        response_format(404, "Não existe usuário cadastrado com este email.");
      }

      if (!password_verify($input_password, $password_from_db['user_password'])) {
        response_format(400, "Senha inválida.");
      }

      $user_info = $db->selectWhere(
        ['user_id', 'user_type', 'user_name'],
        'usuario',
        ['user_email', 'user_active'],
        [$input_email, 1]
      );

      not_null_or_false($user_info);

      $_SESSION["user_id"] = $user_info['user_id'];
      $_SESSION["user_type"] = $user_info['user_type'];

      $return = [
        "logged_user_id" => $user_info['user_id'],
        "logged_user_name" => $user_info['user_name'],
        "logged_user_type" => $user_info['user_type'],
        "logged_session_id" => session_id()
      ];

      response_format(200, "Login realizado com sucesso.", $return);
      break;

    default:
      response_format(405, "Apenas POST permitido.");
  }
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
