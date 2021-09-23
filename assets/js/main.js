(function ($) {
  "use strict";

  $(document).on("click", "#loginBtn", function () {
    $("#loginForm").submit(function (e) {
      e.preventDefault();
    });
    if ($("#username").val() != "" && $("#password").val() != "") {
      $("#loginResponse").css("display", "block");
      $("#loginResponse").html(
        '<div class="alert alert-info text-center">Validando...</div>'
      );

      var loginForm = $("#loginForm").serialize();
      setTimeout(function () {
        $.ajax({
          method: "POST",
          url: "core/modules/login",
          data: loginForm,
          success: function (data) {
            if (data == "") {
              $("#loginResponse").html(
                '<div class="alert alert-success text-center">Inicio de Sesión exitoso!</div>'
              );
              setTimeout(function () {
                $("#loginModal").modal("toggle");
              }, 500);
              setTimeout(function () {
                location.reload();
              }, 600);
            } else {
              $("#loginResponse").html(data);
            }
          },
        });
      }, 500);
    }
  });

  $(document).on("click", "#newtopicBtn", function () {
    $("#newtopicForm").submit(function (e) {
      e.preventDefault();
    });
    if ($("#title").val() != "" && $("#content").val() != "") {
      $("#newtopicResponse").html(
        '<div class="alert alert-info text-center">Creando...</div>'
      );
      var newtopicForm = $("#newtopicForm").serialize();
      $.ajax({
        method: "POST",
        url: "core/modules/newtopic",
        data: newtopicForm,
        success: function (data) {
          setTimeout(function () {
            $("#newtopicResponse").html(data);
            $("#newtopicForm")[0].reset();
          }, 2000);
        },
      });
    }
  });

  $(document).on("click", "#commentBtn", function () {
    
    $("#commentForm").submit(function (e) {
      e.preventDefault();
    });
    if ($("#commentContent").val() != "") {
      $("#forumResponse").html(
        '<div class="alert alert-info text-center">Creando...</div>'
      );
      var commentForm = $("#commentForm").serialize();
      $.ajax({
        method: "POST",
        url: "core/modules/comment",
        data: commentForm,
        success: function (data) {
          setTimeout(function () {
            $("#forumResponse").html(data);
            $("#commentForm")[0].reset();
          }, 2000);
          setTimeout(function () {
                location.reload();
              }, 700);
        },
      });
    } 
  });

  /*==================================================================
    [ Validate ]*/
  var input = $(".validate-input .input100");

  $(".validate-form").on("submit", function () {
    var check = true;

    for (var i = 0; i < input.length; i++) {
      if (validate(input[i]) == false) {
        showValidate(input[i]);
        check = false;
      }
    }

    return check;
  });

  $(".validate-form .input100").each(function () {
    $(this).focus(function () {
      hideValidate(this);
    });
  });

  function validate(input) {
    if ($(input).attr("type") == "email" || $(input).attr("name") == "email") {
      if (
        $(input)
          .val()
          .trim()
          .match(
            /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/
          ) == null
      ) {
        return false;
      }
    } else {
      if ($(input).val().trim() == "") {
        return false;
      }
    }
  }

  function showValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass("alert-validate");
  }

  function hideValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).removeClass("alert-validate");
  }

  if (!window.matchMedia) return;
  var current = $('head > link[rel="icon"][media]');
  $.each(current, function (i, icon) {
    var match = window.matchMedia(icon.media);

    function swap() {
      if (match.matches) {
        current.remove();
        current = $(icon).appendTo("head");
      }
    }
    match.addListener(swap);
    swap();
  });

  var height = $("#postcontent").height();
  $("#postinfo").css("height", height + "px");
})(jQuery);
