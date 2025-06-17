$("#play").on("click", "#btn-visita", function () {
  const brinId = $(this).data("brin-id");
  $.ajax({
    type: "POST",
    url: SERVER_URL + "visit/" + brinId,
    success: () => {
      window.location.href = "/visita?status=sucesso";
    },
    error: () => {
      window.location.href = "/visita?status=erro";
    }
  });
});