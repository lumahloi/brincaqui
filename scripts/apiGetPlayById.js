$(document).ready(function () {
  const path = window.location.pathname;
  const match = path.match(/-(\d+)$/);
  if (!match) {
    $("#play").html("<p class='text-muted'>Lugar não encontrado.</p>");
    return;
  }
  const playId = match[1];

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play/" + playId,
    xhrFields: {
      withCredentials: true
    },
    success: (response) => {
      const container = $("#play");
      container.empty();

      if (!response.return) {
        container.html("<p class='text-muted'>Lugar não encontrado.</p>");
        return;
      }

      let item = response.return[0];

      let html = `
        <i class="bi" id="btn-favorite"></i>
        <div id="play-pictures">${item.brin_pictures}</div><br/>
        <span id="play-grade">${
          item.brin_grade == null ? "0.0" : item.brin_grade
        }</span><br/>
        <span id="play-socials">${item.brin_socials}</span><br/>
        <span id="play-description">${item.brin_description}</span><br/>
        <span id="play-times">${item.brin_times}</span><br/>
        <div id="play-commodities"></div><br/>
        <span id="play-prices">${item.brin_prices}</span><br/>
        <div id="play-discounts"></div><br/>
        <span id="play-telephone">${item.brin_telephone}</span><br/>
        <span id="play-email">${item.brin_email}</span><br/>
        <span id="play-name">${item.brin_name}</span><br/>
        <span id="play-cnpj">${item.brin_cnpj}</span><br/>
        <span id="play-ages">${item.brin_ages}</span><br/>

        <span id="play-cep">${item.add_cep}</span><br/>
        <span id="play-streetnum">${item.add_streetnum}</span><br/>
        <span id="play-city">${item.add_city}</span><br/>
        <span id="play-neighborhood">${item.add_neighborhood}</span><br/>
        <span id="play-plus">${item.add_plus}</span><br/>
        <span id="play-state">${item.add_state}</span><br/>
        <span id="play-country">${item.add_country}</span><br/>

        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 1): ?>
          <button type="submit" class="btn btn-primary" id="btn-visita" data-brin-id="${item.brin_id}">Visitarei este lugar</button>
        <?php endif; ?>
      `;

      container.html(html);

      let commodities = item.brin_commodities;
      commodities = (
        Array.isArray(commodities)
          ? commodities
          : String(commodities || "").split(",")
      )
        .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
        .filter((id) => !isNaN(id));

      commodities.forEach((commodityId) => {
        getComNameByPlay(String(commodityId), $("#play-commodities"));
      });

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
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
