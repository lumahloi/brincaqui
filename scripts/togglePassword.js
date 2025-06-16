$(".toggle-password").on("click", function () {
  const input = $($(this).attr("data-target"));
  const icon = $(this);
  if (input.attr("type") === "password") {
    input.attr("type", "text");
    icon.removeClass("bi-eye").addClass("bi-eye-slash");
  } else {
    input.attr("type", "password");
    icon.removeClass("bi-eye-slash").addClass("bi-eye");
  }
});
