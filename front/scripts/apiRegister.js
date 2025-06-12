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
    data: {
      input_fullname,
      input_telephone,
      input_email,
      input_password,
      input_confirm_password,
      input_user_type,
    },
    success: (response) => {
      const modal = new bootstrap.Modal("#modal", {});
      $("#modal-title").html("Deu tudo certo");
      $("#modal-body").html(response);
      modal.show();
    },
    error: (response) => {
      error_validation(response);
    },
  });
});
