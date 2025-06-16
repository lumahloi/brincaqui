<?php
require_once BASE_DIR . "/components/checkAuth.php";
require_once BASE_DIR . "/components/header.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playPage.css">
<script>
  const authError = <?php echo isset($auth_error) ? 'true' : 'false'; ?>;
</script>
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/back.php";
    ?>
    <div id="play"></div>
  </div>
  <?php require_once BASE_DIR . "/components/modal.php"; ?>
  <script src="<?php echo BASE_URL ?>/scripts/authError.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getDiscNameByPlay.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiGetPlayById.js"></script>
</body>

</html>