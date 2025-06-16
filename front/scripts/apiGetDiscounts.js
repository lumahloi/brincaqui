$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: SERVER_URL + "discount",
    success: (response) => {
      const container = $(
        'div.form-control:has(> label.form-control-label:contains("Descontos:"))'
      )
        .find("div")
        .first();
      container.empty();

      if (!response || !response.return) {
        container.html("<p class='text-muted'>Nenhum desconto disponível.</p>");
        return;
      }

      const discounts = Array.isArray(response.return)
        ? response.return
        : [response.return];

      if (discounts.length === 0) {
        container.html("<p class='text-muted'>Nenhum desconto cadastrado.</p>");
        return;
      }

      discounts.forEach((discount) => {
        if (discount && discount.disc_id) {
          container.append(`
            <div class="form-check">
              <input class="form-check-input" type="checkbox" 
                     name="discounts[]" value="${discount.disc_id}" 
                     id="discount-${discount.disc_id}">
              <label class="form-check-label" for="discount-${
                discount.disc_id
              }">
                ${discount.disc_title || "Desconto"}
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
