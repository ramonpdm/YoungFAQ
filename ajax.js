(function ($) {
    $(document).on("click", "#loginbutton", function () {
        $("#logform").submit(function(e){e.preventDefault();});
        if ($("#username").val() != "" && $("#password").val() != "") {
          $("#loginText").css('display', 'block');
          $("#loginText").text("Logging in...");
          var logform = $("#logform").serialize();
          setTimeout(function () {
            $.ajax({
              method: "POST",
              url: "loginhp",
              data: logform,
              success: function (data) {
                if (data == "") {
                  $("#myalert").slideDown();
                  $("#alerttext").text("Login Successful. User Verified!");
                  $("#logtext").text("Login");
                  
                //   setTimeout(function () {
                //     location.reload();
                //   }, 2000);
                } else {
                  $("#loginText").text(data);
                  
                }
              },
            });
          }, 500);
        } else {
          alert("Please input both fields to Login");
        }
      });
})(jQuery);