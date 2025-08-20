<?php
require '../config/conexion.php';

    $carnet = $_POST['carnet'];
    $fecha = $_POST["fecha"];
    $estado = $_POST['estado'];
    $id_curso = $_POST['id_curso'];
    

    $query = "insert into colegio_inccav.asistencia(carnet, fecha, estado, id_curso) 
    values('" . $carnet . "', '" . $fecha. "','" . $estado. "','" . $id_curso . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../views/formAsistencia.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../views/formAsistencia.php");
				</script>
			';
    }


