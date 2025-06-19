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

    <div id="pagination" class="row justify-content-center align-items-center gap-2 mt-4" style="display: none;">
      <div class="col text-end">
        <i id="prev-page" class="bi bi-arrow-left-circle fs-3" role="button"></i>
      </div>
      <div class="col text-center">
        <span id="current-page">Página 1</span>
      </div>
      <div class="col text-start">
        <i class="bi bi-arrow-right-circle fs-3" id="next-page" role="button"></i>
      </div>
    </div>

  </div>

</body>

</html>