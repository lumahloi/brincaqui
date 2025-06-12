<?php
require_once "base_dir.php";
require_once BASE_DIR . "/components/header.php";
?>
</head>

<body>
  <button type="button" class="btn btn-primary" id="btn-register-type1">Cliente</button>
  <button type="button" class="btn btn-primary" id="btn-register-type2">Empresa</button>

  <?php require_once BASE_DIR . "/components/modal.php";?>
  <script src="<?php echo BASE_URL ?>/scripts/registerButtons.js"></script>
</body>

</html>