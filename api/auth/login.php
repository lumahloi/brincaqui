<?php
session_start();
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

switch ($_SERVER['REQUEST_METHOD'])
{
  case 'POST': 
    $data = json_decode(file_get_contents("php://input"), true);
    $input_email = filter_var($data['email']) ?? '';
    $input_password = filter_var($data['password']) ?? '';
    
    valid_email($input_email);
    valid_password($input_password);
    
    if (!unique_email($input_email)) {
      response_format(400, "Não existe usuário cadastrado com este e-mail.");
      exit;
    }
    
    $pdo = DbConnection::connect();
    $p_check_password = $pdo->prepare("SELECT user_password FROM brincaqui.usuario WHERE user_email = :user_email;");
    $p_check_password->bindParam(":user_email", $input_email, PDO::PARAM_STR);
    $p_check_password->execute();
    $password_from_db = $p_check_password->fetch(PDO::FETCH_ASSOC);
    
    if (!$password_from_db || !password_verify($input_password, $password_from_db['user_password'])) {
      response_format(400, "Senha inválida.");
      exit;
    }
    
    $p_get_user_info = $pdo->prepare("SELECT user_id, user_name, user_type FROM brincaqui.usuario WHERE user_email = :user_email;");
    $p_get_user_info->bindParam(":user_email", $input_email, PDO::PARAM_STR);
    $p_get_user_info->execute();
    $user_info = $p_get_user_info->fetch(PDO::FETCH_ASSOC);

    $_SESSION["user_id"] = $user_info['user_id'];
    $_SESSION["user_type"] = $user_info['user_type'];
    
    $return = [
      "logged_user_id" => $user_info['user_id'],
      "logged_user_name" => $user_info['user_name'],
      "logged_user_type" => $user_info['user_type']
    ];
    
    response_format(200, "Login realizado com sucesso.", $return);
    break;
  
  default:
    response_format(405, "Apenas POST permitido.");
    exit;
}
