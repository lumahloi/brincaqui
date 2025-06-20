<?php
require_once BASE_DIR . "/components/head.php";
?>

</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    require_once BASE_DIR . "/components/header.php";
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
        <button type="submit" class="btn btn-primary form-control bg-gradient-1 border-0"
          id="form-submit">Entrar</button>
      </div>
      <div class="mb-3">
        <p><a href="index" class="text-black">Não tenho uma conta</a></p>
      </div>
    </form>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/togglePassword.js"></script>

  <script>
    $("#form-submit").click(function (event) {
      event.preventDefault();
      var input_email = $("#form-email").val();
      var input_password = $("#form-password").val();

      $.ajax({
        type: "POST",
        url: SERVER_URL + "auth/login.php",
        contentType: "application/json",
        data: JSON.stringify({
          email: input_email,
          password: input_password,
        }),
        xhrFields: {
          withCredentials: true,
        },
        success: () => {
          window.location = "pesquisa";
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });

  </script>
</body>

</html>