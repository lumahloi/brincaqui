<?php
require_once BASE_DIR . "/utils/db_functions.php";

try {

  $uri = $_SERVER['REQUEST_URI'];
  $uri_parts = explode('/', trim($uri, '/'));
  $input_id = $uri_parts[2] ?? null;
  
  if (!$input_id) {
    response_format(400, "ID do brinquedo não especificado.");
  }
  
  $db = new Database();
  
  $check_fav_exists = $db->selectWhere(
    ['Usuario_user_id', 'Brinquedo_brin_id'], 
    'favorito', 
    ['Usuario_user_id', 'Brinquedo_brin_id'], 
    [$_SESSION['user_id'], $input_id]);
  
  not_null_or_false($check_fav_exists);
  
  $insert_play = $db->insertInto(
    'favorito',
    ['Usuario_user_id', 'Brinquedo_brin_id'],
    [$_SESSION['user_id'], $input_id]
  );
  
  not_null_or_false($insert_play);
  
  $update_favs = $db->update(
    'brinquedo',
    ['brin_faves'],
    [$db->getCount(
      'favorito',
      'Brinquedo_brin_id',
      $input_id
      )],
    ['brin_id'],
    [$input_id],
  );
  
  not_null_or_false($update_favs);
  
  response_format(201, "Brinquedo favoritado com sucesso.");
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
