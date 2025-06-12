$(document).ready(function () {
  var userType = sessionStorage.getItem('user_type');
  if (userType) {
    $('#form-user-type').val(userType);
  }
});
