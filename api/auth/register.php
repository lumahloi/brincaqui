<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

switch ($_SERVER['REQUEST_METHOD'])
{
  case 'POST': 
    date_default_timezone_set('America/Sao_Paulo');

    $input_fullname = filter_var($_POST["fullname"]) ?? '';
    $input_email = filter_var($_POST["email"]) ?? '';
    $input_telephone = filter_var($_POST["telephone"]) ?? '';
    $input_password = filter_var($_POST["password"]) ?? '';
    $input_confirm_password = filter_var($_POST["confirmPassword"]) ?? '';
    $input_user_type = filter_var($_POST["userType"]) ?? '';

    valid_fullname($input_fullname);
    valid_telephone($input_telephone);
    valid_email($input_email);
    valid_password($input_password);
    valid_user_type($input_user_type);

    if ($input_password !== $input_confirm_password) {
      response_format(400, "As senhas não coincidem.");
      exit;
    }

    if (unique_telephone($input_telephone)) {
      response_format(400, "Já existe um usuário cadastrado com este telefone.");
      exit;
    }

    if (unique_email($input_email)) {
      response_format(400, "Já existe um usuário cadastrado com este e-mail.");
      exit;
    }

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
