<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {

  $db = new Database();
  
  $insert_play = $db->insertInto(
    'brinquedo',
    ['brin_pictures', 'brin_socials', 'brin_description', 'brin_times', 'brin_commodities', 'brin_prices', 'brin_discounts', 'brin_telephone', 'brin_email', 'brin_name', 'brin_cnpj', 'brin_ages', 'Usuario_user_id', 'brin_active'],
    [$input_pictures, $input_socials, $input_description, $input_times, $input_commodities, $input_prices, $input_discounts, $input_telephone, $input_email, $input_name, $input_cnpj, $input_ages, $_SESSION['user_id'], 1]
  );
  
  not_null_or_false($insert_play);
  
  $insert_add = $db->insertInto(
    'endereco',
    ['add_cep', 'add_streetnum', 'add_city','add_neighborhood','add_plus','Brinquedo_brin_id','add_state','add_country'],
    [$input_cep, $input_streetnum, $input_city, $input_neighborhood, $input_plus, $insert_play, $input_state, $input_country]
  );
  
  not_null_or_false($insert_add);
  
  response_format(201, "Brinquedo criado com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
