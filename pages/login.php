<?php
require_once BASE_DIR . "/components/header.php";
?>

</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/back.php";
    ?>
    <form>
      <div class="mb-3">
        <label for="form-email" class="form-label">E-mail</label>
        <input type="text" class="form-control" id="form-email" placeholder="Seu melhor e-mail">
      </div>
      <div class="mb-3">
        <label for="form-password" class="form-label">Senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="form-password" placeholder="********">
          <span class="input-group-text">
            <i class="bi bi-eye toggle-password" data-target="#form-password"></i>
          </span>
        </div>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-primary form-control" id="form-submit">Entrar</button>
      </div>
      <div class="mb-3">
        <p><a href="index">Não tenho uma conta</a></p>
      </div>
    </form>
    <?php require_once BASE_DIR . "/components/modal.php"; ?>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/togglePassword.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiLogin.js"></script>
</body>

</html>