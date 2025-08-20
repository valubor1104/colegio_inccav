<?php
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $id = $_POST['id'];
    $carnet = $_POST['carnet'];
    $semestre = $_POST['semestre'];

    // Insertar en la tabla "calificaciones" (maestro)
    $query_calificaciones = "INSERT INTO calificaciones (carnet, semestre) VALUES (?, ?)";
    $stmt_calificaciones = $conn->prepare($query_calificaciones);
    $stmt_calificaciones->bind_param("ii", $carnet, $semestre);
    $stmt_calificaciones->execute();

    // Obtener el ID de calificaciones insertado
    $id_calificacion = $stmt_calificaciones->insert_id;

    // Inicializar los arrays de cursos y notas
    for ($i = 1; $i <= 5; $i++) {
        $cursos[] = $_POST['curso' . $i];
        $notas[] = $_POST['nota' . $i];
    }

    // Insertar en la tabla "calificaciones_det" (detalle) con múltiples valores de cursos y notas
    $query_calificaciones_det = "INSERT INTO calificaciones_det (id_nota, curso, nota) VALUES (?, ?, ?)";
    $stmt_calificaciones_det = $conn->prepare($query_calificaciones_det);

    for ($i = 0; $i < count($cursos); $i++) {
        $curso = $cursos[$i];
        $nota = $notas[$i];

        $stmt_calificaciones_det->bind_param("iis", $id_calificacion, $curso, $nota);
        $stmt_calificaciones_det->execute();
    }

    // Cerrar las consultas preparadas
    $stmt_calificaciones->close();
    $stmt_calificaciones_det->close();

    // Redirigir o mostrar un mensaje de éxito
    echo '
    <script language="javascript">
        alert("Registro actualizado correctamente");
        window.location.replace("../views/formnota.php");
    </script>
';
}else {
    echo '
        <script language="javascript">
            alert("Error al actualizar el registro");
            window.location.replace("../views/formnota.php");
        </script>
    ';
}
?>