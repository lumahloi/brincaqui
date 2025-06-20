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

function renderFeedbackDetails(item) {
  let html = "";

  html += `
    <div class="p-3 card rounded">
      <div class="d-flex flex-row">
        <span class="col w-100 fw-bold mb-1">${item.user_name}</span>
        <span class="col-3 small text-muted mb-3 date-relative" data-date="${
          item.aval_date
        }"></span>
      </div>

      <div class="d-flex flex-row gap-3">
        <div class="d-flex flex-row gap-2 align-items-center">
          <div class="col-auto">
            <i class="bi bi-star-fill"></i>
          </div>
          <div class="col-auto">${item.aval_grade_1}</div>
          <div class="col-auto">${getClassificacaoLabel(
            item.aval_grade_1
          )}</div>
        </div>
      </div>
    
  `;

  if (item.aval_description && item.aval_description !== "") {
    html += `
      <p class="small mt-2 mb-0">${item.aval_description}</p>
    `;
  }

  html += `
      <div class="d-flex flex-column gap-2 mt-3">
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-shield-fill pe-1 ps-1"></i>
            <span class="fw-bold">Segurança</span>
          </div>
          <div class="col">
            ${item.aval_grade_2}
            <span>${getClassificacaoLabel(item.aval_grade_2)}</span>
          </div>
        </div>
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-stars pe-1 ps-1"></i>
            <span class="fw-bold">Limpeza</span>
          </div>
          <div class="col">
            ${item.aval_grade_3}
            <span>${getClassificacaoLabel(item.aval_grade_3)}</span>
          </div>
        </div>
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-emoji-grin-fill pe-1 ps-1"></i>
            <span class="fw-bold">Brinquedos e atrações</span>
          </div>
          <div class="col">
            ${item.aval_grade_4}
            <span>${getClassificacaoLabel(item.aval_grade_4)}</span>
          </div>
        </div>
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-geo-alt-fill pe-1 ps-1"></i>
            <span class="fw-bold">Localização</span>
          </div>
          <div class="col">
            ${item.aval_grade_5}
            <span>${getClassificacaoLabel(item.aval_grade_5)}</span>
          </div>
        </div>
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-currency-dollar pe-1 ps-1"></i>
            <span class="fw-bold">Preço</span>
          </div>
          <div class="col">
            ${item.aval_grade_6}
            <span>${getClassificacaoLabel(item.aval_grade_6)}</span>
          </div>
        </div>
        <div class="d-flex flex-row gap-2">
          <div class="col">
            <i class="bi bi-person-wheelchair pe-1 ps-1"></i>
            <span class="fw-bold">Acessibilidade</span>
          </div>
          <div class="col">
            ${item.aval_grade_7}
            <span>${getClassificacaoLabel(item.aval_grade_7)}</span>
          </div>
        </div>
      </div>
    </div>
  `;

  return html;
}
