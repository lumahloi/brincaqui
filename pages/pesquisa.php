<?php
require_once BASE_DIR . "/components/head.php";
?>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    require_once BASE_DIR . "/components/header.php";
    ?>
    <?php require_once BASE_DIR . "/components/searchPlay.php" ?>
    <div id="results" class="mt-4 d-grid gap-3"></div>
    <div id="pagination" class="d-flex justify-content-center align-items-center gap-3 mt-4">
      <button id="prev-page" class="btn btn-outline-secondary" disabled>Anterior</button>
      <span id="current-page">Página 1</span>
      <button id="next-page" class="btn btn-outline-secondary">Próxima</button>
    </div>

  </div>

</body>

</html>