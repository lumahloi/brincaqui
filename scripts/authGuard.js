$(document).on("click", ".auth-link", function (e) {
  if (typeof isAuthenticated !== "undefined" && !isAuthenticated) {
    e.preventDefault();

    const modalEl = document.getElementById("modal");
    const modalInstance = new bootstrap.Modal(modalEl);

    $("#modal-title").text("Ocorreu um erro");
    $("#modal-body").html(`
      Você precisa estar logado para acessar esta página.
      <div class="mt-3 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" id="modal-cancel-btn" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary bg-gradient-1 border-0" id="modal-action-btn">Ir para login</button>
      </div>
    `);

    $("#modal-action-btn").off("click").on("click", function () {
      window.location.href = "/login";
    });

    modalInstance.show();
  }
});

document.getElementById("modal").addEventListener("hidden.bs.modal", function () {
  $(".modal-backdrop").remove();
  $("body").removeClass("modal-open").css("padding-right", "");
});
