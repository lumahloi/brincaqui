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
            "<p class='text-muted'>Nenhum lugar visitado, ainda!</p>"
          );
          return;
        }

        response.return.forEach(function (item) {
          const $card = $(templateHtml);

          $card.find("#play-name").text(item.brin_name);
          $card.find("#play-grade").text(item.brin_grade ?? "-");
          $card.find("#play-neighborhood").text(item.add_neighborhood ?? "");
          $card.find("#play-city").text(item.add_city ?? "");
          $card
            .find("#play-commodities")
            .html(
              (item.commodities || [])
                .map((c) => `<span class="badge bg-secondary me-1">${c}</span>`)
                .join("")
            );
          $card.find(".btn-details").attr("data-name", item.brin_name);

          if (item.brin_picture) {
            $card
              .find("#play-pictures")
              .html(
                `<img src="${item.brin_picture}" class="img-fluid rounded" style="max-height:120px;">`
              );
          }

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

          $card
            .find(".btn-details")
            .off("click")
            .attr("data-brin-id", item.brin_id)
            .text("Visitarei novamente")
          container.append($card);
        });
      },
      error: (xhr) => {
        error_validation(xhr);
      },
    });
  });
});
