$("#form-filters").submit(function (event) {
  event.preventDefault();

  const params = {};
  $(this)
    .serializeArray()
    .forEach(({ name, value }) => {
      if (value && name !== "address") params[name] = value;
    });

  if (!params.order_by) {
    params.order_by = "distance";
  }

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play",
    data: params,
    success: (response) => {
      const container = $("#results");
      container.empty();

      if (!response.return || response.return.length === 0) {
        container.html(
          "<p class='text-muted'>Nenhum resultado encontrado.</p>"
        );
        return;
      }

      response.return.forEach(function (item) {
        $.get("front/components/playCard.html", function (template) {
          let $card = $(template);

          $card.find("#play-name").text(item.brin_name);
          $card.find("#play-pictures").text(item.brin_pictures);
          $card.find("#play-grade").text(item.brin_grade);
          $card.find("#play-commodities").text(item.brin_commodities);
          $card.find("#play-discounts").text(item.brin_discounts);
          $card.find("#play-ages").text(item.brin_ages);
          $card.find("#play-streetnum").text(item.add_streetnum);
          $card.find("#play-city").text(item.add_city);
          $card.find("#play-neighborhood").text(item.add_neighborhood);
          $card.find("#play-plus").text(item.add_plus || "—");

          container.append($card);
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
