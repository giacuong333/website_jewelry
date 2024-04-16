$(document).ready(function () {
  const config = {
    enableTime: false,
    dateFormat: "Y-m-d",
  };

  flatpickr("input[type=datetime-local]", config);
});
