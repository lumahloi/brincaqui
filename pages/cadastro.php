<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var userType = sessionStorage.getItem("user_type");
    if (userType) {
      document.getElementById("form-user-type").value = userType;
    }
    if (userType === "2") {
      document.getElementById("extra-field-container").style.display = "block";
    }
  });
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    require_once BASE_DIR . "/components/header.php";
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
        <button type="button" class="btn btn-primary form-control bg-gradient-1 border-0"
          id="form-submit">Cadastrar</button>
      </div>

      <div class="mb-3">
        <p><a href="index" class="text-black">Já tenho uma conta</a></p>
      </div>

    </form>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/togglePassword.js"></script>

  <script>
    $(document).ready(function () {
      const userType = sessionStorage.getItem("user_type");
      if (userType) {
        $("#form-user-type").val(userType);
      }
      $("#form-telephone").inputmask('(99) 99999-9999');
    });

    $("#form-submit").click(function (event) {
      event.preventDefault();
      var input_fullname = $("#form-fullname").val();
      var input_telephone = $("#form-telephone").val();
      var input_email = $("#form-email").val();
      var input_password = $("#form-password").val();
      var input_confirm_password = $("#form-confirm-password").val();
      var input_user_type = $("#form-user-type").val();

      $.ajax({
        type: "POST",
        url: SERVER_URL + "auth/register.php",
        contentType: "application/json",
        data: JSON.stringify({
          fullname: input_fullname,
          telephone: input_telephone,
          email: input_email,
          password: input_password,
          confirmPassword: input_confirm_password,
          userType: input_user_type,
        }),
        success: () => {
          sessionStorage.removeItem("user_type");
          window.location = "login";
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });

  </script>
</body>

</html>