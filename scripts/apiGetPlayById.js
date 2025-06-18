$(document).ready(function () {
  const path = window.location.pathname;
  const match = path.match(/-(\d+)$/);
  if (!match) {
    $("#play").html("<p class='text-muted mx-auto'>Lugar não encontrado.</p>");
    return;
  }
  const playId = match[1];

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play/" + playId,
    xhrFields: {
      withCredentials: true,
    },
    success: (response) => {
      const container = $("#play");
      container.empty();

      if (!response.return) {
        container.html(
          "<p class='text-muted mx-auto'>Lugar não encontrado.</p>"
        );
        return;
      }

      let item = response.return[0];

      loadClassificacoesAndRender(item, function (item) {
        const html = renderPlayDetails(item);
        container.html(html);

        let commodities = item.brin_commodities;
        commodities = (
          Array.isArray(commodities)
            ? commodities
            : String(commodities || "").split(",")
        )
          .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
          .filter((id) => !isNaN(id));

        let $commoditiesContainer = $("#play-commodities");
        $commoditiesContainer.empty();

        for (let i = 0; i < commodities.length; i += 2) {
          let row = $('<div class="row mb-2"></div>');
          let col1 = $('<div class="col"></div>');
          getComNameByPlay(String(commodities[i]), col1);
          row.append(col1);

          if (commodities[i + 1] !== undefined) {
            let col2 = $('<div class="col"></div>');
            getComNameByPlay(String(commodities[i + 1]), col2);
            row.append(col2);
          }

          $commoditiesContainer.append(row);
        }

        let discounts = item.brin_discounts;
        discounts = (
          Array.isArray(discounts)
            ? discounts
            : String(discounts || "").split(",")
        )
          .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
          .filter((id) => !isNaN(id));

        discounts.forEach((discountId) => {
          getDiscNameByPlay(String(discountId), $("#play-discounts"));
        });
      });

      $("#toggle-times").on("click", function () {
        const $container = $("#times-container");
        const $text = $("#toggle-times-text");
        if ($container.is(":visible")) {
          $container.slideUp(150);
          $text.html("<i class='bi bi-caret-down-fill'></i>");
        } else {
          $container.slideDown(150);
          $text.html("<i class='bi bi-caret-up-fill'></i>");
        }
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
