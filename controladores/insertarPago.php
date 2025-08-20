<?php
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $carnet = $_POST['carnet'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Insertar en la tabla maestro (cobros)
        $query_cobros = "INSERT INTO cobros (carnet, fecha) VALUES (?, ?)";
        $stmt_cobros = $conn->prepare($query_cobros);
        $stmt_cobros->bind_param("is", $carnet, $fecha);
        $stmt_cobros->execute();

        // Obtener el ID del último insert en la tabla maestro
        $id_pago = $stmt_cobros->insert_id;

        // Insertar en la tabla detalle (cobros_det)
        $query_cobros_det = "INSERT INTO cobros_det (id_pago, descripcion, monto) VALUES (?, ?, ?)";
        $stmt_cobros_det = $conn->prepare($query_cobros_det);
        $stmt_cobros_det->bind_param("iss", $id_pago, $descripcion, $monto);
        $stmt_cobros_det->execute();

        // Confirmar la transacción
        $conn->commit();

        echo '
            <script language="javascript">
                alert("Registro actualizado correctamente");
                window.location.replace("../views/formcobros.php");
            </script>
        ';
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo '
            <script language="javascript">
                alert("Error al actualizar el registro");
                window.location.replace("../views/formcobros.php");
            </script>
        ';
    }

    // Cerrar las consultas preparadas
    $stmt_cobros->close();
    $stmt_cobros_det->close();

    // Cerrar la conexión
    $conn->close();
} else {
    echo '
        <script language="javascript">
            alert("Error al actualizar el registro");
            window.location.replace("http://localhost/inccav/views/formcobros.php");
        </script>
    ';
}
?>
