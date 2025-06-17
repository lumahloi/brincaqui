$("#form-submit").click(function (event) {
  event.preventDefault();
  var input_email = $("#form-email").val();
  var input_password = $("#form-password").val();

  $.ajax({
    type: "POST",
    url: SERVER_URL + "auth/login.php",
    contentType: "application/json",
    data: JSON.stringify({
      email: input_email,
      password: input_password,
    }),
    xhrFields: {
      withCredentials: true,
    },
    success: () => {
      window.location = "pesquisa";
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
