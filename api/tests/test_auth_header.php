<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/src/utils/load_env.php";
load_env(BASE_DIR . '/.env');
session_id(getenv('SESSION_ID'));
session_start();
$cookie = "PHPSESSID=" . session_id();