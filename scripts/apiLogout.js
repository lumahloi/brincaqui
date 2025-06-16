$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: SERVER_URL + "auth/logout.php",
    contentType: "application/json",
    // data: JSON.stringify({
    //   email: input_email,
    //   password: input_password
    // }),
    success: () => {
      window.location = "index";
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
