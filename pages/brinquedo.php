<?php
if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  exit;
}
require_once BASE_DIR . "/components/header.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playPage.css">
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/back.php";
    ?>
    <div id="play"></div>
    <?php require_once BASE_DIR . "/components/modal.php"; ?>
  </div>
  
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getDiscNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiGetPlayById.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiVisit.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiToggleFavorite.js"></script>
</body>

</html>