<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/validate_infos.php";
require_once BASE_DIR . "/utils/permission.php";

if (isset($data['fullname'])) {
  $input_fullname = trim($data['fullname']);
  $input_fullname = valid_fullname($input_fullname);
}

if (isset($data['userType'])) {
  $input_user_type = trim($data['userType']);
  valid_user_type($input_user_type);
}

if (isset($data['telephone'])) {
  $input_telephone = trim($data['telephone']);
  $input_telephone = valid_telephone($input_telephone);
}

if (isset($data['password'])) {
  $input_password = trim($data['password']);
  valid_password($input_password);
}

if (isset($data['oldPassword'])) {
  $input_old_password = trim($data['oldPassword']);
  valid_password($input_old_password);
}

if (isset($data['confirmPassword'])) {
  $input_confirm_password = trim($data['confirmPassword']);
  if (isset($input_password) && $input_password !== $input_confirm_password) {
    response_format(400, "As senhas não coincidem.");
  }
  $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
  if (!preg_match($regex, $input_password)) {
    response_format(400, "A senha deve ter pelo menos 8 caracteres, incluir letras maiúsculas, minúsculas e números.");
  }
}
