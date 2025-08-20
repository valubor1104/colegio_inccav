<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $grado = $_POST['grado'];;


$query = "UPDATE colegio_inccav.grado SET
    grado = '" . $grado . "' WHERE id='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formgrados.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formgrados.php");
				</script>
			';
}