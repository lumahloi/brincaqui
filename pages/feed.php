<?php
require_once BASE_DIR . "/components/header.php";
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
</script>
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
</body>

</html>