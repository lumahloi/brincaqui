<?php
require_once "base_dir.php";
require_once BASE_DIR . "/components/header.php";
?>

<script src="<?php echo BASE_URL ?>/scripts/getUserType.js"></script>
</head>

<body>
  <form>
    <div class="mb-3">
      <label for="form-fullname" class="form-label">Nome completo</label>
      <input type="text" class="form-control" id="form-fullname" placeholder="Seu nome completo">
    </div>
    <div class="mb-3">
      <label for="form-telephone" class="form-label">Telefone</label>
      <input type="text" class="form-control" id="form-telephone" placeholder="Seu telefone">
    </div>
    <div class="mb-3">
      <label for="form-email" class="form-label">E-mail</label>
      <input type="text" class="form-control" id="form-email" placeholder="Seu melhor e-mail">
    </div>
    <div class="mb-3">
      <label for="form-password" class="form-label">Senha</label>
      <input type="text" class="form-control" id="form-password" placeholder="Sua senha">
    </div>
    <div class="mb-3">
      <label for="form-confirm-password" class="form-label">Confirme sua senha</label>
      <input type="text" class="form-control" id="form-confirm-password" placeholder="Confirme sua senha">
    </div>
    <div class="mb-3">
      <label for="form-user-type" class="form-label">Tipo de usuário</label>
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