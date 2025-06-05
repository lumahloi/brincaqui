<?php
function response_format($code, $message, $return = null)
{
  http_response_code($code);
  header('Content-Type: application/json');

  $response = ["message" => $message];

  if ($return !== null) {
    $response["return"] = $return;
  }

  echo json_encode($response);
}
