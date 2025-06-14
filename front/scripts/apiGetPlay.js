$("#form-filters").submit(function (event) {
  event.preventDefault();

  const params = {};
  $(this).serializeArray().forEach(({ name, value }) => {
    if (value) params[name] = value;
  });

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play",
    data: params,
    success: (response) => {
      const container = $("#results");
      container.empty();

      if (!response.return || response.return.length === 0) {
        container.html("<p class='text-muted'>Nenhum resultado encontrado.</p>");
        return;
      }

      response.return.forEach(function (item) {
        $.get("front/components/playCard.html", function (template) {
          let $card = $(template);
          $card.find(".title").text(item.brin_id);
          container.append($card);
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
