<?php
require_once BASE_DIR . "/utils/load_env.php";
load_env(BASE_DIR . '/.env');

abstract class DbConnection
{
  public static function connect()
  {
    $dsn = 'mysql:' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4';
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }
}