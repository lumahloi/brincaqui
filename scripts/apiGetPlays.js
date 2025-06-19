let currentPage = 0;
const perPage = 1;
let totalPages = 0;
let hasFetched = false; // novo controle

// Garante que a paginação esteja sempre oculta no carregamento inicial
$(document).ready(() => {
  $("#pagination").hide();

  // Ativa eventos apenas após carregar a página
  $("#form-filters").on("submit", function (e) {
    e.preventDefault();
    currentPage = 0;
    fetchPlays();
  });

  $("#prev-page").on("click", function () {
    if (currentPage > 0) {
      currentPage--;
      fetchPlays();
    }
  });

  $("#next-page").on("click", function () {
    if (currentPage + 1 < totalPages) {
      currentPage++;
      fetchPlays();
    }
  });
});

function updatePaginationControls(total) {
  totalPages = Math.ceil(total / perPage);

  if (hasFetched && totalPages > 1) {
    $("#pagination").show();
    $("#current-page").text(`Página ${currentPage + 1}`);
    $("#prev-page").prop("disabled", currentPage === 0);
    $("#next-page").prop("disabled", currentPage + 1 >= totalPages);
  } else {
    $("#pagination").hide();
  }
}

function renderCards(response) {
  const container = $("#results");
  container.empty();

  const total = response?.return?.total ?? 0;
  hasFetched = true; // agora sabemos que houve pelo menos uma busca

  if (total === 0) {
    container.html("<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>");
  } else {
    response.return.results.forEach((item) => {
      $.get("/components/playCard.php", function (template) {
        const $card = renderPlayCard(item, template);
        container.append($card);
      });
    });
  }

  updatePaginationControls(total);
}

function fetchPlays() {
  const params = {};
  $("#form-filters")
    .serializeArray()
    .forEach(({ name, value }) => {
      if (params[name]) {
        if (!Array.isArray(params[name])) {
          params[name] = [params[name]];
        }
        params[name].push(value);
      } else {
        params[name] = value;
      }
    });

  ["ages", "commodities", "discounts"].forEach((field) => {
    if (params[field] && !Array.isArray(params[field])) {
      params[field] = [params[field]];
    }
  });

  params.page = currentPage;
  params.per_page = perPage;

  if (!params.order_by) {
    params.order_by = "distance";
  }

  const ajaxCall = () => {
    $.ajax({
      type: "GET",
      url: SERVER_URL + "play",
      data: params,
      success: renderCards,
      error: (xhr) => {
        console.error("Erro ao buscar dados:", xhr);
        hasFetched = true;
        updatePaginationControls(0); // garante que paginador suma
      },
    });
  };

  if (classificacoes) {
    ajaxCall();
  } else {
    $.getJSON("../public/classificacao.json", function (data) {
      classificacoes = data;
      ajaxCall();
    });
  }
}
