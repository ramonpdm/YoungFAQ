;(function ($) {
	"use strict"

	$("#loginForm").submit(function (e) {
		e.preventDefault()

		$("#loginForm .response").show()
		$("#loginForm .response").html('<div class="alert alert-info text-center">Validando...</div>')

		var loginForm = $("#loginForm").serialize()

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
	})

	$("#registerForm").submit(function (e) {
		e.preventDefault()

		$("#registerForm .response").css("display", "block")
		$("#registerForm .response").html('<div class="alert alert-info text-center">Validando...</div>')

		var registerForm = $("#registerForm").serialize()

		$.ajax({
			method: "POST",
			url: "register",
			data: registerForm,
			success: function (data) {
				$("#registerForm .response").html('<div class="alert alert-success text-center">Registro exitoso!</div>')

				setTimeout(function () {
					$("#registerModal").modal("toggle")
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
})(jQuery)
