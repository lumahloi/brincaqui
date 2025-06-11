<?php
session_start();
require_once BASE_DIR . "/utils/db_functions.php";
require_once BASE_DIR . "/utils/permission.php";
check_permission([1,2,3], $cookie);

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y/m/d');

$update = db_update('usuario', ['user_active', 'user_lastedit'], [0, $date], ['user_id'], $_SESSION['user_id']);

not_null_or_false($update);

response_format(200, "Conta deletada com sucesso.");
