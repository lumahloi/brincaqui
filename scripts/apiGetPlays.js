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
        const card = renderPlayCard(item, template);
        container.append(card);
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
