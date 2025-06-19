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
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>

    <form>
      <div class="mb-3">
        <label for="form-fullname" class="form-label">Nome completo</label>
        <input type="text" class="form-control" id="form-fullname" disabled readonly
          value="<?php echo $_SESSION['user_name'] ?>">
      </div>

      <div class="mb-3">
        <label for="form-email" class="form-label">E-mail</label>
        <div class="input-group">
          <input type="text" class="form-control" id="form-email" disabled readonly
            value="<?php echo $_SESSION['user_email'] ?>">
          <button type="button" class="input-group-text" onclick="handleUpdate('email')">
            Atualizar <i class="bi bi-pencil ms-2"></i>
          </button>
        </div>

      </div>

      <div class="mb-3">
        <label for="form-telephone" class="form-label">Telefone</label>
        <div class="input-group">
          <input type="text" class="form-control" id="form-telephone" disabled readonly
            value="<?php echo $_SESSION['user_telephone'] ?>">
          <button type="button" class="input-group-text" onclick="handleUpdate('telephone')">
            Atualizar <i class="bi bi-pencil ms-2"></i>
          </button>
        </div>

      </div>

      <div class="mb-3">
        <label for="form-password" class="form-label">Senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="form-password" disabled readonly value="****************">
          <button type="button" class="input-group-text" onclick="handleUpdate('password')">
            Atualizar <i class="bi bi-pencil ms-2"></i>
          </button>
        </div>
      </div>

    </form>

  </div>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/authGuard.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/togglePassword.js"></script>

  <script>
    function handleUpdate(type) {
      let modalBody = "";
      let btnPrimaryText = "Prosseguir";

      if (type === "email" || type === "telephone") {
        modalBody = `
        <div class="mb-3">
          <label for="newValue" class="form-label">Novo ${type}</label>
          <input type="text" class="form-control" id="newValue">
        </div>
      `;
      } else if (type === "password") {
        modalBody = `
        <div class="mb-3">
          <label for="oldPassword" class="form-label">Senha atual</label>
          <div class="input-group">
            <input type="password" class="form-control" id="oldPassword">
            <span class="input-group-text">
              <i class="bi bi-eye toggle-password" data-target="#oldPassword"></i>
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label for="newPassword" class="form-label">Nova senha</label>
          <div class="input-group">
            <input type="password" class="form-control" id="newPassword">
            <span class="input-group-text">
              <i class="bi bi-eye toggle-password" data-target="#newPassword"></i>
            </span>
          </div>
        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirme a nova senha</label>
          <div class="input-group">
            <input type="password" class="form-control" id="confirmPassword">
            <span class="input-group-text">
              <i class="bi bi-eye toggle-password" data-target="#confirmPassword"></i>
            </span>
          </div>
        </div>
      `;
      }

      $('#modal-title').text(`Atualizar campo`);
      $('#modal-body').html(modalBody);

      $('#btn-primary').text(btnPrimaryText).removeClass('d-none');
      $('#btn-secondary').text('Cancelar').removeClass('d-none');
      $('.modal-footer').removeClass('d-none');

      $('#btn-primary').off('click');

      $('#btn-primary').on('click', function () {
        if (type === "email" || type === "telephone") {
          const value = $('#newValue').val().trim();
          if (!value) return alert("Por favor, preencha o novo valor.");
          if (!confirm(`Deseja realmente atualizar seu ${type}?`)) return;

          const payload = {};
          payload[type] = value;

          $.ajax({
            url: SERVER_URL + "auth/register.php?params=" + type,
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify(payload),
            success: function () {
              alert("Informação atualizada com sucesso!");
              location.reload();
            },
            error: function (err) {
              alert("Erro ao atualizar: " + err.responseText);
            }
          });
        }
        if (type === "password") {
          const oldPass = $('#oldPassword').val().trim(); 
          const newPass = $('#newPassword').val().trim();
          if (!newPass) return alert("Preencha a nova senha.");
          if (!confirm("Deseja realmente atualizar sua senha?")) return;

          $.ajax({
            url: SERVER_URL + "auth/register.php?params=password",
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({
              oldPassword: oldPass,
              password: newPass
            }),
            success: function () {
              alert("Senha atualizada com sucesso!");
              location.reload();
            },
            error: function (err) {
              alert("Erro ao atualizar senha: " + err.responseText);
            }
          });
        }
      });

      const modal = new bootstrap.Modal(document.getElementById('modal'));
      modal.show();
    }
  </script>

</body>

</html>