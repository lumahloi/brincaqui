<?php
require_once BASE_DIR . "/utils/db_functions.php";

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

$check_fav_exists = db_select_where(
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  'favorito', 
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  [$_SESSION['user_id'], $input_id]);

if($check_fav_exists === null || $check_fav_exists === false){
  response_format(400, "Você não favoritou este brinquedo.");
}

$delete_fav = db_delete(
  'favorito',
  ['Usuario_user_id', 'Brinquedo_brin_id'],
  [$_SESSION['user_id'], $input_id]
);

if ($delete_fav === false || $delete_fav === null) {
  response_format(400, "Não foi possível desfavoritar este brinquedo, tente novamente.");
}

$update_favs = db_update(
  'brinquedo',
  ['brin_faves'],
  [db_get_total_faves_from_play($input_id)],
  ['brin_id'],
  [$input_id],
);

if ($update_favs === false || $update_favs === null) {
  response_format(400, "Não foi possível favoritar este brinquedo, tente novamente.");
}

response_format(201, "Brinquedo desfavoritado com sucesso.");
