<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./estilos/estilo_login.css">
	<title>Inicio</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
	<div class="login" style="text-align: center;">
		<img src="./imagenes/logoprado.jpeg" width="200px" height="200px">
		<h1 class="estilo">Login</h1>
		<form id="loginForm" class="login-form">
			<input type="text" name="user" id="user" placeholder="Usuario" required />
			<input type="password" name="pass" id="pass" placeholder="Contraseña" required />
			<button type="submit" class="btn btn-primary btn-block btn-large">Ingresar</button>
		</form>
		<p id="mensaje" style="color: red; display: none;"></p>
	</div>

	<script>
		$(document).ready(function() {
			$("#loginForm").submit(function(event) {
				event.preventDefault(); // Evita el envío tradicional del formulario

				var usuario = $("#user").val();
				var password = $("#pass").val();

				$.ajax({
					type: "POST",
					url: "validar_conexion.php",
					data: {
						user: usuario,
						pass: password
					},
					success: function(response) {
						if (response.trim() === "success") {
							$("#mensaje").css("color", "green").text("Inicio de sesión exitoso").show();
							setTimeout(function() {
								window.location.href = "menu_principal.php";
							}, 2000);
						} else {
							$("#mensaje").css("color", "red").text("Usuario o contraseña incorrectos").show();
						}
					},
					error: function() {
						$("#mensaje").css("color", "red").text("Error en la conexión con el servidor").show();
					}
				});
			});
		});
	</script>
</body>

</html>