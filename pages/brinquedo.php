<?php
require_once BASE_DIR . "/components/header.php";
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
</script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playPage.css">
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>
    <div id="play"></div>
  </div>
  
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getDiscNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiGetPlayById.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiVisit.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiToggleFavorite.js"></script>
</body>

</html>