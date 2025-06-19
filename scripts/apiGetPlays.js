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

  function renderCards(response) {
    const container = $("#results");
    container.empty();

    if (!response.return || response.return.length === 0) {
      container.html(
        "<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>"
      );
      return;
    }

    response.return.forEach(function (item) {
      $.get("/components/playCard.php", function (template) {
        let $card = $(template);

        $card.find("#play-name").text(item.brin_name);
        $card.find("#play-pictures").text(item.brin_pictures);

        let grade = Number(item.brin_grade ?? 0);
        let label = getClassificacaoLabel(item.brin_grade);
        let gradeText = grade % 1 === 0 ? grade.toFixed(1) : grade;

        $card.find("#play-grade").text(`${gradeText} ${label}`);
        $card.find("#play-distance").text(Number(item.distance).toFixed(1) + " km");
        $card.find("#play-visits").text((item.brin_visits ?? 0) + " visitas");
        $card.find("#play-favorites").text((item.brin_faves ?? 0) + " favoritos");
        $card.find("#price-title").text(item.min_price_title ?? "");
        $card.find("#price-price").text(item.min_price ? "R$ " + item.min_price : "");

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
          .on("click", function () {
            if (!isAuthenticated) return;
            window.location.href = `/lugar/${nomeBrinquedoSlug}-${item.brin_id}`;
          });

        $("#results").append($card);
      });
    });
  }

  if (classificacoes) {
    $.ajax({
      type: "GET",
      url: SERVER_URL + "play",
      data: params,
      success: renderCards,
      error: (xhr) => {
        error_validation(xhr);
      },
    });
  } else {
    $.getJSON("../public/classificacao.json", function (data) {
      classificacoes = data;

      $.ajax({
        type: "GET",
        url: SERVER_URL + "play",
        data: params,
        success: renderCards,
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });
  }
});
