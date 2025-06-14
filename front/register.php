<?php
require_once "base_dir.php";
require_once BASE_DIR . "/components/header.php";
?>
</head>

<body>
  <form id="register-form">
    <div class="mb-3">
      <label for="form-fullname" class="form-label">Nome completo</label>
      <input type="text" class="form-control" id="form-fullname" placeholder="João da Silva">
    </div>
    <div class="mb-3">
      <label for="form-email" class="form-label">E-mail</label>
      <input type="text" class="form-control" id="form-email" placeholder="joao@email.com">
    </div>
    <div class="mb-3">
      <label for="form-telephone" class="form-label">Telefone</label>
      <input type="text" class="form-control" id="form-telephone" placeholder="(__) _____-____">
    </div>
    <div class="mb-3">
      <label for="form-password" class="form-label">Senha</label>
      <input type="password" class="form-control" id="form-password" placeholder="********">
    </div>
    <div class="mb-3">
      <label for="form-confirm-password" class="form-label">Confirme sua senha</label>
      <input type="password" class="form-control" id="form-confirm-password" placeholder="********">
    </div>
    <div class="mb-3 d-none">
      <input type="text" class="form-control" id="form-user-type" disabled readonly>
    </div>
    <div class="mb-3">
      <button type="button" class="btn btn-primary form-control" id="form-submit">Cadastrar</button>
    </div>
  </form>

  <?php require_once BASE_DIR . "/components/modal.php"; ?>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiRegister.js"></script>
</body>
</html>
