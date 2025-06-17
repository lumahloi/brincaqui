<?php
if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  exit;
}
require_once BASE_DIR . "/components/header.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playCard.css">
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    ?>
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
  </div>
  
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
</body>

</html>