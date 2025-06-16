$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: "public/comodidade.json",
    dataType: "json",
    success: (commodities) => {
      const container = $(
        'div.form-control:has(> label.form-control-label:contains("Comodidades:"))'
      )
        .find("div")
        .first();
      container.empty();

      if (!commodities || !Array.isArray(commodities)) {
        container.html("<p class='text-muted'>Nenhuma comodidade disponível.</p>");
        return;
      }

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
              <label class="form-check-label" for="commodity-${commodity.com_id}">
                ${commodity.com_title || "Comodidade"}
              </label>
            </div>
          `);
        }
      });
    },
    error: (xhr) => {
      console.error("Erro:", xhr);
      $(
        'div.form-control:has(> label.form-control-label:contains("Comodidades:"))'
      )
        .find("div")
        .first()
        .html("<p class='text-danger'>Erro ao carregar comodidades.</p>");
    },
  });
});
