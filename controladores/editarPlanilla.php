<?php
include_once(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    // Recibimos solo la fecha (YYYY-MM-DD) y añadimos la hora del servidor
    if (isset($_POST['fecha']) && $_POST['fecha'] !== '') {
        $fechaOnly = $_POST['fecha'];
        $horaNow = date('H:i:s');
        $fecha = $fechaOnly . ' ' . $horaNow;
    } else {
        $fecha = null;
    }
    $descripcion = trim($_POST['descripcion'] ?? '');
    $monto = isset($_POST['monto']) ? (float)$_POST['monto'] : 0.00;
    $metodopago = isset($_POST['metodopago']) ? (int)$_POST['metodopago'] : 0;
    $observaciones = trim($_POST['observaciones'] ?? '');

    $stmt = $conn->prepare("UPDATE planilla SET fecha = ?, descripcion = ?, monto = ?, metodopago = ?, observaciones = ? WHERE id = ?");
    if ($stmt === false) {
        header("Location: ../views/editarPlanilla.php?id={$id}&msg=error");
        exit;
    }
    $stmt->bind_param("ssdisi", $fecha, $descripcion, $monto, $metodopago, $observaciones, $id);

    if ($stmt->execute()) {
        header("Location: ../views/planillaLista.php?msg=updated");
        exit;
    } else {
        header("Location: ../views/editarPlanilla.php?id={$id}&msg=error");
        exit;
    }
}
?>
