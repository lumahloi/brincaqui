<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/validate_infos.php";
require_once BASE_DIR . "/utils/permission.php";

if (isset($data['fullname'])) {
  $input_fullname = filter_var($data['fullname'], FILTER_SANITIZE_STRING);
  $input_fullname = valid_fullname($input_fullname);
}

if (isset($data['userType'])) {
  $input_user_type = filter_var($data['userType'], FILTER_SANITIZE_STRING);
  valid_user_type($input_user_type);
}

if (isset($data['telephone'])) {
  $input_telephone = filter_var($data['telephone'], FILTER_SANITIZE_STRING);
  $input_telephone = valid_telephone($input_telephone);
}

if (isset($data['password'])) {
  $input_password = filter_var($data['password'], FILTER_SANITIZE_STRING);
  valid_password($input_password);
}

if (isset($data['confirmPassword'])) {
  $input_confirm_password = filter_var($data['confirmPassword'], FILTER_SANITIZE_STRING);
  if (isset($input_password) && $input_password !== $input_confirm_password) {
    response_format(400, "As senhas não coincidem.");
  }
  $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
  if (!preg_match($regex, $input_password)) {
    response_format(400, "A senha deve ter pelo menos 8 caracteres, incluir letras maiúsculas, minúsculas e números.");
  }
}
