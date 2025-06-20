<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
  const classificacoes = <?php echo file_get_contents(BASE_DIR . "/public/classificacao.json"); ?>;
  const comodidades = <?php echo file_get_contents(BASE_DIR . "/public/comodidade.json"); ?>;
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php $headerType = 1 ?>
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    require_once BASE_DIR . "/components/header.php";
    ?>
    <?php
    switch ($_SESSION['user_type']) {
      case 1:
        require_once BASE_DIR . "/components/feedCliente.php";
        break;
      case 2:
        require_once BASE_DIR . "/components/feedEmpresa.php";
        break;
    };
    ?>
  </div>
</body>

</html>