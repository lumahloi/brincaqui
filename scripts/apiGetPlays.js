$(document).ready(() => {
  const pagination = createPlayPagination((params, onSuccess, onError) => {
    $.ajax({
      type: "GET",
      url: SERVER_URL + "play",
      data: params,
      success: onSuccess,
      error: (xhr) => {
        error_validation(xhr);
        onError();
      },
    });
  });
  pagination.init();
});
