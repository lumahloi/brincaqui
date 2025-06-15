<?php
session_start(); 

require_once "../base_dir.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: " . BASE_URL);
  http_response_code(302);
  exit;
}
