function getDiscNameByPlay(discountId, targetElement) {
  if (!discountId || typeof discountId !== "string") {
    console.error("ID de discount inválido:", discountId);
    return;
  }

  $.ajax({
    type: "GET",
    url: "../public/desconto.json", 
    dataType: "json",
    success: (response) => {
      const discounts = Array.isArray(response) ? response : [];

      const discount = discounts.find(
        (item) => String(item.disc_id) === discountId
      );

      if (discount) {
        const element = $(`
        <div class="col-12 d-flex align-items-center mb-1">
          <i class="bi bi-check me-2 fs-5"></i>
          <span>${discount.disc_title}</span>
        </div>
      `);
        targetElement.append(element);
      } else {
        console.warn(`desconto com ID ${discountId} não encontrada.`);
      }
    },
    error: (xhr) => {
      console.error(`Erro ao buscar descontos:`, xhr);
    },
  });
}
