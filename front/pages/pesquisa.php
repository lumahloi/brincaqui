<?php
require_once BASE_DIR . "/components/header.php";
?>
</head>

<body>
  <div class="containerw">
    <?php require_once BASE_DIR . "/components/searchPlay.php"?>
    <div id="results" class="mt-4 d-grid gap-3"></div>
  </div>
  
  <?php require_once BASE_DIR . "/components/modal.php"; ?>
</body>

</html>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>