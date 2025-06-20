<?php
require_once BASE_DIR . "/components/head.php";
?>
</head>

<body>
  <div class="containerw ps-3 pe-3">
    <?php $headerType = 1 ?>
    <?php
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    require_once BASE_DIR . "/components/header.php";
    ?>
    <?php require_once BASE_DIR . "/components/searchPlay.php" ?>
    <script>
      const classificacoes = <?php echo file_get_contents(BASE_DIR . "/public/classificacao.json"); ?>;
    </script>
  </div>
  
  <script>
    $(document).ready(() => {
      const pagination = createPlayPagination((params, onSuccess, onError) => {
        $.ajax({
          type: "GET",
          url: SERVER_URL + "play",
          data: params,
          success: onSuccess,
          error: (xhr) => {
            error_validation(xhr);
            onError();
          },
        });
      }, { storageKey: 'brinquedosSearch' });
      pagination.init();
    });
  </script>

</body>

</html>