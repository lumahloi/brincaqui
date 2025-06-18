<?php
require_once BASE_DIR . "/components/head.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playCard.css">
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    ?>
    <?php require_once BASE_DIR . "/components/searchPlay.php" ?>
    <div id="results" class="mt-4 d-grid gap-3"></div>
  </div>

</body>

</html>