<?php
require_once BASE_DIR . "/components/head.php";
$status = $_GET['status'] ?? '';
?>
<script>
  if (isAuthenticated === 0) {
    window.location.href = "/";
  }
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/header.php";
    ?>
    <div id="msg-sucesso" style="display: <?php echo $status === 'sucesso' ? 'block' : 'none'; ?>;">
      <h4 class="text-center mt-4 text-gradient-1 fw-bold mt-5 mb-4">Combinado!</h4>
      <p class="text-center">Esperamos que tenha uma ótima visita! Depois te lembraremos de avaliar o que você achou do estabelecimento, okay?</p>
    </div>
    <div id="msg-erro" style="display: <?php echo $status === 'erro' ? 'block' : 'none'; ?>;">
      <h4 class="text-center mt-4 text-gradient-1 fw-bold mt-5 mb-4">Ocorreu um erro</h4>
      <p  class="text-center">Por favor, tente novamente mais tarde.</p>
    </div>
    <div class="text-center"><button type="button" class="btn btn-primary bg-gradient-1 border-0" onclick="window.location.href='javascript:history.back()'">Certo <i class="bi bi-hand-thumbs-up-fill" style="#fff" id="fica-branco"></i></button></div>
  </div>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/authGuard.js"></script>
</body>

</html>