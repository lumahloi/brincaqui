$(document).on("click", ".auth-link", function (e) {
  if (typeof isAuthenticated !== "undefined" && !isAuthenticated) {
    e.preventDefault();

    const modalEl = document.getElementById("modal");
    const modalInstance = new bootstrap.Modal(modalEl);
    
    $("#modal-title").text("Ocorreu um erro");
    $("#modal-body").html("Você precisa estar logado para acessar esta página.");

    modalInstance.show();
  }
});

document.getElementById("modal").addEventListener("hidden.bs.modal", function () {
  $(".modal-backdrop").remove();
  $("body").removeClass("modal-open").css("padding-right", "");
});
