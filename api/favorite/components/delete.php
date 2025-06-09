<?php
require_once BASE_DIR . "/utils/db_functions.php";

$check_fav_exists = db_select_where(
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  $favorito, 
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  [$_SESSION['user_id'], $input_id]);

if(!$check_fav_exists){
  response_format(400, "Você não favoritou este brinquedo.");
}

$delete_fav = db_delete(
  'favorito',
  ['Usuario_user_id', 'Brinquedo_brin_id'],
  [$_SESSION['user_id'], $input_id]
);

if (!$delete_fav) {
  response_format(400, "Não foi possível desfavoritar este brinquedo, tente novamente.");
}

response_format(201, "Brinquedo favoritado com sucesso.");
