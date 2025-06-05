<?php
function response_format($code, $message, $return = null)
{
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode([
    "message" => $message,
    "return" => $return
  ]);
}
