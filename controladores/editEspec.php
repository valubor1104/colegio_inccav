<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $idespec = $_POST['IdEspec'];
    $Desc = $_POST['desc'];;


$query = "UPDATE colegio_inccav.especialidad SET
    id_espec = '" . $idespec . "',
    descripcion = '" . $Desc . "' WHERE id_espec='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/especialidades.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/especialidades.php");
				</script>
			';
}