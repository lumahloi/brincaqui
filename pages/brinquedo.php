<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  if (isAuthenticated === 0) {
    window.location.href = "/";
  }
  const classificacoes = <?php echo file_get_contents(BASE_DIR . "/public/classificacao.json"); ?>;
  const comodidades = <?php echo file_get_contents(BASE_DIR . "/public/comodidade.json"); ?>;
  const descontos = <?php echo file_get_contents(BASE_DIR . "/public/desconto.json"); ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/pt-br.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script>
  dayjs.extend(dayjs_plugin_relativeTime);
  dayjs.locale('pt-br');
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>
    <div id="play"></div>
  </div>

  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/renderPlayDetails.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getComName.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getDiscName.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/apiVisit.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getFeedback.js"></script>

  <script>
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

        const $favesSpan = $btn.closest(".row").find("span").filter(function () {
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

  </script>

  <script>
    $(document).ready(function () {
      const path = window.location.pathname;
      const match = path.match(/-(\d+)$/);
      if (!match) {
        $("#play").html("<p class='text-muted mx-auto'>Lugar não encontrado.</p>");
        return;
      }
      const playId = match[1];

      $.ajax({
        type: "GET",
        url: SERVER_URL + "play/" + playId,
        xhrFields: {
          withCredentials: true,
        },
        success: (response) => {
          const container = $("#play");
          container.empty();

          if (!response.return.brinquedo[0]) {
            container.html(
              "<p class='text-muted mx-auto'>Lugar não encontrado.</p>"
            );
            return;
          }

          let item = response.return;

          const html = renderPlayDetails(item);
          container.html(html);

          totalFeedbacks = item.total_avaliacoes;

          const feedbackModule = createFeedbackPagination(playId, `/api/feedback/${playId}`, totalFeedbacks, {
            perPage: 3,
            enablePagination: false
          });
          feedbackModule.init();

          let commodities = item.brinquedo[0].brin_commodities;
          commodities = (
            Array.isArray(commodities)
              ? commodities
              : String(commodities || "").split(",")
          )
            .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
            .filter((id) => !isNaN(id));

          let $commoditiesContainer = $("#play-commodities");
          $commoditiesContainer.empty();

          for (let i = 0; i < commodities.length; i += 2) {
            let row = $('<div class="d-flex flex-row mb-2"></div>');
            let col1 = $('<div class="col"></div>');
            getComName(String(commodities[i]), col1);
            row.append(col1);

            if (commodities[i + 1] !== undefined) {
              let col2 = $('<div class="col"></div>');
              getComName(String(commodities[i + 1]), col2);
              row.append(col2);
            }

            $commoditiesContainer.append(row);
          }

          let discounts = (
            Array.isArray(item.brinquedo[0].brin_discounts)
              ? item.brinquedo[0].brin_discounts
              : String(item.brinquedo[0].brin_discounts || "").split(",")
          )
            .map((id) => parseInt(String(id).replace(/[^\d]/g, ""), 10))
            .filter((id) => !isNaN(id));

          const $discountsContainer = $("#play-discounts");
          if ($discountsContainer.length) {
            if (item.brinquedo[0].brin_discounts && discounts.length > 0) {
              $discountsContainer.append(
                '<p class="fw-bold mb-2 mt-3">Descontos:</p>'
              );
            }
            discounts.forEach((discountId) => {
              getDiscName(String(discountId), $discountsContainer);
            });
          } else {
            setTimeout(() => {
              const $retryContainer = $("#play-discounts");
              if ($retryContainer.length) {
                if (item.brinquedo[0].brin_discounts && discounts.length > 0) {
                  $retryContainer.append(
                    "<p>Este brinquedo possui os seguintes descontos:</p>"
                  );
                }
                discounts.forEach((discountId) => {
                  getDiscName(String(discountId), $retryContainer);
                });
              }
            }, 50);
          }

          $(document).on("click", "#toggle-times", function () {
            const container = $("#times-container");
            const icon = $("#toggle-times-text i");

            if (container.is(":visible")) {
              container.slideUp();
              icon.removeClass("bi-caret-up-fill").addClass("bi-caret-down-fill");
            } else {
              container.slideDown();
              icon.removeClass("bi-caret-down-fill").addClass("bi-caret-up-fill");
            }
          });
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });

  </script>
</body>

</html>