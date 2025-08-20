<?php
require '../config/conexion.php';

$id = $_POST['Id'];
$carnetA = $_POST['carnet'];
$nombreA = $_POST['nombre'];
$apellidoA = $_POST['apellido'];
$descripcionA = $_POST['descripcion'];
$estadoA = $_POST['estado'];


$query = "UPDATE colegio_inccav.alumno SET
    carnet = '" . $carnetA . "',
    nombre = '" . $nombreA . "',
    apellido = '" . $apellidoA . "',
    descripcion = '" . $descripcionA . "',
    estado = '" . $estadoA . "' WHERE carnet='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formalumno.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formalumno.php");
				</script>
			';
}