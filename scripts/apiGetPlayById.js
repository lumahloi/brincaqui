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

        let discounts = (
          Array.isArray(item.brin_discounts)
            ? item.brin_discounts
            : String(item.brin_discounts || "").split(",")
        )
          .map((id) => parseInt(String(id).replace(/[^\d]/g, ""), 10))
          .filter((id) => !isNaN(id));

        const $discountsContainer = $("#play-discounts");
        if ($discountsContainer.length) {
          if (item.brin_discounts && discounts.length > 0) {
            $discountsContainer.append(
              '<p class="fw-bold mb-2 mt-3">Descontos:</p>'
            );
          }
          discounts.forEach((discountId) => {
            getDiscNameByPlay(String(discountId), $discountsContainer);
          });
        } else {
          setTimeout(() => {
            const $retryContainer = $("#play-discounts");
            if ($retryContainer.length) {
              if (item.brin_discounts && discounts.length > 0) {
                $retryContainer.append(
                  "<p>Este brinquedo possui os seguintes descontos:</p>"
                );
              }
              discounts.forEach((discountId) => {
                getDiscNameByPlay(String(discountId), $retryContainer);
              });
            }
          }, 50);
        }
      });

      $(document).on("click", "#toggle-times", function () {
        const container = $("#times-container");
        const icon = $("#toggle-times-text i");

        if (container.is(":visible")) {
          container.slideUp();
          icon.removeClass("bi-caret-up-fill").addClass("bi-caret-down-fill");
        } else {
          container.slideDown();
          icon.removeClass("bi-caret-down-fill").addClass("bi-caret-up-fill");
        }
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
