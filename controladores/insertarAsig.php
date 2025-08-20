<?php
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $carnet = $_POST['carnet'];
    $semestre = $_POST['semestre'];
    $noSalon = $_POST['noSalon'];

    if ($_POST['curso1'] != null) {
        $cursos[] = $_POST['curso1'];
    }

    if ($_POST['curso2'] != null) {
        $cursos[] = $_POST['curso2'];
    }

    if ($_POST['curso3'] != null) {
        $cursos[] = $_POST['curso3'];
    }

    if ($_POST['curso4'] != null) {
        $cursos[] = $_POST['curso4'];
    }

    if ($_POST['curso5'] != null) {
        $cursos[] = $_POST['curso5'];
    }

    if ($_POST['curso6'] != null) {
        $cursos[] = $_POST['curso6'];
    }


    /*$cursos[] = $_POST['curso2'];
    $cursos[] = $_POST['curso3'];
    $cursos[] = $_POST['curso4'];
    $cursos[] = $_POST['curso5'];
    $cursos[] = $_POST['curso6'];*/


    // Insertar en la tabla "asignacion" (maestro)
    $query_asignacion = "INSERT INTO asignacion (carnet, semestre, noSalon) VALUES (?, ?, ?)";
    $stmt_asignacion = $conn->prepare($query_asignacion);
    $stmt_asignacion->bind_param("iii", $carnet, $semestre, $noSalon);
    $stmt_asignacion->execute();

    // Obtener el ID de asignacion insertado
    $id_asig = $stmt_asignacion->insert_id;

    // Insertar en la tabla "asig_det" (detalle) con múltiples valores de curso1
    $query_asig_det = "INSERT INTO asig_det (id_asig, curso1) VALUES (?, ?)";
    $stmt_asig_det = $conn->prepare($query_asig_det);

    foreach ($cursos as $curso) {
        if ($curso === null) {
            break;
        }
        $stmt_asig_det->bind_param("is", $id_asig, $curso);
        $stmt_asig_det->execute();
    }

    // Cerrar las consultas preparadas
    $stmt_asignacion->close();
    $stmt_asig_det->close();

    // Redirigir o mostrar un mensaje de éxito
    echo '
				<script language="javascript">
					alert("Registro actualizado correctamente");
					window.location.replace("../views/formasignacion.php");
				</script>
			';
} else {
    echo '
				<script language="javascript">
					alert("Error al actualizar el registro");
					window.location.replace("../views/formasignacion.php");
				</script>
			';
}
?>