$("#form-submit").click(function (event) {
  event.preventDefault();
  // var input_email = $("#form-place").val();

  $.ajax({
    type: "GET",
    url: SERVER_URL + "play",
    contentType: "application/json",
    // data: JSON.stringify({
    //   email: input_email
    // }),
    success: (response) => {
      let container = $("#results");
      container.html(""); 

      response.return.forEach(function (item) {
        $.get("front/components/playCard.html", function (template) {
          let $card = $(template);
          $card.find(".title").text(item.brin_id);
          container.append($card);
        });
      });
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
