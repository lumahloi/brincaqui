<?php
require_once BASE_DIR . "/components/head.php";
?>
</head>

<body>
  <div id="initial-options" class="containerw">
    <?php
    require_once BASE_DIR . "/components/header.php";
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    ?>
    <div class="gradient-1 text-white pt-4">
      <h3 class="text-center">A diversão está aqui</h3>
      <div class="row gap-3 p-4">
        <button type="button" class="btn btn-primary col bg-white border-white text-black" id="btn-register-type1">Criar
          minha conta</button>
        <button type="button" class="btn btn-primary col bg-white border-white text-black"
          id="btn-register-type2">Divulgar meu negócio</button>
      </div>
    </div>

    <img src="<?php echo BASE_URL; ?>/img/mae-e-filha.png" alt="" class="img-70 mt-3">
    <h4 class="text-center mt-4">Aproveite com qualidade</h4>
    <p class="pe-4 ps-4 text-center">Entre agora e descubra onde estará o próximo momento especial. Temos muitas opções!
    </p>

    <button href="login" class="btn gradient-1 text-white mx-auto d-block mt-4">Já tenho uma conta</button>

  </div>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/registerRedirect.js"></script>
</body>

</html>