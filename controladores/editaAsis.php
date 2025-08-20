<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $estado = $_POST['estado'];;


$query = "UPDATE colegio_inccav.asistencia SET
    estado = '" . $estado . "' WHERE id_asis='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formAsistencia.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formAsistencia.php");
				</script>
			';
}