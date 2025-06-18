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
