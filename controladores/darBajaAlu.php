<?php
require '../config/conexion.php';

if (isset($_GET['Id'])) {
    $carnet = $_GET['Id'];

    $sql = "CALL sp_dar_de_baja_alumno(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $carnet);

    if ($stmt->execute()) {
        echo '
            <script language="javascript">
                alert("Alumno dado de baja correctamente");
                window.location.replace("../views/formalumno.php");
            </script>
        ';
    } else {
        echo '
            <script language="javascript">
                alert("Error al dar de baja al alumno");
                window.location.replace("../views/formalumno.php");
            </script>
        ';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '
        <script language="javascript">
            alert("Error: no se recibió el carnet");
            window.location.replace("../views/formalumno.php");
        </script>
    ';
}
?>
