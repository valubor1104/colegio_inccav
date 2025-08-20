<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $no_salon = $_POST['salon'];
    $sector = $_POST['sector'];;


$query = "UPDATE colegio_inccav.salon SET
    no_salon = '" . $no_salon . "',
    sector = '" . $sector . "' WHERE no_salon='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formsalon.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formsalon.php");
				</script>
			';
}