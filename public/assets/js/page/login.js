$(document).ready(function () {
  $(".formlogin").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "post",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function () {
        $("#login").attr("disabled", true);
        $("#login").html(
          '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
        );
      },
      complete: function () {
        $("#login").removeAttr("disabled", false);
        $("#login").html("Login");
      },
      success: function (response) {
        if (response.success == false) {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error",
            showConfirmButton: false,
            timer: 1350,
          });
        }
        if (response.success == true) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: response.data.icon,
            showConfirmButton: false,
            timer: 1250,
          }).then(function () {
            window.location = response.data.link;
          });
        }
      },
    });
    return false;
  });
});
