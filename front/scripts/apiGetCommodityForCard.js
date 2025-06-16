function getCommodityForCard(commodityId, targetElement) {
  if (!commodityId || typeof commodityId !== "string") {
    console.error("ID de commodity inválido:", commodityId);
    return;
  }

  $.ajax({
    type: "GET",
    url: SERVER_URL + "commodity" + commodityId.trim(),
    success: (response) => {
      if (response.return?.com_title) {
        const badge = $(`<span class="badge bg-primary me-2 mb-2">`).text(
          response.return.com_title
        );
        targetElement.append(badge);
      }
    },
    error: (xhr) => {
      console.error(`Erro ao buscar commodity ${commodityId}:`, xhr);
    },
  });
}
