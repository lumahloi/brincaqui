<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/response_format.php";

try {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      $uri = $_SERVER['REQUEST_URI'];
      $uri_parts = explode('/', trim($uri, '/'));
      $com_id = $uri_parts[4] ?? null;

      if ($com_id) {
        require_once "./components/get_by_id.php";
      }
      require_once "./components/get.php";

      break;

    default:
      response_format(405, "Apenas GET permitido.");
  }
} catch (PDOException $e) {
  response_format(500, "Erro no banco de dados: " . $e->getMessage());
} catch (Exception $e) {
  response_format(500, "Erro interno: " . $e->getMessage());
}
