<?php
require '../config/conexion.php';

    $nombreU = $_POST['nombre'];
    $userU = $_POST['user'];
    $claveU = $_POST["clave"];
    $rolU = $_POST['rol'];
    

    $query = "insert into colegio_inccav.usuario(nombre, nombre_usuario, clave, rol) 
    values('" . $nombreU . "', '" . $userU . "', '" . $claveU . "','" . $rolU . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../menu_principal.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../menu_principal.php");
				</script>
			';
    }