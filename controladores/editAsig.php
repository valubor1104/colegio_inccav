<?php
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_asig = $_POST['Id'];
    $carnet = $_POST['carnet'];
    $semestre = $_POST['semestre'];
    $noSalon = $_POST['noSalon'];
    $curso1 = $_POST['curso1'];

    // Actualiza la asignación en la tabla "asignacion"
    $query_actualizar_asignacion = "UPDATE asignacion SET  noSalon = $noSalon WHERE id_asig = $id_asig";
    
    if ($resultado = $conn->query($query_actualizar_asignacion)) {
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
}
?>
