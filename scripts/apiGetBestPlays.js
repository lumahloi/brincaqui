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
          const $card = $(templateHtml);

          $card.find("#play-name").text(item.brin_name);
          $card
            .find("#play-distance")
            .text(Number(item.distance).toFixed(1) + " km");
          $card
            .find("#play-grade")
            .text(
              item.brin_grade == null
                ? "0.0"
                : Number.isInteger(Number(item.brin_grade))
                ? Number(item.brin_grade).toFixed(1)
                : String(item.brin_grade)
            );
          $card.find("#play-visits").text(item.brin_visits + " visitas");

          $card.find("#play-favorites").text(item.brin_faves + " favoritos");

          $card.find("#price-title").text(item.min_price_title);
          $card.find("#price-price").text("R$ " + item.min_price);
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

          container.append($card);
        });
      },
      error: (xhr) => {
        error_validation(xhr);
      },
    });
  });
});
