function switch_code(message, code) {
  switch (code) {
    case 500:
      return "Ocorreu uma falha pela nossa parte. Por favor tente novamente mais tarde!";

    default:
      return message;
  }
}

function error_validation(response) {
  const modal = new bootstrap.Modal("#modal", {});
  $("#modal-title").html("Ocorreu um erro");
  $("#modal-body").html(switch_code(response.responseJSON.message, response.code));
  modal.show();
}
