<?php
require '../config/conexion.php';

    $grado = $_POST['grado'];
    

    $query = "insert into colegio_inccav.grado(grado) 
    values('" . $grado . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../views/formgrados.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../views/formgrados.php");
				</script>
			';
    }