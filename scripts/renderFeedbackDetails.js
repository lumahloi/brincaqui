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

  const editable = item.user_id == userId;

  html += `
    <div class="p-3 card rounded" data-id="${item.aval_id}">
      <div class="d-flex flex-row">
        <span class="col w-100 fw-bold mb-1">${item.user_name}</span>
        <span class="col-3 small text-muted mb-3 date-relative" data-date="${item.aval_date}"></span>
      </div>

      <div class="d-flex flex-row gap-3">
        <div class="d-flex flex-row gap-2 align-items-center">
          <div class="col-auto">
            <i class="bi bi-star-fill"></i>
          </div>
          <div class="col-auto">${item.aval_grade_1}</div>
          <div class="col-auto">${getClassificacaoLabel(item.aval_grade_1)}</div>
        </div>
      </div>
    
      <p class="small mt-2 mb-0" data-key="aval_description">${item.aval_description || ""}</p>
      <textarea class="form-control d-none mt-2 mb-2" data-edit="aval_description">${item.aval_description || ""}</textarea>
  `;

  const fields = [
    { label: "Segurança", key: "aval_grade_2", icon: "bi-shield-fill" },
    { label: "Limpeza", key: "aval_grade_3", icon: "bi-stars" },
    { label: "Brinquedos e atrações", key: "aval_grade_4", icon: "bi-emoji-grin-fill" },
    { label: "Localização", key: "aval_grade_5", icon: "bi-geo-alt-fill" },
    { label: "Preço", key: "aval_grade_6", icon: "bi-currency-dollar" },
    { label: "Acessibilidade", key: "aval_grade_7", icon: "bi-person-wheelchair" }
  ];

  html += `<div class="d-flex flex-column gap-2 mt-3">`;

  fields.forEach(({ label, key, icon }) => {
    const grade = item[key];
    html += `
      <div class="d-flex flex-row gap-2 align-items-center">
        <div class="col">
          <i class="bi ${icon} pe-1 ps-1"></i>
          <span class="fw-bold">${label}</span>
        </div>
        <div class="col" data-key="${key}">${grade} <span>${getClassificacaoLabel(grade)}</span></div>
        <input type="number" class="form-control d-none" data-edit="${key}" value="${grade}" min="0" max="10">
      </div>
    `;
  });

  html += `</div>`;

  if (editable) {
    html += `
      <span class="text-decoration-none text-black edit-btn" style="cursor:pointer;">
        <div class="row align-items-center ps-2 pe-2 mt-4">
          <div class="col-1 me-2"><i class="bi bi-pencil fs-5"></i></div>
          <div class="col w-100">Editar</div>
          <div class="col-1"><i class="bi bi-caret-right-fill fs-6"></i></div>
        </div>
      </span>

      <button class="btn btn-success mt-3 d-none save-edit-btn">Salvar alterações</button>
    `;
  }

  html += `</div>`;

  return html;
}

