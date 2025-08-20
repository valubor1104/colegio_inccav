<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="./estilos/estilo_login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                event.preventDefault();

                var usuario = $("#user").val();
                var password = $("#pass").val();

                $.ajax({
                    type: "POST",
                    url: "validar_conexion.php",
                    data: { user: usuario, pass: password },
                    success: function(response) {
                        if (response.trim() === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "¡Bienvenido!",
                                text: "Inicio de sesión exitoso",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "menu_principal.php";
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Usuario o contraseña incorrectos"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Error en la conexión con el servidor"
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
