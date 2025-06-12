$("#btn-register-type1").click(function () {
  sessionStorage.setItem("user_type", "1");
  window.location.href = "register.php";
});

$("#btn-register-type2").click(function () {
  sessionStorage.setItem("user_type", "2");
  window.location.href = "register.php";
});
