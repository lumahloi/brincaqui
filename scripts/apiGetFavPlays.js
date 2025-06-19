const perPage = 1;

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
      url: SERVER_URL + "favorite?per_page=" + perPage,
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

          if(total > perPage){
            container.append('<button class="btn btn-primary bg-gradient-1 border-0">Mostrar todos <i class="bi bi-arrow-right-circle fs-3" id="fica-branco"></i></button>')
          }
        }
      },
      error: (xhr) => {
        error_validation(xhr);
      },
    });
  });
}
