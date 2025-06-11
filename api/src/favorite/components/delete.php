<?php
require_once BASE_DIR . "/utils/db_functions.php";

$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$input_id = $uri_parts[3] ?? null;

if (!$input_id) {
  response_format(400, "ID do brinquedo não especificado.");
}

$check_fav_exists = selectWhere(
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  'favorito', 
  ['Usuario_user_id', 'Brinquedo_brin_id'], 
  [$_SESSION['user_id'], $input_id]);

not_null_or_false($check_fav_exists);

$delete_fav = delete(
  'favorito',
  ['Usuario_user_id', 'Brinquedo_brin_id'],
  [$_SESSION['user_id'], $input_id]
);

not_null_or_false($delete_fav);

$update_favs = update(
  'brinquedo',
  ['brin_faves'],
  [db_get_total_faves_from_play($input_id)],
  ['brin_id'],
  [$input_id],
);

not_null_or_false($update_favs);

response_format(201, "Brinquedo desfavoritado com sucesso.");
