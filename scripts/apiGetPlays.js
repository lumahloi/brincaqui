let currentPage = 0;
const perPage = 10;
let totalPages = 0;
let hasFetched = false;

$(document).ready(() => {
  $("#pagination").css('display', 'none');

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
    // Mostra a paginação com flex (como definido no seu HTML original)
    $("#pagination").css('display', 'flex');
    $("#current-page").text(`Página ${currentPage + 1}`);
    
    // Controle dos botões
    $("#prev-page").toggle(currentPage > 0);
    $("#next-page").toggle(currentPage + 1 < totalPages);
  } else {
    // Esconde completamente a paginação
    $("#pagination").css('display', 'none');
  }
}

function renderCards(response) {
  const container = $("#results");
  container.empty();

  const total = response?.return[0]?.total ?? 0;
  console.log(total)
  hasFetched = true;

  if (total === 0) {
    container.html("<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>");
    $("#pagination").css('display', 'none');
  } else {
    response.return.forEach((item) => {
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
        error_validation(xhr);
        hasFetched = true;
        updatePaginationControls(0); 
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
