// apigetplays.js

let currentPage = 0;
const perPage = 10;
let totalPages = 0;
let hasFetched = false;

// Função para ler parâmetros da URL
function readUrlParams() {
  const url = new URL(window.location);
  const params = {};
  
  url.searchParams.forEach((value, key) => {
    if (key === 'page') {
      currentPage = parseInt(value) || 0;
      return;
    }
    
    if (params[key]) {
      if (!Array.isArray(params[key])) {
        params[key] = [params[key]];
      }
      params[key].push(value);
    } else {
      params[key] = value;
    }
  });
  
  return params;
}

// Função para atualizar parâmetros na URL
function updateUrlParams(params) {
  const url = new URL(window.location);
  
  // Limpar parâmetros existentes
  const keys = [];
  url.searchParams.forEach((_, key) => keys.push(key));
  keys.forEach(key => url.searchParams.delete(key));
  
  // Adicionar novos parâmetros
  Object.entries(params).forEach(([key, value]) => {
    if (Array.isArray(value)) {
      value.forEach(v => url.searchParams.append(key, v));
    } else if (value !== undefined && value !== null) {
      url.searchParams.set(key, value);
    }
  });
  
  // Adicionar página atual
  url.searchParams.set('page', currentPage);
  
  // Atualizar URL sem recarregar a página
  window.history.replaceState({}, '', url);
}

// Função para preencher o formulário com os parâmetros
function fillFormWithParams(params) {
  Object.entries(params).forEach(([name, value]) => {
    const $element = $(`[name="${name}"]`);
    
    if ($element.is('select, input[type="text"], input[type="number"]')) {
      $element.val(value);
    } else if ($element.is('input[type="checkbox"], input[type="radio"]')) {
      if (Array.isArray(value)) {
        value.forEach(val => $(`[name="${name}"][value="${val}"]`).prop('checked', true));
      } else {
        $(`[name="${name}"][value="${value}"]`).prop('checked', true);
      }
    }
  });
}

$(document).ready(() => {
  // Verificar se há parâmetros na URL
  const urlParams = readUrlParams();
  const savedSearch = sessionStorage.getItem('lastSearch');
  
  // Priorizar parâmetros da URL se existirem
  if (Object.keys(urlParams).length > 0) {
    fillFormWithParams(urlParams);
    fetchPlays();
  } 
  // Se não houver parâmetros na URL, verificar sessionStorage
  else if (savedSearch) {
    const { params, currentPage: savedPage } = JSON.parse(savedSearch);
    currentPage = savedPage || 0;
    fillFormWithParams(params);
    fetchPlays();
  }

  $("#pagination").css('display', 'none');

  $("#form-filters").on('submit', function(e) {
    e.preventDefault();
    currentPage = 0;
    fetchPlays();
  });

  $("#prev-page").on('click', function() {
    if (currentPage > 0) {
      currentPage--;
      fetchPlays();
    }
  });

  $("#next-page").on('click', function() {
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
    $("#pagination").css("display", "flex");
    $("#current-page").text(`Página ${currentPage + 1}`);

    // Controle dos botões
    $("#prev-page").toggle(currentPage > 0);
    $("#next-page").toggle(currentPage + 1 < totalPages);
  } else {
    // Esconde completamente a paginação
    $("#pagination").css("display", "none");
  }
}

function renderCards(response) {
  const container = $("#results");
  container.empty();

  const total = response?.return[0]?.total ?? 0;
  console.log(total);
  hasFetched = true;

  if (total === 0) {
    container.html(
      "<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>"
    );
    $("#pagination").css("display", "none");
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

  // Salvar no sessionStorage
  sessionStorage.setItem('lastSearch', JSON.stringify({
    params,
    currentPage
  }));

  // Atualizar URL
  updateUrlParams(params);

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
    $.getJSON("../public/classificacao.json", function(data) {
      classificacoes = data;
      ajaxCall();
    });
  }
}
