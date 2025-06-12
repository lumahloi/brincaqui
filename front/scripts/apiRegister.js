$(document).ready(function () {
  const userType = sessionStorage.getItem("user_type");
  if (userType) {
    $("#form-user-type").val(userType);
  }
});

$("#form-submit").click(function () {
  var input_fullname = $("#form-fullname").val();
  var input_telephone = $("#form-telephone").val();
  var input_email = $("#form-email").val();
  var input_password = $("#form-password").val();
  var input_confirm_password = $("#form-confirm-password").val();
  var input_user_type = $("#form-user-type").val();

  $.ajax({
    type: "POST",
    url: SERVER_URL + "auth/register.php",
    contentType: "application/json",
    data: JSON.stringify({
      fullname: input_fullname,
      telephone: input_telephone,
      email: input_email,
      password: input_password,
      confirmPassword: input_confirm_password,
      userType: input_user_type,
    }),
    success: () => {
      sessionStorage.removeItem("user_type");
      window.location = "login.php";
    },
    error: (xhr) => {
      error_validation(xhr);
    },
  });
});
