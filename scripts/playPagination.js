function createPlayPagination(fetchFunction, options = {}) {
  let currentPage = 0;
  const perPage = options.perPage || 10;
  let totalPages = 0;
  let hasFetched = false;

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

  function updateUrlParams(params) {
    const url = new URL(window.location);
    const keys = [];
    url.searchParams.forEach((_, key) => keys.push(key));
    keys.forEach(key => url.searchParams.delete(key));

    Object.entries(params).forEach(([key, value]) => {
      if (Array.isArray(value)) {
        value.forEach(v => url.searchParams.append(key, v));
      } else if (value !== undefined && value !== null) {
        url.searchParams.set(key, value);
      }
    });

    url.searchParams.set('page', currentPage);
    window.history.replaceState({}, '', url);
  }

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

  function updatePaginationControls(total) {
    totalPages = Math.ceil(total / perPage);
    if (hasFetched && totalPages > 1) {
      $("#pagination").css("display", "flex");
      $("#current-page").text(`Página ${currentPage + 1}`);
      $("#prev-page").toggle(currentPage > 0);
      $("#next-page").toggle(currentPage + 1 < totalPages);
    } else {
      $("#pagination").css("display", "none");
    }
  }

  function renderCards(response) {
    const container = $("#results");
    container.empty();

    const total = response?.return[0]?.total ?? 0;
    hasFetched = true;

    if (total === 0) {
      container.html("<p class='text-muted mx-auto'>Nenhum resultado encontrado.</p>");
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
    $("#form-filters").serializeArray().forEach(({ name, value }) => {
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

    sessionStorage.setItem('lastSearch', JSON.stringify({
      params,
      currentPage
    }));

    updateUrlParams(params);

    fetchFunction(params, renderCards, () => {
      hasFetched = true;
      updatePaginationControls(0);
    });
  }

  function init() {
    const urlParams = readUrlParams();
    const savedSearch = sessionStorage.getItem('lastSearch');

    if (Object.keys(urlParams).length > 0) {
      fillFormWithParams(urlParams);
      fetchPlays();
    } else if (savedSearch) {
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
  }

  return {
    init,
    fetchPlays
  };
}
