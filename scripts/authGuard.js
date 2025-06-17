$(document).ready(function() {
  $(document).on("click", ".auth-link", function(e) {
    if (typeof isAuthenticated !== "undefined" && !isAuthenticated) {
      e.preventDefault();
      const modal = new bootstrap.Modal($("#modal")[0], {});
      $("#modal-title").text("Ocorreu um erro");
      $("#modal-body").html("Você precisa estar logado para acessar esta página.");
      modal.show();
    }
  });
});