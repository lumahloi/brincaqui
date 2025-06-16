<?php
require_once BASE_DIR . "/components/header.php";
require_once BASE_DIR . "/components/checkAuth.php";
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/playCard.css">
</head>

<body>
  <?php
  switch ($_SESSION['user_type']){
    case 1:
      require_once BASE_DIR . "/components/feedCliente.php";
      break;
    case 2:
      require_once BASE_DIR . "/components/feedEmpresa.php";
      break;
  };
  ?>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <?php require_once BASE_DIR . "/components/modal.php";?>
  
</body>
</html>