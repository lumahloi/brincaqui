$(document).ready(function(){
  if (authError) {
    const modal = new bootstrap.Modal($("#modal")[0], {});
    $("#modal-title").text("Ocorreu um erro");
    $("#modal-body").html("Você precisa estar logado para acessar esta página.");
    modal.show();
  }
});
