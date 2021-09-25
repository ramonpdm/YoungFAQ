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
          url: "core/modules/actions",
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
      if ($("#content").val().length > 50) {
        $("#newtopicResponse").html(
          '<div class="alert alert-info text-center">Creando...</div>'
        );
        var newtopicForm = $("#newtopicForm").serialize();
        $.ajax({
          method: "POST",
          url: "core/modules/actions",
          data: newtopicForm,
          success: function (data) {
            setTimeout(function () {
              $("#newtopicResponse").html(data);
              $("#newtopicForm")[0].reset();
            }, 1000);
            setTimeout(function () {
              location.reload();
            }, 2000);
          },
        });
      } else {
        $("#newtopicResponse").html(
          '<div class="alert alert-danger text-center"><span>El contenido debe tener mínimo 50 carácteres.</span></div>'
        );
        setTimeout(function () {
          $("#newtopicResponse").html('');
        }, 2000);
      }
    }else{
      $("#newtopicResponse").html(
        '<div class="alert alert-danger text-center"><span>Completa todos los campos correctamente.</span></div>'
      );
      setTimeout(function () {
        $("#newtopicResponse").html('');
      }, 2000);
    }
  });

  $(document).on("click", "#commentBtn", function () {
    $("#commentForm").submit(function (e) {
      e.preventDefault();
    });
    if ($(".commentContent").val() != "") {
      $("#commentResponse").html(
        '<div class="alert alert-info text-center">Creando...</div>'
      );
      var commentForm = $("#commentForm").serialize();
      $.ajax({
        method: "POST",
        url: "core/modules/actions",
        data: commentForm,
        success: function (data) {
          setTimeout(function () {
            $("#commentResponse").html(data);
            $("#commentForm")[0].reset();
          }, 500);
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });

  $(document).on("click", "#approveTopicBtn", function () {
    var id = $(this).data("id");
    if (confirm("¿Deseas aprobar esta publicación?")) {
      $("#forumResponse").html(
        '<div class="alert alert-info text-center">Creando...</div>'
      );
      $.ajax({
        method: "POST",
        url: "core/modules/actions",
        data: {
          id_topic: id,
          action: "approved",
          reason: "",
        },
        success: function (data) {
          setTimeout(function () {
            $("#forumResponse").html(data);
          }, 500);
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });

  $(document).on("click", "#removeTopicBtn", function () {
    var id = $(this).data("id");
    if (confirm("¿Deseas eliminar permanentemente esta publicación?")) {
      $("#forumResponse").html(
        '<div class="alert alert-info text-center">Eliminando...</div>'
      );
      $.ajax({
        method: "POST",
        url: "core/modules/actions",
        data: { id_topic: id, action: "remove" },
        success: function (data) {
          setTimeout(function () {
            $("#forumResponse").html(data);
          }, 500);
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });

  $(document).on("click", "#refuseTopicBtn", function () {
    if ($("#refuseReason").val() != "") {
      var reason = $("#refuseReason").val();
      var id = $(this).data("id");
      $("#forumResponse").html(
        '<div class="alert alert-info text-center">Rechazando...</div>'
      );
      $.ajax({
        method: "POST",
        url: "core/modules/actions",
        data: {
          id_topic: id,
          action: "refused",
          reason: reason,
        },
        success: function (data) {
          setTimeout(function () {
            $("#forumResponse").html(data);
          }, 500);
          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });

  $(document).on("keyup", "#searchInput", function () {
    var str = $("#searchInput").val();
    if (str.length == 0) {
      document.getElementById("searchResponse").innerHTML = "";
      return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("searchResponse").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "core/modules/search?q=" + str, true);
    xmlhttp.send();
  });

  $(window).on("resize", function () {
    var win = $(this);
    if (win.width() < 990) {
      $(".full-col").removeClass("col-sm-8");
      $(".full-col").addClass("col-sm-12");
    } else {
      $(".full-col").addClass("col-sm-8");
      $(".full-col").removeClass("col-sm-12");
    }
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
})(jQuery);
