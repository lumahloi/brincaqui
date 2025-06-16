<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
  header("Location: " . "/brincaqui/");
  http_response_code(302);
  exit;
}
