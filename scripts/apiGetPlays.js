let currentPage = 0;
const perPage = 6;

function updatePaginationControls(response) {
  const total = response.total ?? 0;
  const totalPages = Math.ceil(total / perPage);

  $("#current-page").text(`Página ${currentPage + 1}`);

  $("#prev-page").prop("disabled", currentPage === 0);
  $("#next-page").prop("disabled", currentPage + 1 >= totalPages);
}

function renderCards(response) {
  const container = $("#results");
  container.empty();

  if (!response.return.total || response.return.total === 0) {
    container.html(
      "<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>"
    );
    return;
  }

  response.return.results.forEach(function (item) {
    $.get("/components/playCard.php", function (template) {
      const $card = renderPlayCard(item, template);
      container.append($card);
    });
  });

  updatePaginationControls(response);
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
      error: (xhr) => error_validation(xhr),
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

$("#form-filters").submit(function (e) {
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
  currentPage++;
  fetchPlays();
});
