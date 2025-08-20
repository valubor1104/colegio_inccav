<?php
require '../config/conexion.php';

    $no_salon = $_POST['salon'];
    $sector = $_POST['sector'];
    

    $query = "insert into colegio_inccav.salon(no_salon, sector) 
    values('" . $no_salon . "', '" . $sector . "')";
    $resultado = mysqli_query($conn, $query);
    if ($resultado == 1) {
    echo '
				<script language="javascript">
					alert("Registro creado correctamente");
					window.location.replace("../views/formsalon.php");
				</script>
			';
    } else {
    echo '
				<script language="javascript">
					alert("Error al  crear el registro");
					window.location.replace("../views/formsalon.php");
				</script>
			';
    }