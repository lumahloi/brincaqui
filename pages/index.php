<?php
require_once BASE_DIR . "/components/head.php";
?>
<script>
  const classificacoes = <?php echo file_get_contents(BASE_DIR . "/public/classificacao.json"); ?>;
  const comodidades = <?php echo file_get_contents(BASE_DIR . "/public/comodidade.json"); ?>;
</script>
</head>

<body>
  <div id="initial-options" class="containerw pb-0">
    <?php
    $headerType = 1 ?>
    <?php
    require_once BASE_DIR . "/components/header.php";
    require_once BASE_DIR . "/components/modal.php";
    require_once BASE_DIR . "/components/navigation.php";
    ?>

    <div class="bg-gradient-1 text-white pt-4">
      <h3 class="text-center fw-bold">A diversão está aqui</h3>

      <div class="row gap-3 p-4" id="no-gutter">
        <button type="button" class="btn btn-primary col bg-white border-white text-black" id="btn-register-type1">Criar
          minha conta</button>
        <button type="button" class="btn btn-primary col bg-white border-white text-black"
          id="btn-register-type2">Divulgar meu negócio</button>
      </div>

      <div class="row h-100 pe-3 ps-3" id="no-gutter">
        <div class="col d-flex flex-column justify-content-center">
          <h5 class="text-center mb-4 fw-normal">Encontre seu próximo momento de diversão</h5>
          <a href="login" class="text-decoration-none"><button
              class="btn mx-auto d-block bg-white border-white text-black">Já tenho uma conta</button></a>
        </div>

        <img src="<?php echo BASE_URL; ?>/img/pai-e-filha-1.png" alt="" class="w-50 col">
      </div>
    </div>



    <img src="<?php echo BASE_URL; ?>/img/mae-e-filha.png" alt="" class="d-block w-75 mx-auto mt-5">
    <h4 class="text-center mt-4 fw-bold">Criando momentos de qualidade</h4>
    <p class="pe-4 ps-4 text-center">Nossa missão é facilitar a busca dos pais e guardiãos por locais onde podem se
      divertir com seus pequenos. Chega da frustração de não encontrar o seu lugar ideal ou não saber mais informações,
      o Brincaqui está aqui!</p>




    <h4 class="text-center mt-5 text-gradient-1 fw-bold">Por aqui você encontra</h4>
    <div class="row justify-content-center gap-2 pt-3" id="no-gutter">
      <div class="col-3 card pt-3 pb-2 pe-2 ps-2">
        <div class="row text-center pb-1"><i class="bi bi-emoji-smile-fill fs-4"></i></div>
        <p class="text-center small">Catálogo de locais para se divertir</p>
      </div>
      <div class="col-3 card pt-3 pb-2 pe-2 ps-2">
        <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-info-circle-fill fs-4"></i></div>
        <p class="text-center small">Informações completas do local</p>
      </div>
      <div class="col-3 card pt-3 pb-2 pe-2 ps-2">
        <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-star-fill fs-4"></i></div>
        <p class="text-center small">Avaliações dos nossos usuários</p>
      </div>
      <div class="col-3 card pt-3 pb-2 pe-2 ps-2">
        <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-heart-fill fs-4"></i></div>
        <p class="text-center small">Seus favoritos em 1 lugar só</p>
      </div>
      <div class="col-3 card pt-3 pb-2 pe-2 ps-2">
        <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-check-circle-fill fs-4"></i></div>
        <p class="text-center small">Locais já visitados por você</p>
      </div>
    </div>




    <h4 class="text-center mt-5 text-gradient-1 fw-bold mb-4">Os melhores</h4>
    <div id="best" class="container-scroll ps-3 pe-3"></div>



    <div class="bg-gradient-1 text-white pt-4 mt-5">
      <h4 class="text-center fw-bold">Participe gratuitamente</h4>

      <div class="row gap-3 p-4" id="no-gutter">
        <button type="button" class="btn btn-primary col bg-white border-white text-black" id="btn-register-type1">Criar
          minha conta</button>
        <button type="button" class="btn btn-primary col bg-white border-white text-black"
          id="btn-register-type2">Divulgar meu negócio</button>
      </div>
    </div>




    <h4 class="text-center mt-4 text-gradient-1 fw-bold mt-5 mb-4">Perguntas frequentes</h4>
    <div>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
              aria-expanded="false" aria-controls="faq1">
              Como faço para criar uma conta?
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse" aria-labelledby="faq1-heading"
            data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Clique em "Criar minha conta" localizado nesta página e siga as instruções para se cadastrar rapidamente.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2"
              aria-expanded="false" aria-controls="faq2">
              Posso divulgar meu negócio no Brincaqui?
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading"
            data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Sim! Basta clicar em "Divulgar meu negócio" e preencher as informações do seu estabelecimento.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq3-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3"
              aria-expanded="false" aria-controls="faq3">
              O serviço é gratuito?
            </button>
          </h2>
          <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading"
            data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Sim, o Brincaqui é totalmente gratuito para usuários e estabelecimentos.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq4-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4"
              aria-expanded="false" aria-controls="faq4">
              Como encontro locais próximos a mim?
            </button>
          </h2>
          <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4-heading"
            data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Use a busca na página inicial e, se quiser, permita o acesso à sua localização para ver opções próximas.
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="bg-gradient-1 text-white pt-4 mt-5" style="height: 180px;">
      <img src="<?php echo BASE_URL; ?>/img/logo.png" style="max-width: 150px;" alt="BrincAqui" class="mx-auto d-block">
      <p class="text-center small mt-3">© BrincAqui, 2025. Todos os direitos reservados.</p>
    </div>

  </div>
  <script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/renderPlayCard.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/authGuard.js"></script>
  <script src="<?php echo BASE_URL ?>/scripts/getComName.js"></script>

  <script>
    $("#btn-register-type1").click(function () {
      sessionStorage.setItem("user_type", "1");
      window.location.href = "cadastro";
    });

    $("#btn-register-type2").click(function () {
      sessionStorage.setItem("user_type", "2");
      window.location.href = "cadastro";
    });

  </script>

  <script>
    $(document).ready(function () {
      $.get("components/playCard.php", function (templateHtml) {
        $.ajax({
          type: "GET",
          url:
            SERVER_URL +
            "play?latitude=0&longitude=0&order_by=grade&order_dir=DESC",
          success: (response) => {
            const container = $("#best");
            container.empty();

            if (!response.return || response.return.length === 0) {
              container.html("<p class='text-muted'>Nenhum lugar, ainda!</p>");
              return;
            }

            response.return.forEach(function (item) {
              const $card = renderPlayCard(item, templateHtml, {
                detailsType: "default",
              });
              container.append($card);

            });
          },
          error: (xhr) => {
            error_validation(xhr);
          },
        });
      });
    });
  </script>
</body>

</html>