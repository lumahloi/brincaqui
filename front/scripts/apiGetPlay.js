$("#form-filters").submit(function (event) {
  event.preventDefault();

  const params = {};
  $(this).serializeArray().forEach(({ name, value }) => {
    if (value) params[name] = value;
  });

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play",
    data: params,
    success: (response) => {
      const container = $("#results");
      container.empty();

      if (!response.return || response.return.length === 0) {
        container.html("<p class='text-muted'>Nenhum resultado encontrado.</p>");
        return;
      }

      response.return.forEach(function (item) {
        $.get("front/components/playCard.html", function (template) {
          let $card = $(template);
          $card.find("#play-name").text(item.brin_name);
          $card.find("#play-pictures").text(item.brin_pictures);
          $card.find("#play-grade").text(item.brin_grade);
          $card.find("#play-socials").text(item.brin_socials);
          $card.find("#play-description").text(item.brin_description);
          $card.find("#play-times").text(item.brin_times);
          $card.find("#play-commodities").text(item.brin_commodities);
          $card.find("#play-prices").text(item.brin_prices);
          $card.find("#play-discounts").text(item.brin_discounts);
          $card.find("#play-telephone").text(item.brin_telephone);
          $card.find("#play-email").text(item.brin_email);
          $card.find("#play-cnpj").text(item.brin_cnpj);
          $card.find("#play-ages").text(item.brin_ages);
          $card.find("#play-owner").text(item.Usuario_user_id);
          $card.find("#play-faves").text(item.brin_faves);
          $card.find("#play-visits").text(item.brin_visits);
          container.append($card);
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
