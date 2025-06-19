let classificacoes = null;

function loadClassificacoesAndRender(item, renderCallback) {
  if (classificacoes) {
    renderCallback(item);
    return;
  }
  $.getJSON("../public/classificacao.json", function (data) {
    classificacoes = data;
    renderCallback(item);
  });
}

function getClassificacaoLabel(grade) {
  if (!classificacoes) return "";
  grade = Number(grade);
  for (let i = 0; i < classificacoes.length; i++) {
    const c = classificacoes[i];
    if (grade >= c.min && grade <= c.max) {
      return c.label;
    }
  }
  return "";
}

function renderPlayCard(item, templateHtml, options = {}) {
  const $card = $(templateHtml);

  $card.find("#play-name").text(item.brin_name);
  let grade = Number(item.brin_grade ?? 0);
  $card
    .find("#play-grade")
    .text(
      grade % 1 === 0
        ? grade.toFixed(1) + " " + getClassificacaoLabel(item.brin_grade)
        : grade + " " + getClassificacaoLabel(item.brin_grade)
    );
  $card.find("#play-distance").text(item.brin_distance ?? 0 + " km");
  $card.find("#play-neighborhood").text(item.add_neighborhood ?? "");
  $card.find("#play-city").text(item.add_city ?? "");
  $card.find("#play-visits").text((item.brin_visits ?? 0) + " visitas");
  $card.find("#play-favorites").text((item.brin_faves ?? 0) + " favoritos");
  $card.find("#price-title").text(item.min_price_title ?? "");
  $card.find("#price-price").text(item.min_price ? "R$ " + item.min_price : "");

  const slug = item.brin_name
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "") 
    .replace(/[^a-z0-9]+/g, "-") 
    .replace(/^-+|-+$/g, ""); 

  const href = `/lugar/${slug}-${item.brin_id}`;
  $card.find("#play-link").attr("href", href);

  if (item.brin_picture) {
    $card
      .find("#play-pictures")
      .html(`<img src="${item.brin_picture}" class="img-fluid rounded">`);
  }

  let commodities = item.brin_commodities;
  commodities = (
    Array.isArray(commodities)
      ? commodities
      : String(commodities || "").split(",")
  )
    .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
    .filter((id) => !isNaN(id));

  $card.find("#play-commodities").empty();
  commodities.forEach((commodityId) => {
    if (typeof getComNameByPlay === "function") {
      getComNameByPlay(String(commodityId), $card.find("#play-commodities"));
    } else {
      $card
        .find("#play-commodities")
        .append(`<span class="badge bg-secondary me-1">${commodityId}</span>`);
    }
  });

  let nomeBrinquedoSlug = item.brin_name
    ? item.brin_name
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/^-+|-+$/g, "")
    : "";

  const $btn = $card.find(".btn-details");
  if (options.detailsType === "visit") {
    $btn
      .off("click")
      .attr("data-brin-id", item.brin_id)
      .text("Visitarei este lugar");
  } else if (options.detailsType === "visit-again") {
    if (!item.user_has_rating) {
      $btn
        .off("click")
        .text("Avaliar experiência")
        .on("click", function (e) {
          if (typeof isAuthenticated !== "undefined" && !isAuthenticated)
            return;
          const brinquedo = item.brin_name
            ? item.brin_name
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, "-")
                .replace(/^-+|-+$/g, "")
            : "";
          window.location.href = `/avaliacao/${brinquedo}-${item.brin_id}`;
        });
    } else {
      $btn
        .off("click")
        .attr("data-brin-id", item.brin_id)
        .text("Visitarei novamente");
    }
  } else {
    $btn
      .addClass("auth-link")
      .attr("data-name", nomeBrinquedoSlug)
      .off("click")
      .text("Ver mais informações")
      .on("click", function (e) {
        if (typeof isAuthenticated !== "undefined" && !isAuthenticated) return;
        const brinquedo = $(this).data("name");
        saveSearchState();
        window.location.href = `/lugar/${brinquedo}-${item.brin_id}`;
      });
  }

  return $card;
}

function saveSearchState() {
  const params = {};
  $("#form-filters")
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

  sessionStorage.setItem(
    "lastSearch",
    JSON.stringify({
      params,
      currentPage,
    })
  );
}
