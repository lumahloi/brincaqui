$(document).ready(function () {
  $.get("components/playCard.php", function (templateHtml) {
    $.ajax({
      type: "GET",
      url:
        SERVER_URL +
        "play?latitude=0&longitude=0&order_by=grade&order_dir=DESC",
      success: (response) => {
        const container = $("#best");
        container.empty();

        if (!response.return || response.return.length === 0) {
          container.html("<p class='text-muted'>Nenhum lugar, ainda!</p>");
          return;
        }

        response.return.forEach(function (item) {
          const $card = renderPlayCard(item, templateHtml, {
            detailsType: "default",
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
