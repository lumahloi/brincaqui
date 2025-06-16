<?php
require_once BASE_DIR . "/components/checkAuth.php";
require_once BASE_DIR . "/components/header.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playCard.css">
<script>
  const authError = <?php echo isset($auth_error) ? 'true' : 'false'; ?>;
</script>
</head>

<body>
  <?php
  switch ($_SESSION['user_type']) {
    case 1:
      require_once BASE_DIR . "/components/feedCliente.php";
      break;
    case 2:
      require_once BASE_DIR . "/components/feedEmpresa.php";
      break;
  }
  ;
  ?>
  <?php require_once BASE_DIR . "/components/modal.php"; ?>
  <script src="<?php echo BASE_URL ?>/scripts/authError.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
</body>
</html>