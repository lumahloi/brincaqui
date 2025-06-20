<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
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
    <div id="feedback"></div>

    <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
    <script src="<?php echo BASE_URL ?>/scripts/renderFeedbackDetails.js"></script>

    <script>
      $(document).ready(function () {
        const path = window.location.pathname;
        const match = path.match(/(\d+)$/);
        if (!match) {
          $("#feedback").html("<p class='text-muted mx-auto'>Avaliação não encontrada.</p>");
          return;
        }
        const fbId = match[1];

        $.ajax({
          type: "GET",
          url: SERVER_URL + "feedback" + "?avaliacao=" + fbId,
          success: (response) => {
            const container = $("#feedback");
            container.empty();

            if (!response.return) {
              container.html(
                "<p class='text-muted mx-auto'>Lugar não encontrado.</p>"
              );
              return;
            }

            let item = response.return;

            const html = renderFeedbackDetails(item);
            container.html(html);

            document.querySelectorAll(".date-relative").forEach((el) => {
              const dateStr = el.getAttribute("data-date");
              const relativeTime = dayjs(dateStr).fromNow();
              el.textContent = relativeTime;
            });
          },
          error: (xhr) => {
            error_validation(xhr);
          }
        })
      })
    </script>
  </div>
</body>

</html>