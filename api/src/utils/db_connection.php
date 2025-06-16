<?php
require_once BASE_DIR . "/utils/load_env.php";
load_env(BASE_DIR . '/../.env');

abstract class DbConnection
{
  public static function connect()
  {
    try {
      $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4';

      if (empty(getenv('DB_HOST'))) {
        throw new PDOException("DB_HOST não configurado no .env");
      }
      if (empty(getenv('DB_NAME'))) {
        throw new PDOException("DB_NAME não configurado no .env");
      }

      $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $currentDb = $pdo->query("SELECT DATABASE()")->fetchColumn();
      if (!$currentDb) {
        throw new PDOException("Falha ao selecionar o banco de dados: " . getenv('DB_NAME'));
      }

      return $pdo;
    } catch (PDOException $e) {
      error_log("Erro de conexão com o banco: " . $e->getMessage());
      throw new PDOException("Falha na conexão com o banco de dados. Verifique as configurações.");
    }
  }
}