<h4 class="text-center mt-5 text-gradient-1 fw-bold mb-4">Visitados</h4>
<div id="visited" class="container-scroll"></div>

<h4 class="text-center mt-5 text-gradient-1 fw-bold mb-4">Seus favoritos</h4>
<div id="favorites" class="container-scroll"></div>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/renderPlayCard.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiVisit.js"></script>

<script>
  $(document).ready(function () {
    $.get("components/playCard.php", function (templateHtml) {
      $.ajax({
        type: "GET",
        url: SERVER_URL + "visit",
        success: (response) => {
          const container = $("#visited");
          container.empty();

          if (!response.return || response.return.length === 0) {
            container.html(
              "<p class='text-muted mx-auto'>Nenhum lugar visitado, ainda!</p>"
            );
            return;
          }

          response.return.forEach(function (item) {
            const $card = renderPlayCard(item, templateHtml, {
              detailsType: "visit-again",
            });
            container.append($card);
          });
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });
  });

</script>

<script>
  $(document).ready(function () {
    if (!classificacoes) {
      $.getJSON("../public/classificacao.json", function (data) {
        classificacoes = data;
        carregarFavoritos();
      });
    } else {
      carregarFavoritos();
    }
  });

  function carregarFavoritos() {
    $.get("components/playCard.php", function (templateHtml) {
      $.ajax({
        type: "GET",
        url: SERVER_URL + "favorite?latitude=0&longitude=0",
        success: (response) => {
          const container = $("#favorites");
          container.empty();

          const total = response?.return[0]?.total ?? 0;

          if (total === 0) {
            container.html(
              "<p class='text-muted mx-auto'>Nenhum lugar favoritado, ainda!</p>"
            );
            return;
          } else {
            response.return.forEach(function (item) {
              const $card = renderPlayCard(item, templateHtml, {
                detailsType: "visit",
              });
              container.append($card);
            });

            if (total > 10) {
              container.append('<button id="show-all-btn" class="btn btn-primary bg-gradient-1 border-0">Mostrar todos <i class="bi bi-arrow-right-circle fs-3" id="fica-branco"></i></button>');
            }

            $(document).on('click', '#show-all-btn', function () {
              window.location.href = '/favoritos';
            });
          }
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });
  }
</script>