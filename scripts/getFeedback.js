function getClassificacaoLabel(grade) {
  grade = Number(grade);
  for (let i = 0; i < classificacoes.length; i++) {
    const c = classificacoes[i];
    if (grade >= c.min && grade <= c.max) {
      return c.label;
    }
  }
  return "";
}

function createFeedbackPagination(
  playId,
  baseApiUrl,
  totalFeedbacks,
  options = {}
) {
  let currentPage = 0;
  const perPage = options.perPage;
  const enablePagination = options.enablePagination || false;
  const container = document.getElementById("feedbacks");
  const paginationEl = document.getElementById("pagination");

  function fetchAndRender() {
    const url = `${baseApiUrl}?page=${currentPage}&per_page=${perPage}`;

    fetch(url)
      .then((response) => {
        if (!response.ok) throw new Error("Erro ao carregar feedbacks");
        return response.json();
      })
      .then((data) => {
        renderFeedbacks(data.return, playId, totalFeedbacks);
        if (enablePagination)
          updatePaginationControls(data.return.total_avaliacoes);
      })
      .catch((error) => {
        console.error("Erro:", error);
        if (container) {
          container.innerHTML = "<p>Erro ao carregar feedbacks.</p>";
        }
        if (paginationEl) {
          paginationEl.style.display = "none";
        }
      });
  }

  function renderFeedbacks(feedbacks, playId, totalFbs) {
    if (!container) return;
    container.innerHTML = "";

    if (totalFbs === 0) {
      container.innerHTML = "<p>Nenhum feedback ainda.</p>";
      return;
    }

    feedbacks.avaliacoes.forEach((fb) => {
      const fbEl = document.createElement("div");
      fbEl.className = "p-3 card rounded";

      let html = `
        <a class="text-decoration-none text-black" href="/avaliacao/${
          fb.aval_id
        }">
          <div class="d-flex flex-row">
            <span class="col w-100 fw-bold mb-1">${fb.user_name}</span>
            <span class="col-3 small text-muted mb-3 date-relative" data-date="${
              fb.aval_date
            }"></span>
          </div>
          <div class="d-flex flex-row gap-3">
            <div class="d-flex flex-row gap-2 align-items-center">
              <div class="col-auto"><i class="bi bi-star-fill"></i></div>
              <div class="col-auto">${fb.aval_grade_1}</div>
              <div class="col-auto">${getClassificacaoLabel(
                fb.aval_grade_1
              )}</div>
            </div>
          </div>`;

      if (fb.aval_description && fb.aval_description !== "") {
        html += `
          <p class="small mt-2 overflow-hidden mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-overflow: ellipsis;">
            ${fb.aval_description}
          </p>`;
      }

      html += `</a>`;

      fbEl.innerHTML = html;
      container.appendChild(fbEl);
    });

    if (!enablePagination && totalFbs > perPage) {
      const showMore = document.getElementById("show-more");
      if (showMore) {
        const slug = feedbacks.avaliacoes[0].brin_name
          .toLowerCase()
          .normalize("NFD")
          .replace(/[\u0300-\u036f]/g, "")
          .replace(/[^a-z0-9]+/g, "-")
          .replace(/^-+|-+$/g, "");

        showMore.innerHTML = `<a href='/avaliacoes/${slug}-${playId}' class='text-gradient-1 fw-bold'>Ver mais</a>`;
      }
    }

    document.querySelectorAll(".date-relative").forEach((el) => {
      const dateStr = el.getAttribute("data-date");
      const relativeTime = dayjs(dateStr).fromNow();
      el.textContent = relativeTime;
    });
  }

  function updatePaginationControls(total) {
    const totalPages = Math.ceil(total / perPage);
    if (paginationEl && totalPages > 1) {
      paginationEl.style.display = "flex";
      document.getElementById("current-page").textContent = `Página ${
        currentPage + 1
      }`;
      document.getElementById("prev-page").style.display =
        currentPage > 0 ? "block" : "none";
      document.getElementById("next-page").style.display =
        currentPage + 1 < totalPages ? "block" : "none";
    } else if (paginationEl) {
      paginationEl.style.display = "none";
    }
  }

  function setupPaginationEvents() {
    if (!enablePagination) return;

    document.getElementById("prev-page")?.addEventListener("click", () => {
      if (currentPage > 0) {
        currentPage--;
        fetchAndRender();
      }
    });

    document.getElementById("next-page")?.addEventListener("click", () => {
      const totalPages = Math.ceil(totalFeedbacks / perPage);
      if (currentPage + 1 < totalPages) {
        currentPage++;
        fetchAndRender();
      }
    });
  }

  function init() {
    fetchAndRender();
    setupPaginationEvents();
  }

  return {
    init,
  };
}
