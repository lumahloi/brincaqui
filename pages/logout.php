<?php
require_once BASE_DIR . "/components/head.php";
?>
</head>

<body>
  <?php require_once BASE_DIR . "/components/modal.php"; ?>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>

  <script>
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: SERVER_URL + "auth/logout.php",
        contentType: "application/json",
        success: () => {
          window.location = "index";
        },
        error: (xhr) => {
          error_validation(xhr);
        },
      });
    });

  </script>

</body>

</html>