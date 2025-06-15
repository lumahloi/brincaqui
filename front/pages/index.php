<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/components/header.php";
?>
</head>

<body>
  <div id="initial-options" class="containerw">
    <div class="mb-3">
      <button type="button" class="btn btn-primary" id="btn-register-type1">Cliente</button>
    </div>
    <div class="mb-3">
      <button type="button" class="btn btn-primary" id="btn-register-type2">Empresa</button>
    </div>
    <div class="mb-3">
      <p><a href="login">Já tenho uma conta</a></p>
    </div>
  </div>
  <?php require_once BASE_DIR . "/components/modal.php"; ?>
  <script src="<?php echo BASE_URL ?>/scripts/registerRedirect.js"></script>
</body>

</html>