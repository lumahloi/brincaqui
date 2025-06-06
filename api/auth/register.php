<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

switch ($_SERVER['REQUEST_METHOD'])
{
  case 'POST': 
    date_default_timezone_set('America/Sao_Paulo');

    $data = json_decode(file_get_contents("php://input"), true);
    $input_fullname = filter_var($data['fullname']) ?? '';
    $input_email = filter_var($data['email']) ?? '';
    $input_telephone = filter_var($data['telephone']) ?? '';
    $input_password = filter_var($data['password']) ?? '';
    $input_confirm_password = filter_var($data['confirmPassword']) ?? '';
    $input_user_type = filter_var($data['userType']) ?? '';

    require_once "./components/register_validation.php";

    $input_fullname = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $input_fullname);

    $input_telephone = preg_replace('/\D/', '', $input_telephone);

    $hash = password_hash($input_password, PASSWORD_DEFAULT);

    $date = date('Y/m/d');

    $pdo = DbConnection::connect();
    $p_insert = $pdo->prepare("INSERT INTO brincaqui.usuario (user_name, user_telephone, user_email, user_password, user_active, user_creation, user_lastedit, user_type) VALUES (:user_name, :user_telephone, :user_email, :user_password, 1, :user_creation, :user_lastedit, :user_type);");
    $p_insert->bindParam(":user_name", $input_fullname, PDO::PARAM_STR);
    $p_insert->bindParam(":user_telephone", $input_telephone, PDO::PARAM_STR);
    $p_insert->bindParam(":user_email", $input_email, PDO::PARAM_STR);
    $p_insert->bindParam(":user_password", $hash, PDO::PARAM_STR);
    $p_insert->bindParam(":user_creation", $date, PDO::PARAM_STR);
    $p_insert->bindParam(":user_lastedit", $date, PDO::PARAM_STR);
    $p_insert->bindParam(":user_type", $input_user_type, PDO::PARAM_STR);
    $insert_user = $p_insert->execute();

    if (!$insert_user) {
      response_format(400, "Não foi possível realizar seu cadastro, revise seus dados e tente novamente.");
      exit;
    }

    response_format(201, "Conta criada com sucesso.");
    break;
  
  default:
    response_format(405, "Apenas POST permitido.");
    exit;
}
