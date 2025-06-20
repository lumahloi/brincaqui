<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
</script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/hearts.css">
</head>

<body>
  <div class="containerw ps-3 pe-3 d-flex flex-column gap-3">
    <div>
      <?php
      require_once BASE_DIR . "/components/modal.php";
      require_once BASE_DIR . "/components/back.php";
      ?>
      <h4>Avaliando o lugar</h4>
      <p>Avalie os itens a seguir de acordo com a sua experiência no local.</p>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Segurança</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-seguranca" name="rating-seguranca" value="5">
        <label for="heart5-seguranca" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-seguranca" name="rating-seguranca" value="4">
        <label for="heart4-seguranca" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-seguranca" name="rating-seguranca" value="3">
        <label for="heart3-seguranca" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-seguranca" name="rating-seguranca" value="2">
        <label for="heart2-seguranca" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-seguranca" name="rating-seguranca" value="1">
        <label for="heart1-seguranca" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Limpeza</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-limpeza" name="rating-limpeza" value="5">
        <label for="heart5-limpeza" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-limpeza" name="rating-limpeza" value="4">
        <label for="heart4-limpeza" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-limpeza" name="rating-limpeza" value="3">
        <label for="heart3-limpeza" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-limpeza" name="rating-limpeza" value="2">
        <label for="heart2-limpeza" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-limpeza" name="rating-limpeza" value="1">
        <label for="heart1-limpeza" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Variedade e/ou qualidade de brinquedos e atrações</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-atracoes" name="rating-atracoes" value="5">
        <label for="heart5-atracoes" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-atracoes" name="rating-atracoes" value="4">
        <label for="heart4-atracoes" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-atracoes" name="rating-atracoes" value="3">
        <label for="heart3-atracoes" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-atracoes" name="rating-atracoes" value="2">
        <label for="heart2-atracoes" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-atracoes" name="rating-atracoes" value="1">
        <label for="heart1-atracoes" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Localização e/ou facilidade de acesso</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-localizacao" name="rating-localizacao" value="5">
        <label for="heart5-localizacao" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-localizacao" name="rating-localizacao" value="4">
        <label for="heart4-localizacao" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-localizacao" name="rating-localizacao" value="3">
        <label for="heart3-localizacao" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-localizacao" name="rating-localizacao" value="2">
        <label for="heart2-localizacao" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-localizacao" name="rating-localizacao" value="1">
        <label for="heart1-localizacao" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Preços e/ou descontos oferecidos</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-preco" name="rating-preco" value="5">
        <label for="heart5-preco" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-preco" name="rating-preco" value="4">
        <label for="heart4-preco" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-preco" name="rating-preco" value="3">
        <label for="heart3-preco" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-preco" name="rating-preco" value="2">
        <label for="heart2-preco" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-preco" name="rating-preco" value="1">
        <label for="heart1-preco" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Acessibilidade e/ou assistência</h5>
      <div class="heart-rating animated-hearts text-center w-100">
        <input type="radio" id="heart5-acessibilidade" name="rating-acessibilidade" value="5">
        <label for="heart5-acessibilidade" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart4-acessibilidade" name="rating-acessibilidade" value="4">
        <label for="heart4-acessibilidade" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart3-acessibilidade" name="rating-acessibilidade" value="3">
        <label for="heart3-acessibilidade" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart2-acessibilidade" name="rating-acessibilidade" value="2">
        <label for="heart2-acessibilidade" class="bi bi-heart-fill fs-3"></label>
        <input type="radio" id="heart1-acessibilidade" name="rating-acessibilidade" value="1">
        <label for="heart1-acessibilidade" class="bi bi-heart-fill fs-3"></label>
      </div>
      <div class="rating-label text-center text-muted small mb-2"></div>
    </div>

    <div class="col d-flex flex-column gap-1 card p-3">
      <h5 class="text-center">Espaço livre</h5>
      <textarea class="form-control mt-2" id="" rows="5"
        placeholder="Sua opinião é importante para nós. Deixe um comentário para futuros pais que verão o brinquedo..."></textarea>
    </div>

    <button class="btn btn-primary bg-gradient-1 border-0" id="btn-submit">Concluir Avaliação</button>

    <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>

    <script>
      document.querySelectorAll('.heart-rating:not(.readonly) label').forEach(heart => {
        heart.addEventListener('click', function () {
          this.style.transform = 'scale(1.2)';
          setTimeout(() => {
            this.style.transform = 'scale(1)';
          }, 200);
        });
      });

      let classificacoes = [];

      function getClassificacaoLabel(grade) {
        grade = Number(grade);
        for (let i = 0; i < classificacoes.length; i++) {
          const c = classificacoes[i];
          if (grade >= c.min && grade <= c.max) {
            return c.label;
          }
        }
        return "";
      }

      $.getJSON("../public/classificacao.json", function (data) {
        classificacoes = data;

        document.querySelectorAll('.heart-rating').forEach(function (group) {
          const inputs = group.querySelectorAll('input[type="radio"]');
          const output = group.parentElement.querySelector('.rating-label');

          inputs.forEach(function (input) {
            input.addEventListener('change', function () {
              const label = getClassificacaoLabel(this.value);
              if (output) {
                output.textContent = `${label}`;
              }
            });
          });
        });
      });

      $("#btn-submit").click(function () {
        const ratings = {
          grade_2: $('input[name="rating-seguranca"]:checked').val(),
          grade_3: $('input[name="rating-limpeza"]:checked').val(),
          grade_4: $('input[name="rating-atracoes"]:checked').val(),
          grade_5: $('input[name="rating-localizacao"]:checked').val(),
          grade_6: $('input[name="rating-preco"]:checked').val(),
          grade_7: $('input[name="rating-acessibilidade"]:checked').val(),
          description: $('textarea').val() === '' ? null : $('textarea').val()
        };

        if (Object.values(ratings).includes(undefined)) {
          alert("Por favor, preencha todas as avaliações.");
          return;
        }

        const path = window.location.pathname;
        const match = path.match(/\/avaliar\/(.+)-(\d+)/);

        if (!match || !match[2]) {
          alert("ID do brinquedo não encontrado na URL.");
          return;
        }

        const playId = match[2];

        $.ajax({
          type: "POST",
          url: SERVER_URL + "feedback/" + playId,
          data: JSON.stringify(ratings),
          contentType: "application/json",
          success: function () {
            $('#modal-title').text('Obrigado!');
            $('#modal-body').html('<p>Sua avaliação foi enviada com sucesso. Agradecemos seu feedback!</p>');

            var modalEl = document.getElementById('modal');
            var modal = new bootstrap.Modal(modalEl);
            modal.show();

            modalEl.addEventListener('hidden.bs.modal', function () {
              window.location.href = "/feed";
            }, { once: true });
          },
          error: function (xhr) {
            error_validation(xhr);
          }
        });
      });

    </script>
</body>

</html>