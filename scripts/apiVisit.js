$(document).on("click", ".btn-visita", function () {
  const brinId = $(this).data("brin-id");

  $.ajax({
    type: "GET",
    url: SERVER_URL + "visit/" + brinId,
    success: (response) => {
      if (response.return[0] == null) {
        $.ajax({
          type: "POST",
          url: SERVER_URL + "visit/" + brinId,
          success: () => {
            window.location.href = "/visita?status=sucesso";
          },
          error: () => {
            window.location.href = "/visita?status=erro";
          },
        });
      } else {
        window.location.href = "/visita?status=erro";
      }
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});