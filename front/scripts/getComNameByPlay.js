function getComNameByPlay(commodityId, targetElement) {
  if (!commodityId || typeof commodityId !== "string") {
    console.error("ID de commodity inválido:", commodityId);
    return;
  }

  $.ajax({
    type: "GET",
    url: "/public/comodidade.json",
    dataType: "json",
    success: (response) => {
      const commodities = Array.isArray(response) ? response : [];

      const commodity = commodities.find(
        (item) => String(item.com_id) === commodityId
      );

      if (commodity) {
        const element = $(`
        <div class="col-6 d-flex align-items-center mb-1">
          <i class="${commodity.com_icon} me-2 fs-5"></i>
          <span>${commodity.com_title}</span>
        </div>
      `);
        targetElement.append(element);
      } else {
        console.warn(`Comodidade com ID ${commodityId} não encontrada.`);
      }
    },
    error: (xhr) => {
      console.error(`Erro ao buscar comodidades:`, xhr);
    },
  });
}
