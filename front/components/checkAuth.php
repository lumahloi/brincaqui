<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  $auth_error = true;
}
