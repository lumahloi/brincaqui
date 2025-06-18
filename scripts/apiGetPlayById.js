$(document).ready(function () {
  const path = window.location.pathname;
  const match = path.match(/-(\d+)$/);
  if (!match) {
    $("#play").html("<p class='text-muted mx-auto'>Lugar não encontrado.</p>");
    return;
  }
  const playId = match[1];

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play/" + playId,
    xhrFields: {
      withCredentials: true,
    },
    success: (response) => {
      const container = $("#play");
      container.empty();

      if (!response.return) {
        container.html(
          "<p class='text-muted mx-auto'>Lugar não encontrado.</p>"
        );
        return;
      }

      let item = response.return[0];

      let html = "";

      if (item.brin_pictures) {
        html += `
        <div id="play-pictures" class="col">
          ${item.brin_pictures}
        </div>`;
      }

      html += `
        <div class="d-grid gap-5">
          <div class="d-grid gap-3">
            <h4 id="play-name" class="fw-bold">${item.brin_name}</h4>

            <div>
              <div class="row">
                <div class="col"><i class="bi bi-star-fill"></i> <span id="play-grade" class="brin-grade">${item.brin_grade}</span></div>

                <div class="col"><i class="bi bi-geo-alt-fill"></i> <span id="play-distance">${item.distance ?? 0} km</span></div>
              </div>
              
              <div class="row mt-2">
                <div class="col"><i class="bi bi-heart-fill"></i> <span id="play-favorites">${item.brin_faves} favoritos</span></div>

                <div class="col"><i class="bi bi-emoji-smile-fill"></i> <span id="play-visits">${item.brin_visits} visitas</span></div>
              </div>

            </div>
      `;

      if (item.brin_description) {
        html += `
            <p class="mb-0">${item.brin_description}</p>
        `;
      }

      html += `
            <div>
              <p class="fw-bold mb-0">Contato</p>

              <div class="d-flex align-items-center"><i class="bi bi-telephone-fill me-2"></i><span>${item.brin_telephone}</span></div>

              <div class="d-flex align-items-center"><i class="bi bi-envelope-fill me-2"></i><span>${item.brin_email}</span></div>
            </div>

            <div>
              <p class="fw-bold mb-0">Redes sociais</p>
      `;

      let socialsHtml = "";
      if (item.brin_socials) {
        let socials;
        try {
          socials =
            typeof item.brin_socials === "string"
              ? JSON.parse(item.brin_socials)
              : item.brin_socials;
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
      if (item.brin_ages) {
        let ages = item.brin_ages;
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
      if (item.brin_times) {
        let times = item.brin_times;
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

              <div id="times-container" style="display:none;">
                ${timesHtml}
              </div>
            </div>


            <div class="d-grid gap-2">
              <h5>Comodidades</h5>
              <div id="play-commodities"></div>
            </div>


            <div class="d-grid gap-2">
              <h5>Preços</h5>
              ${item.brin_prices}
      `;

      if (item.brin_discounts) {
        html += `
              ${item.brin_description}
        `;
      }

      html += `
            </div>

            <div class="d-grid gap-2">
              <h5>Avaliações</h5>
              <h5><i class="bi bi-star-fill"></i> <span id="play-grade" class="brin-grade">${item.brin_grade}</span></h5>
              <p class="mb-0">Com base em X avaliações</p>
            </div>


            <div class="d-grid gap-2">
              <h5>Avaliações dos usuários</h5>
            </div>

            <div class="d-grid gap-2">
              <h5>Localização</h5>
              <p class="mb-0">${item.add_streetnum} - ${item.add_neighborhood}, ${item.add_city} - ${item.add_state}, ${item.add_cep}</p>
            </div>

            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 1): ?>
              <button type="submit" class="btn btn-primary btn-visita" data-brin-id="${item.brin_id}">Visitarei este lugar</button>
            <?php endif; ?>
          </div>
      `;

      container.html(html);

      $("#toggle-times").on("click", function () {
        const $container = $("#times-container");
        const $text = $("#toggle-times-text");
        if ($container.is(":visible")) {
          $container.slideUp(150);
          $text.html("<i class='bi bi-caret-down-fill'></i>");
        } else {
          $container.slideDown(150);
          $text.html("<i class='bi bi-caret-up-fill'></i>");
        }
      });

      let commodities = item.brin_commodities;

      commodities = (
        Array.isArray(commodities)
          ? commodities
          : String(commodities || "").split(",")
      )
        .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
        .filter((id) => !isNaN(id));

      let $commoditiesContainer = $("#play-commodities");
      $commoditiesContainer.empty();

      for (let i = 0; i < commodities.length; i += 2) {
        let row = $('<div class="row mb-2"></div>');
        let col1 = $('<div class="col"></div>');
        getComNameByPlay(String(commodities[i]), col1);
        row.append(col1);

        if (commodities[i + 1] !== undefined) {
          let col2 = $('<div class="col"></div>');
          getComNameByPlay(String(commodities[i + 1]), col2);
          row.append(col2);
        }

        $commoditiesContainer.append(row);
      }

      let discounts = item.brin_discounts;
      discounts = (
        Array.isArray(discounts)
          ? discounts
          : String(discounts || "").split(",")
      )
        .map((item) => parseInt(String(item).replace(/[^\d]/g, ""), 10))
        .filter((id) => !isNaN(id));

      discounts.forEach((discountId) => {
        getDiscNameByPlay(String(discountId), $("#play-discounts"));
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
