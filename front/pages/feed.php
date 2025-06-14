<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/components/header.php";
require_once BASE_DIR . "/components/checkAuth.php";
?>
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
  <?php require_once BASE_DIR . "/components/modal.php";?>
</body>

</html>