;(function ($) {
	"use strict"

	$("#loginForm").submit(function (e) {
		e.preventDefault()

		$("#loginForm .response").show()
		$("#loginForm .response").html('<div class="alert alert-info text-center">Validando...</div>')

		var loginForm = $("#loginForm").serialize()

		setTimeout(function () {
			$.ajax({
				method: "POST",
				url: "login",
				data: loginForm,
				success: function (data) {
					$("#loginForm .response").html('<div class="alert alert-success text-center">¡Inicio de sesión exitoso!</div>')

					setTimeout(function () {
						$("#loginModal").modal("toggle")
						location.reload()
					}, 500)
				},
				error: function (error) {
					try {
						var data = JSON.parse(error.responseText)
						$("#loginForm .response").html('<div class="alert alert-danger text-center">' + data.message + "</div>")
					} catch (error) {
						$("#loginForm .response").html('<div class="alert alert-danger text-center">' + error + "</div>")
					}
				},
			})
		}, 500)
	})

	$(document).on("click", "#registerBtn", function () {
		$("#registerForm").submit(function (e) {
			e.preventDefault()
		})
		if ($("#usernameReg").val() != "" && $("#fullnameReg").val() != "" && $("#emailReg").val() != "" && $("#passwordReg").val() != "") {
			$("#registerResponse").css("display", "block")
			$("#registerResponse").html('<div class="alert alert-info text-center">Validando...</div>')

			var loginForm = $("#registerForm").serialize()
			setTimeout(function () {
				$.ajax({
					method: "POST",
					url: "core/modules/actions",
					data: loginForm,
					success: function (data) {
						if (data == "") {
							$("#registerResponse").html('<div class="alert alert-success text-center">Registro exitoso!</div>')
							setTimeout(function () {
								$("#registerModal").modal("hide")
								$("#loginModal").modal("show")
							}, 600)
						} else {
							$("#registerResponse").html(data)
						}
					},
				})
			}, 500)
		} else {
			$("#registerResponse").html('<div class="alert alert-danger text-center">Debes completar el formulario correctamente.</div>')
		}
	})

	$("#newtopicForm").submit(function (e) {
		e.preventDefault()

		$("#newtopicWrap .response").html('<div class="alert alert-info text-center">Creando...</div>')

		var newtopicForm = $("#newtopicForm").serialize()

		$.ajax({
			method: "POST",
			url: "topic",
			data: newtopicForm,
			success: function (data) {
				$("#newtopicWrap .response").html('<div class="alert alert-success text-center">¡Publicación creada!</div>')

				setTimeout(function () {
					// $("#newtopicWrap").html(data)
					// $("#newtopicForm")[0].reset()
				}, 1000)
				
				setTimeout(function () {
					// location.reload()
				}, 2000)
			},
			error: function (error) {
				try {
					var data = JSON.parse(error.responseText)
					$("#newtopicWrap .response").html('<div class="alert alert-danger text-center">' + data.message + "</div>")
				} catch (error) {
					$("#newtopicWrap .response").html('<div class="alert alert-danger text-center">' + error + "</div>")
				}
			},
		})
	})

	$(document).on("click", "#commentBtn", function () {
		$("#commentForm").submit(function (e) {
			e.preventDefault()
		})
		if ($(".commentContent").val() != "") {
			$("#commentResponse").html('<div class="alert alert-info text-center">Creando...</div>')
			var commentForm = $("#commentForm").serialize()
			$.ajax({
				method: "POST",
				url: "core/modules/actions",
				data: commentForm,
				success: function (data) {
					setTimeout(function () {
						$("#commentResponse").html(data)
						$("#commentForm")[0].reset()
					}, 500)
					setTimeout(function () {
						location.reload()
					}, 1000)
				},
			})
		}
	})

	$(document).on("click", ".approveBtn", function () {
		var id = $(this).data("id")
		var divResponse = $(this).data("response")
		var typeOBject = $(this).data("type")
		if (confirm("¿Deseas aprobar este objeto?")) {
			$(divResponse).html('<div class="alert alert-info text-center">Creando...</div>')
			$.ajax({
				method: "POST",
				url: "core/modules/actions",
				data: {
					id_object: id,
					action: "approved",
					reason: "",
					type: typeOBject,
				},
				success: function (data) {
					setTimeout(function () {
						$(divResponse).html(data)
					}, 500)
					setTimeout(function () {
						location.reload()
					}, 1000)
				},
			})
		}
	})

	$(document).on("click", ".removeBtn", function () {
		var id = $(this).data("id")
		var divResponse = $(this).data("response")
		var typeOBject = $(this).data("type")
		if (confirm("¿Deseas eliminar permanentemente este objeto?")) {
			$(divResponse).html('<div class="alert alert-info text-center">Eliminando...</div>')
			$.ajax({
				method: "POST",
				url: "core/modules/actions",
				data: {
					id_object: id,
					action: "remove",
					type: typeOBject,
				},
				success: function (data) {
					setTimeout(function () {
						$(divResponse).html(data)
					}, 500)
					setTimeout(function () {
						location.reload()
					}, 1000)
				},
			})
		}
	})

	$(document).on("click", "#refuseTopicBtn", function () {
		if ($("#refuseReason").val() != "") {
			var reason = $("#refuseReason").val()
			var id = $(this).data("id")
			$("#forumResponse").html('<div class="alert alert-info text-center">Rechazando...</div>')
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
						$("#forumResponse").html(data)
					}, 500)
					setTimeout(function () {
						location.reload()
					}, 1000)
				},
			})
		}
	})

	$(document).on("keyup", "#searchInput", function () {
		var str = $("#searchInput").val()
		if (str.length == 0) {
			document.getElementById("searchResponse").innerHTML = ""
			return
		}
		var xmlhttp = new XMLHttpRequest()
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("searchResponse").innerHTML = this.responseText
			}
		}
		xmlhttp.open("GET", "core/modules/search?q=" + str, true)
		xmlhttp.send()
	})

	$(window).on("resize", function () {
		var win = $(this)
		if (win.width() < 990) {
			$(".full-col").removeClass("col-sm-8")
			$(".full-col").addClass("col-sm-12")
		} else {
			$(".full-col").addClass("col-sm-8")
			$(".full-col").removeClass("col-sm-12")
		}
	})
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
})(jQuery)
