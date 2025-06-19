<?php
require_once __DIR__ . "/../base_dir.php";
require_once BASE_DIR . "/utils/load_env.php";
load_env(BASE_DIR . '.env');
session_id(getenv('SESSION_ID'));
$cookie = "PHPSESSID=" . session_id();