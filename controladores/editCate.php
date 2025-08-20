<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $idcate = $_POST['idCate'];
    $nombreCA = $_POST['nombre'];
    $apellidoCA = $_POST['apellido'];
    $especialidadCA = $_POST['espec'];
    $estadoCA = $_POST['estado'];


$query = "UPDATE colegio_inccav.catedratico SET
    id_cat = '" . $idcate . "',
    nombre = '" . $nombreCA . "',
    apellido = '" . $apellidoCA . "',
    especialidad = '" . $especialidadCA . "',
    estado = '" . $estadoCA . "' WHERE id_cat='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formcatedratico.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formcatedratico.php");
				</script>
			';
}