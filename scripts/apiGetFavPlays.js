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
      url: SERVER_URL + "favorite",
      success: (response) => {
        const container = $("#favorites");
        container.empty();

        if (!response.return || response.return.length === 0) {
          container.html(
            "<p class='text-muted mx-auto'>Nenhum lugar favoritado, ainda!</p>"
          );
          return;
        }

        response.return.forEach(function (item) {
          const $card = renderPlayCard(item, templateHtml, {
            detailsType: "visit",
          });
          container.append($card);
        });
      },
      error: (xhr) => {
        error_validation(xhr);
      },
    });
  });
}
