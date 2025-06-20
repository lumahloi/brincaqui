function formatPhone(phone) {
  phone = String(phone).replace(/\D/g, "");
  if (phone.length === 11) {
    return phone.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
  } else if (phone.length === 10) {
    return phone.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
  }
  return phone;
}

function formatCep(cep) {
  cep = String(cep).replace(/\D/g, "");
  if (cep.length === 8) {
    return cep.replace(/(\d{5})(\d{3})/, "$1-$2");
  }
  return cep;
}

function renderPrices(prices) {
  let html = "";
  if (typeof prices === "string") {
    try {
      prices = JSON.parse(prices);
    } catch {
      prices = [];
    }
  }
  if (Array.isArray(prices)) {
    prices.forEach((price) => {
      html += `
        <div class="card col-auto">
          <div class="card-body p-3 mx-auto text-center">
            <span class="card-title small text-center">${
              price.prices_title
            }</span>
            <h4 class="card-text text-center mt-2">R$ ${Number(
              price.prices_price
            ).toFixed(2)}</h4>
          </div>
        </div>
      `;
    });
  }
  return html;
}

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

function renderPlayDetails(item) {
  let html = "";

  if (item.brinquedo[0].brin_pictures) {
    html += `
<div id="play-pictures" class="col">${item.brinquedo[0].brin_pictures}</div>`;
  }

  html += `
<div class="d-grid gap-4">
  <div>
    <h4 id="play-name" class="fw-bold mb-2">${item.brinquedo[0].brin_name}</h4>
    <div class="mt-3">
      <div class="row">
        <div class="col"><i class="bi bi-star-fill"></i> <span id="play-grade" class="brin-grade">${item.brinquedo[0].brin_grade} ${getClassificacaoLabel(item.brinquedo[0].brin_grade)}</span></div>
        <div class="col"><i class="bi bi-geo-alt-fill"></i> <span id="play-distance">${item.brinquedo[0].distance ?? 0} km</span></div>
      </div>
      <div class="row">
        <div class="col"><i id="btn-favorite"></i> <span>${item.brinquedo[0].brin_faves} favoritos</span></div>
        <div class="col"><i class="bi bi-emoji-smile-fill"></i> <span id="play-visits">${item.brinquedo[0].brin_visits} visitas</span></div>
      </div>
    </div>
  </div>
  `;

  if (item.brinquedo[0].brin_description) {
    html += `
  <p class="mb-0">${item.brinquedo[0].brin_description}</p>
    `;
  }

  html += `
  <div>
    <p class="fw-bold mb-2">Contato</p>
    <div class="d-flex align-items-center"><i class="bi bi-telephone-fill me-2"></i><span>${formatPhone(
      item.brinquedo[0].brin_telephone
    )}</span></div>
    <div class="d-flex align-items-center"><i class="bi bi-envelope-fill me-2"></i><span>${
      item.brinquedo[0].brin_email
    }</span></div>
  </div>
  <div>
    <p class="fw-bold mb-2">Redes sociais</p>
  `;

  let socialsHtml = "";
  if (item.brinquedo[0].brin_socials) {
    let socials;
    try {
      socials =
        typeof item.brinquedo[0].brin_socials === "string"
          ? JSON.parse(item.brinquedo[0].brin_socials)
          : item.brinquedo[0].brin_socials;
    } catch (e) {
      socials = [];
    }

    if (Array.isArray(socials)) {
      socials.forEach((social) => {
        const [network, url] = Object.entries(social)[0];
        let icon = "";
        if (network.toLowerCase().includes("facebook")) {
          icon = '<i class="bi bi-facebook me-1"></i>';
        } else if (network.toLowerCase().includes("instagram")) {
          icon = '<i class="bi bi-instagram me-1"></i>';
        } else if (network.toLowerCase().includes("whatsapp")) {
          icon = '<i class="bi bi-whatsapp me-1"></i>';
        } else {
          icon = '<i class="bi bi-link-45deg me-1"></i>';
        }
        socialsHtml += `<a href="${url}" target="_blank" class="me-2">${icon}</a>`;
      });
    } else if (typeof socials === "object" && socials !== null) {
      const [network, url] = Object.entries(socials)[0];
      let icon = "";
      if (network.toLowerCase().includes("facebook")) {
        icon = '<i class="bi bi-facebook me-1"></i>';
      } else if (network.toLowerCase().includes("instagram")) {
        icon = '<i class="bi bi-instagram me-1"></i>';
      } else if (network.toLowerCase().includes("whatsapp")) {
        icon = '<i class="bi bi-whatsapp me-1"></i>';
      } else {
        icon = '<i class="bi bi-link-45deg me-1"></i>';
      }
      socialsHtml += `<a href="${url}" target="_blank" class="me-2">${icon}</a>`;
    }
  }

  let agesText = "";
  if (item.brinquedo[0].brin_ages) {
    let ages = item.brinquedo[0].brin_ages;
    if (typeof ages === "string") {
      try {
        ages = JSON.parse(ages);
      } catch (e) {}
    }
    if (Array.isArray(ages)) {
      agesText = ages.join(", ");
    } else if (typeof ages === "string") {
      agesText = ages;
    }
  }

  html += `
    ${socialsHtml}
  </div>
    <div>
      <span class="fw-bold">Faixa etária</span>
      <p class="mb-0">${agesText}.</p>
    </div>
    <div>
      <span class="fw-bold">Horários de funcionamento</span>
  `;

  let timesHtml = "";
  if (item.brinquedo[0].brin_times) {
    let times = item.brinquedo[0].brin_times;
    if (typeof times === "string") {
      try {
        times = JSON.parse(times);
      } catch (e) {
        times = [];
      }
    }
    if (Array.isArray(times) && times.length > 0) {
      const dayOrder = [
        "domingo",
        "segunda",
        "terca",
        "quarta",
        "quinta",
        "sexta",
        "sabado",
        "feriado",
      ];
      const dayLabels = {
        domingo: "Domingo",
        segunda: "Segunda",
        terca: "Terça",
        quarta: "Quarta",
        quinta: "Quinta",
        sexta: "Sexta",
        sabado: "Sábado",
        feriado: "Feriado",
      };

      let timesObj = {};
      times.forEach((obj) => {
        const [day, hour] = Object.entries(obj)[0];
        timesObj[day] = hour;
      });

      timesHtml += `<table class="table table-sm w-100"><tbody>`;
      dayOrder.forEach((day) => {
        if (timesObj[day]) {
          timesHtml += `
            <tr>
              <td class="fw-bold">${dayLabels[day]}</td>
              <td>${timesObj[day]}</td>
            </tr>
          `;
        }
      });
      timesHtml += `</tbody></table>`;
    }
  }

  html += `
      <button class="btn btn-link btn-sm px-1 py-0" type="button" id="toggle-times">
        <span id="toggle-times-text"><i class="bi bi-caret-down-fill"></i></span>
      </button>
      <div id="times-container" style="display:none;">${timesHtml}</div>
    </div>
    <div class="d-grid gap-2">
      <h5 class="fw-bold text-gradient-1">Comodidades</h5>
      <div id="play-commodities"></div>
    </div>
    <div class="d-grid gap-2">
      <h5 class="fw-bold text-gradient-1">Preços</h5>
      <div class="row d-flex gap-2 justify-content-center">${renderPrices(
        item.brinquedo[0].brin_prices
      )}</div>
      <div id="play-discounts" class="row"></div>
    </div>
    <div class="d-grid gap-2">
      <h5 class="fw-bold text-gradient-1">Avaliações</h5>
      <h5><i class="bi bi-star-fill"></i> <span id="play-grade" class="brin-grade">${
        item.brinquedo[0].brin_grade
      } ${getClassificacaoLabel(item.brinquedo[0].brin_grade)}</span></h5>
      <p class="mb-0">Com base em  ${
        item.total_avaliacoes
      } avaliações dos nossos usuários.</p>

      <div class="row justify-content-center gap-2 pt-3" id="no-gutter">
        <div class="col-auto card text-center p-2" style="min-width: 90px;">
          <div class="row text-center pb-1"><i class="bi bi-shield-fill fs-6"></i></div>
          <p class="text-center small mb-0">Segurança</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_2)}</span>
        </div>
        <div class="col-auto card text-center p-2" style="min-width: 90px;">
          <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-stars fs-6"></i></div>
          <p class="text-center small mb-0">Limpeza</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_3)}</span>
        </div>
        <div class="col-auto card text-center p-2">
          <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-emoji-grin-fill fs-6"></i></div>
          <p class="text-center small mb-0">Brinquedos e atrações</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_4)}</span>
        </div>
        <div class="col-auto card text-center p-2" style="min-width: 90px;">
          <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-geo-alt-fill fs-6"></i></div>
          <p class="text-center small mb-0">Localização</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_5)}</span>
        </div>
        <div class="col-auto card text-center p-2" style="min-width: 90px;">
          <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-currency-dollar fs-6"></i></div>
          <p class="text-center small mb-0">Preço</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_6)}</span>
        </div>
        <div class="col-auto card text-center p-2" style="min-width: 90px;">
          <div class="row text-center pb-1" id="no-gutter"><i class="bi bi-person-wheelchair fs-6"></i></div>
          <p class="text-center small mb-0">Acessibilidade</p>
          <span>${getClassificacaoLabel(item.brinquedo[0].brin_grade_7)}</span>
        </div>
      </div>
    </div>
    <div class="d-grid gap-2">
      <h5 class="fw-bold text-gradient-1">Avaliações dos usuários</h5>
      <div id="feedbacks" class="d-flex flex-column gap-2"></div>
      <span id="show-more" class="mt-1 text-center"></span>
    </div>
    <div class="d-grid gap-2">
      <h5 class="fw-bold text-gradient-1">Localização</h5>

      <a 
        href="https://www.google.com/maps?q=${item.brinquedo[0].add_latitude},${
    item.brinquedo[0].add_longitude
  }" 
        target="_blank" 
        rel="noopener noreferrer"
      >
        <iframe
          width="100%"
          height="250"
          style="border:0; pointer-events: none;"
          loading="lazy"
          allowfullscreen
          referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps?q=${item.brinquedo[0].add_latitude},${
    item.brinquedo[0].add_longitude
  }&hl=pt-BR&z=16&output=embed"
        ></iframe>
      </a>


      <p class="mb-0">${item.brinquedo[0].add_streetnum} - ${item.brinquedo[0].add_neighborhood}, ${
    item.brinquedo[0].add_city
  } - ${item.brinquedo[0].add_state}, ${formatCep(item.brinquedo[0].add_cep)}</p>
    </div>
    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 1): ?>
      <button type="submit" class="btn btn-primary btn-visita bg-gradient-1 border-0" data-brin-id="${
        item.brinquedo[0].brin_id
      }">Visitarei este lugar</button>
    <?php endif; ?>
    </div>
`;

  return html;
}
