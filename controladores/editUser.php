<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $nombreU = $_POST['nombre'];
    $userU = $_POST['user'];
    $claveU = $_POST["clave"];
    $rolU = $_POST['rol'];


$query = "UPDATE colegio_inccav.usuario SET
    nombre = '" . $nombreU . "',
    nombre_usuario = '" . $userU . "',
    clave = '" . $claveU . "',
    rol = '" . $rolU . "' WHERE id_usuario ='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../menu_principal.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../menu_principal.php");
				</script>
			';
}