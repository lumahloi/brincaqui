$(document).ready(function () {
  $(document).on("DOMSubtreeModified", "#play", function () {
    const path = window.location.pathname;
    const match = path.match(/-(\d+)$/);
    if (!match) return;
    const playId = match[1];
    const $btn = $("#btn-favorite");

    if ($btn.length && !$btn.hasClass("bi-heart") && !$btn.hasClass("bi-heart-fill")) {
      $.ajax({
        type: "GET",
        url: SERVER_URL + "favorite/" + playId,
        xhrFields: { withCredentials: true },
        success: function (response) {
          if (response.return && response.return.length > 0) {
            $btn.addClass("bi-heart-fill");
          } else {
            $btn.addClass("bi-heart");
          }
        },
        error: function (xhr) {
          error_validation(xhr);
        }
      });
    }
  });

  $("#play").on("click", "#btn-favorite", function () {
    const $btn = $(this);
    const path = window.location.pathname;
    const match = path.match(/-(\d+)$/);
    if (!match) return;
    const playId = match[1];

    const $favesSpan = $btn.closest(".row").find("span").filter(function() {
      return $(this).text().includes("favorito");
    });

    if ($btn.hasClass("bi-heart")) {
      $.ajax({
        type: "POST",
        url: SERVER_URL + "favorite/" + playId,
        xhrFields: { withCredentials: true },
        success: function () {
          $btn.removeClass("bi-heart").addClass("bi-heart-fill");
          let faves = parseInt($favesSpan.text()) || 0;
          $favesSpan.text((faves + 1) + " favoritos");
        },
        error: function (xhr) {
          error_validation(xhr);
        },
      });
    } else if ($btn.hasClass("bi-heart-fill")) {
      $.ajax({
        type: "DELETE",
        url: SERVER_URL + "favorite/" + playId,
        xhrFields: { withCredentials: true },
        success: function () {
          $btn.removeClass("bi-heart-fill").addClass("bi-heart");
          let faves = parseInt($favesSpan.text()) || 0;
          $favesSpan.text((faves > 0 ? faves - 1 : 0) + " favoritos");
        },
        error: function (xhr) {
          error_validation(xhr);
        },
      });
    }
  });
});
