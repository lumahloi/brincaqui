<?php
require_once BASE_DIR . "/components/checkAuth.php";
require_once BASE_DIR . "/components/header.php";
$status = $_GET['status'] ?? '';
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles/visit.css">
<script>
  const authError = <?php echo isset($auth_error) ? 'true' : 'false'; ?>;
</script>
</head>

<body>
  <div class="containerw">
    <div id="msg-sucesso" style="display: <?php echo $status === 'sucesso' ? 'block' : 'none'; ?>;">
      <h1>Combinado!</h1>
      <p>Esperamos que tenha uma ótima visita! Depois te lembraremos de avaliar o que você achou do estabelecimento, okay?</p>
    </div>
    <div id="msg-erro" style="display: <?php echo $status === 'erro' ? 'block' : 'none'; ?>;">
      <h1>Ocorreu um erro</h1>
      <p>Por favor, tente novamente mais tarde.</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="window.location.href='javascript:history.back()'">Ok</button>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/authError.js"></script>
</body>

</html>