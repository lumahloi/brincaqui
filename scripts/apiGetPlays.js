$("#form-filters").submit(function (event) {
  event.preventDefault();

  const params = {};
  $(this)
    .serializeArray()
    .forEach(({ name, value }) => {
      if (params[name]) {
        if (!Array.isArray(params[name])) {
          params[name] = [params[name]];
        }
        params[name].push(value);
      } else {
        params[name] = value;
      }
    });

  ["ages", "commodities", "discounts"].forEach((field) => {
    if (params[field] && !Array.isArray(params[field])) {
      params[field] = [params[field]];
    }
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
        $.get("/components/playCard.php", function (template) {
          let $card = $(template);

          $card.find("#play-name").text(item.brin_name);
          $card.find("#play-pictures").text(item.brin_pictures);
          $card
            .find("#play-grade")
            .text(
              item.brin_grade == null
                ? "0.0"
                : Number.isInteger(Number(item.brin_grade))
                ? Number(item.brin_grade).toFixed(1)
                : String(item.brin_grade)
            );
          $card
            .find("#play-distance")
            .text(Number(item.distance).toFixed(1) + " km");

          $card.find("#play-visits").text(item.brin_visits + " visitas");

          $card.find("#play-favorites").text(item.brin_faves + " favoritos");

          $card.find("#price-title").text(item.min_price_title)
          $card.find("#price-price").text("R$ " + item.min_price)

          let commodities = item.brin_commodities;

          commodities = (
            Array.isArray(commodities)
              ? commodities
              : String(commodities || "").split(",")
          )
            .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
            .filter((id) => !isNaN(id));

          commodities.forEach((commodityId) => {
            getComNameByPlay(
              String(commodityId),
              $card.find("#play-commodities")
            );
          });

          $("#results").append($card);

          let nomeBrinquedoSlug = item.brin_name
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");

          $card
            .find(".btn-details")
            .addClass("auth-link")
            .attr("data-name", nomeBrinquedoSlug)
            .off("click")
            .text("Ver mais informações")
            .on("click", function (e) {
              if (!isAuthenticated) return;

              const brinquedo = $(this).data("name");
              window.location.href = `/lugar/${brinquedo}-${item.brin_id}`;
            });
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
