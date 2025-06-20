<?php
require_once BASE_DIR . "/components/head.php";
?>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/pt-br.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script>
  if (typeof isAuthenticated !== "undefined" && isAuthenticated === false) {
    window.location.href = "/";
  }
  const classificacoes = <?php echo file_get_contents(BASE_DIR . "/public/classificacao.json"); ?>;
  const comodidades = <?php echo file_get_contents(BASE_DIR . "/public/comodidade.json"); ?>;
  const descontos = <?php echo file_get_contents(BASE_DIR . "/public/desconto.json"); ?>;

  dayjs.extend(dayjs_plugin_relativeTime);
  dayjs.locale('pt-br');

  const path = window.location.pathname;
  const match = path.match(/(\d+)$/);
  const playId = match[1];
</script>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/back.php";
    ?>

    <div id="feedbacks" class="d-flex flex-column gap-2" data-total="<?= $totalFeedbacks ?>"></div>

    <div id="pagination" class="row justify-content-center align-items-center gap-2 mt-4" style="display: none;">
      <div class="col text-end">
        <i id="prev-page" class="bi bi-arrow-left-circle fs-3" role="button"></i>
      </div>
      <div class="col text-center">
        <span id="current-page">Página 1</span>
      </div>
      <div class="col text-start">
        <i class="bi bi-arrow-right-circle fs-3" id="next-page" role="button"></i>
      </div>
    </div>

    <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
    <script src="<?php echo BASE_URL ?>/scripts/getFeedback.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const totalFeedbacks = localStorage.getItem("feedbackTotal");
        const feedbackModule = createFeedbackPagination(playId, `${SERVER_URL}feedback/${playId}`, totalFeedbacks, {
          perPage: 10,
          enablePagination: true
        });
        feedbackModule.init();
      });
    </script>

  </div>
</body>

</html>