function getFeedback(playId) {
  fetch(`/api/feedback/${playId}?per_page=3`)
    .then((response) => {
      if (!response.ok) throw new Error("Erro ao carregar feedbacks");
      return response.json();
    })
    .then((data) => {
      renderFeedbacks(data);
    })
    .catch((error) => {
      console.error("Erro:", error);
      document.getElementById("feedbacks").innerHTML =
        "<p>Erro ao carregar feedbacks.</p>";
    });

  function renderFeedbacks(feedbacks) {
    const container = document.getElementById("feedbacks");
    container.innerHTML = "";

    if (!feedbacks.return || feedbacks.return.length === 0) {
      container.innerHTML = "<p>Nenhum feedback ainda.</p>";
      return;
    }

    feedbacks.return.forEach((fb) => {
      const fbEl = document.createElement("div");
      fbEl.className = "p-3 card rounded";

      let html = `
        <a class="text-decoration-none text-black" href=""><div class="d-flex flex-row">
          <span class="col w-100 fw-bold mb-1">${fb.user_name}</span>
          <span class="col-3 small text-muted mb-3 date-relative" data-date="${
            fb.aval_date
          }"></span>
        </div>
        <div class="d-flex flex-row gap-3">
          <div class="d-flex flex-row gap-2 align-items-center">
            <div class="col-auto">
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="col-auto">
              ${fb.aval_grade_1}
            </div>
            <div class="col-auto">
              ${getClassificacaoLabel(fb.aval_grade_1)}
            </div>
          </div>
        </div>        
      `;

      if (fb.aval_description && fb.aval_description !== "") {
        html += `<p class="small mt-2 overflow-hidden mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-overflow: ellipsis;">${fb.aval_description}</p>`;
      }

      html += `</a>`;

      fbEl.innerHTML = html;

      container.appendChild(fbEl);
    });

    document.querySelectorAll(".date-relative").forEach((el) => {
      const dateStr = el.getAttribute("data-date");
      const relativeTime = dayjs(dateStr).fromNow();
      el.textContent = relativeTime;
    });
  }
}
