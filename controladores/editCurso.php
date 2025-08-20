<?php
require '../config/conexion.php';

    $id = $_POST['Id'];
    $idcurso = $_POST['idCurso'];
    $nombrecurso = $_POST['nombreCurso'];
    $id_cat = $_POST['id_cat'];


$query = "UPDATE colegio_inccav.curso SET
    id_curso = '" . $idcurso . "',
    descripcion = '" . $nombrecurso . "',
    id_cat = '" . $id_cat . "' WHERE id_curso='" . $id . "'";

if ($resultado = $conn->query($query)) {
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formcurso.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formcurso.php");
				</script>
			';
}