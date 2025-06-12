$("#form-submit").click(function () {
  var input_email = $("#form-email").val();
  var input_password = $("#form-password").val();

  $.ajax({
    type: "POST",
    url: SERVER_URL + "auth/login.php",
    contentType: "application/json",
    data: JSON.stringify({
      email: input_email,
      password: input_password
    }),
    success: () => {
      window.location = "index.php";
      sessionStorage.removeItem("user_type");
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
