<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/db_connection.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission(2);

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    date_default_timezone_set('America/Sao_Paulo');

    $data = json_decode(file_get_contents('php://input'), true);

    $input_description = filter_var($data['description']) ?? '';
    $input_name = filter_var($data['name']) ?? '';
    $input_cnpj = filter_var($data['cnpj']) ?? '';
    $input_telephone = filter_var($data['telephone']) ?? '';
    $input_email = filter_var($data['email']) ?? '';
    $input_pictures = filter_var($data['pictures']) ?? null;
    $input_socials = filter_var($data['socials']) ?? null;
    $input_prices = filter_var($data['prices']) ?? null;
    $input_times = filter_var($data['times']) ?? null;
    $input_commodities = filter_var($data['commodities']) ?? [];
    $input_discounts = filter_var($data['discounts']) ?? [];
    $input_ages = filter_var($data['ages']) ?? [];

    require_once "./components/register_validation.php";

    $input_cnpj = preg_replace('/\D/', '', $input_cnpj);

    $pdo = DbConnection::connect();
    $p_insert = $pdo->prepare("INSERT INTO brincaqui.brinquedo (brin_pictures, brin_socials, brin_description, brin_times, brin_commodities, brin_prices, brin_discounts, brin_telephone, brin_email, brin_name, brin_cnpj, brin_ages, Usuario_user_id) VALUES (:brin_pictures, :brin_socials, :brin_description, :brin_times, :brin_commodities, :brin_prices, :brin_discounts, :brin_telephone, :brin_email, :brin_name, :brin_cnpj, :brin_ages, :Usuario_user_id);");
    $p_insert->bindParam(":brin_pictures", $input_pictures, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_socials", $input_socials, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_description", $input_description, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_times", $input_times, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_commodities", $input_commodities, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_prices", $input_prices, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_discounts", $input_discounts, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_telephone", $input_telephone, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_email", $input_email, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_name", $input_name, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_cnpj", $input_cnpj, PDO::PARAM_STR);
    $p_insert->bindParam(":brin_ages", $input_ages, PDO::PARAM_STR);
    $p_insert->bindParam(":Usuario_user_id", $_SESSION['user_id'], PDO::PARAM_STR);
    $insert_play = $p_insert->execute();

    if (!$insert_play) {
      response_format(400, "Não foi possível cadastrar seu brinquedo, revise seus dados e tente novamente.");
      exit;
    }

    response_format(201, "Brinquedo criado com sucesso.");
    break;

  default:
    response_format(405, "Apenas POST permitido.");
    exit;
}