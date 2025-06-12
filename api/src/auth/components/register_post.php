<?php
require_once BASE_DIR . "/utils/db_functions.php";


try {
  $campos_obrigatorios = [
    'Nome completo' => $input_fullname,
    'Telefone' => $input_telephone,
    'E-mail' => $input_email,
    'Senha' => $input_password,
    'Confirmação de senha' => $input_confirm_password,
    'Tipo de usuário' => $input_user_type,
  ];

  foreach ($campos_obrigatorios as $nome => $valor) {
    if (empty($valor)) {
      response_format(400, "O campo '{$nome}' é obrigatório.");
    }
  }
  
  $hash = password_hash($input_password, PASSWORD_DEFAULT);

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y/m/d');

  $db = new Database();

  $insert_user = $db->insertInto(
    'usuario',
    ['user_name', 'user_telephone', 'user_email', 'user_password', 'user_active', 'user_creation', 'user_lastedit', 'user_type'],
    [$input_fullname, $input_telephone, $input_email, $hash, 1, $date, $date, $input_user_type]
  );

  not_null_or_false($insert_user);

  response_format(201, "Conta criada com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
