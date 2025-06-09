<?php

if(isset($input_email)){
  valid_email_characters($input_email);
}

if(isset($input_password)){
  valid_password($input_password);
}

if(isset($input_confirm_password)){
  if ($input_password !== $input_confirm_password) {
    response_format(400, "As senhas não coincidem.");
  }
}

if(isset($input_fullname)){
  $input_fullname = valid_fullname($input_fullname);
}

if(isset($input_telephone)){
  $input_telephone = valid_telephone($input_telephone);
}

if(isset($input_user_type)){
  valid_user_type($input_user_type);
}

if(isset($cookie)){
  check_permission([1,2], $cookie);
}
