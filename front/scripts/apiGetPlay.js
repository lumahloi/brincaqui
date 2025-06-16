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
        $.get("/components/playCard.html", function (template) {
          let $card = $(template);

          $card.find("#play-name").text(item.brin_name);
          $card.find("#play-pictures").text(item.brin_pictures);
          $card
            .find("#play-grade")
            .text(item.brin_grade == null ? "0.0" : item.brin_grade);
          $card.find("#play-city").text(item.add_city);
          $card.find("#play-neighborhood").text(item.add_neighborhood);

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

          $card.find(".btn-details").attr("data-name", nomeBrinquedoSlug);

          $card.find(".btn-details").on("click", function () {
            const brinquedo = $(this).data("name");
            window.location.href = `/locais/${brinquedo}-${item.brin_id}`;
          });
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
