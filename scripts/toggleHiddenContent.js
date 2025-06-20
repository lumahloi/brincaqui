$(document).ready(function () {
  const $toggleBtn = $(".toggle-filters-btn");
  const $hiddenContent = $(".hidden-content");
  const $icon = $toggleBtn.find("i");

  $toggleBtn.on("click", function () {
    $hiddenContent.toggle(); 

    if ($hiddenContent.is(":visible")) {
      $icon.removeClass("bi-chevron-down").addClass("bi-chevron-up");
      $toggleBtn.html(
        'Ocultar filtros avançados <i class="bi bi-chevron-up"></i>'
      );
    } else {
      $icon.removeClass("bi-chevron-up").addClass("bi-chevron-down");
      $toggleBtn.html(
        'Mostrar filtros avançados <i class="bi bi-chevron-down"></i>'
      );
    }
  });
});
