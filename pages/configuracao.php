<?php
require_once BASE_DIR . "/components/head.php";
$status = $_GET['status'] ?? '';
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3 pb-0">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>

    <div class="col d-flex flex-column justify-content-between" style="min-height: 90%;">
      <div class="col">
        
          <div class="row align-items-center">
            <div class="col-auto"><i class="bi bi-person-circle fs-1"></i></div>
            <div class="col-auto">
              <h4><?php echo $_SESSION['user_name'] ?></h4>
            </div>
          </div>

        <div class="col mt-3 me-2 ms-2 d-grid gap-3">
          <a href="/notificacoes" class="text-decoration-none text-black">
            <div class="row align-items-center">
              <div class="col-1 me-2"><i class="bi bi-bell-fill fs-5"></i></div>
              <div class="col w-100">
                <div class="col">Notificações</div>
                <div class="col small text-muted">Central de notificações</div>
              </div>
              <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
            </div>
          </a>
          <a href="/informacoes" class="text-decoration-none text-black">
            <div class="row align-items-center">
              <div class="col-1 me-2"><i class="bi bi-file-earmark-text-fill fs-5"></i></div>
              <div class="col w-100">
                <div class="col">Dados da sua conta</div>
                <div class="col small text-muted">As informações da sua conta</div>
              </div>
              <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
            </div>
          </a>
          <a href="/favoritos" class="text-decoration-none text-black">
            <div class="row align-items-center">
              <div class="col-1 me-2"><i class="bi bi-heart-fill fs-5"></i></div>
              <div class="col w-100">
                <div class="col">Lugares favoritos</div>
                <div class="col small text-muted">Seus lugares favoritos</div>
              </div>
              <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
            </div>
          </a>
          <a href="/visitados" class="text-decoration-none text-black">
            <div class="row align-items-center">
              <div class="col-1 me-2"><i class="bi bi-geo-fill fs-5"></i></div>
              <div class="col w-100">
                <div class="col">Lugares visitados</div>
                <div class="col small text-muted">Os lugares que você já visitou</div>
              </div>
              <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
            </div>
          </a>
        </div>
      </div>

      <div class="me-2 ms-2 d-grid gap-3">
        <a href="" class="text-decoration-none text-black">
          <div class="row align-items-center">
            <div class="col-1 me-2"><i class="bi bi-question-circle fs-5"></i></div>
            <div class="col w-100">Ajuda</div>
            <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
          </div>
        </a>

        <a href="" class="text-decoration-none text-black">
          <div class="row align-items-center">
            <div class="col-1 me-2"><i class="bi bi-info-circle fs-5"></i></div>
            <div class="col w-100">Sobre esta versão</div>
            <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
          </div>
        </a>

        <a href="/logout" class="text-decoration-none text-black">
          <div class="row align-items-center">
            <div class="col-1 me-2"><i class="bi bi-box-arrow-right fs-5"></i></div>
            <div class="col w-100">Sair</div>
            <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
          </div>
        </a>
        
      </div>
    </div>

  </div>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/authGuard.js"></script>
</body>

</html>