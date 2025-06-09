<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";
require_once BASE_DIR . "/utils/validate_infos.php";

if($cookie){
  check_permission([1,2], $cookie);
}

$input_fullname = valid_fullname($input_fullname);
$input_telephone = valid_telephone($input_telephone);
valid_email($input_email);
valid_password($input_password);
valid_user_type($input_user_type);

if ($input_password !== $input_confirm_password) {
  response_format(400, "As senhas não coincidem.");
}
