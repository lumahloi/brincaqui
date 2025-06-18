<?php
require_once BASE_DIR . "/components/head.php";
?>
</head>

<body>
  <div class="containerw">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>
    <form id="register-form">
      <div class="mb-3">
        <label for="form-fullname" class="form-label">Nome completo</label>
        <input type="text" class="form-control" id="form-fullname" placeholder="Seu nome completo">
      </div>
      <div class="mb-3">
        <label for="form-email" class="form-label">E-mail</label>
        <input type="text" class="form-control" id="form-email" placeholder="Seu melhor e-mail">
      </div>
      <div class="mb-3">
        <label for="form-telephone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="form-telephone" placeholder="Seu telefone">
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
        <label for="form-confirm-password" class="form-label">Confirme sua senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="form-confirm-password" placeholder="********">
          <span class="input-group-text">
            <i class="bi bi-eye toggle-password" data-target="#form-confirm-password"></i>
          </span>
        </div>
      </div>
      <input type="hidden" class="form-control" id="form-user-type" readonly>
      <div class="mb-3">
        <button type="button" class="btn btn-primary form-control" id="form-submit">Cadastrar</button>
      </div>
    </form>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/togglePassword.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiRegister.js"></script>
</body>

</html>