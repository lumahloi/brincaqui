$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: SERVER_URL + "commodity",
    success: (response) => {
      const container = $(
        'div.form-control:has(> label.form-control-label:contains("Comodidades:"))'
      )
        .find("div")
        .first();
      container.empty();

      if (!response || !response.return) {
        container.html("<p class='text-muted'>Nenhuma comodidade disponível.</p>");
        return;
      }

      const commodities = Array.isArray(response.return)
        ? response.return
        : [response.return];

      if (commodities.length === 0) {
        container.html("<p class='text-muted'>Nenhuma comodidade cadastrada.</p>");
        return;
      }

      commodities.forEach((commodity) => {
        if (commodity && commodity.com_id) {
          container.append(`
            <div class="form-check">
              <input class="form-check-input" type="checkbox" 
                     name="commodities[]" value="${commodity.com_id}" 
                     id="commodity-${commodity.com_id}">
              <label class="form-check-label" for="commodity-${
                commodity.com_id
              }">
                ${commodity.com_title || "Comodidade"}
              </label>
            </div>
          `);
        }
      });
    },
    error: (xhr) => {
      console.error("Erro:", xhr);
      error_validation(xhr);
      $(
        'div.form-control:has(> label.form-control-label:contains("Descontos:"))'
      )
        .find("div")
        .first()
        .html("<p class='text-danger'>Erro ao carregar descontos.</p>");
    },
  });
});
